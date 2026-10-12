<?php

use App\Livewire\Auth\Login;
use App\Models\OAuthClient;
use App\Models\User;
use App\Services\TwoFactorService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use PragmaRX\Google2FA\Google2FA;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->twoFactorService = app(TwoFactorService::class);
    $this->google2fa = new Google2FA();

    OAuthClient::create([
        'name' => 'RSUD Tarakan Personal Access Client',
        'client_id' => 'personal-access-client-id',
        'client_secret' => Hash::make('secret'),
        'redirect_uris' => ['http://localhost'],
        'personal_access_client' => true,
        'provider' => 'users',
        'grant_types' => ['personal_access'],
    ]);
});

test('TwoFactorService generates 100 percent offline SVG QR code', function () {
    $user = User::create([
        'name' => 'Offline User',
        'username' => 'offline.user',
        'email' => 'offline@tarakan.local',
        'password' => Hash::make('password123'),
    ]);

    $secret = $this->twoFactorService->generateSecretKey();
    expect($secret)->toBeString()->not->toBeEmpty();

    $otpAuthUrl = $this->twoFactorService->getOtpAuthUrl($user, $secret);
    expect($otpAuthUrl)->toContain('otpauth://totp/');

    $svg = $this->twoFactorService->getQrCodeSvg($otpAuthUrl);
    // Assert it is pure local vector SVG without external API or image dependencies
    expect($svg)->toContain('<svg')->toContain('</svg>');
    expect($svg)->not->toContain('chart.googleapis.com')->not->toContain('<img');
});

test('2FA setup and confirmation works with valid TOTP code', function () {
    $user = User::create([
        'name' => 'Dr. Test',
        'username' => 'dr.test',
        'email' => 'dr.test@tarakan.local',
        'password' => Hash::make('password123'),
    ]);

    $secret = $this->twoFactorService->generateSecretKey();
    $validCode = $this->google2fa->getCurrentOtp($secret);

    $confirmed = $this->twoFactorService->confirm($user, $secret, $validCode);
    expect($confirmed)->toBeTrue();

    $user->refresh();
    expect($user->hasTwoFactorEnabled())->toBeTrue()
        ->and($user->two_factor_confirmed_at)->not->toBeNull()
        ->and($user->two_factor_recovery_codes)->toHaveCount(8);
});

test('2FA verification succeeds with TOTP code and burns recovery codes upon use', function () {
    $user = User::create([
        'name' => 'Nurse Test',
        'username' => 'nurse.test',
        'email' => 'nurse.test@tarakan.local',
        'password' => Hash::make('password123'),
    ]);

    $secret = $this->twoFactorService->generateSecretKey();
    $validCode = $this->google2fa->getCurrentOtp($secret);
    $recoveryCodes = ['REC-001-AAA', 'REC-002-BBB'];

    $this->twoFactorService->confirm($user, $secret, $validCode, $recoveryCodes);
    $user->refresh();

    // 1. Valid TOTP code verifies
    expect($this->twoFactorService->verify($user, $validCode))->toBeTrue();

    // 2. Invalid code fails
    expect($this->twoFactorService->verify($user, '999999'))->toBeFalse();

    // 3. Valid recovery code verifies and gets consumed
    expect($this->twoFactorService->verify($user, 'REC-001-AAA'))->toBeTrue();

    $user->refresh();
    expect($user->two_factor_recovery_codes)->not->toContain('REC-001-AAA')
        ->and($user->two_factor_recovery_codes)->toContain('REC-002-BBB');

    // 4. Already used recovery code cannot be reused
    expect($this->twoFactorService->verify($user, 'REC-001-AAA'))->toBeFalse();
});

test('API login triggers 2FA challenge when user has 2FA enabled', function () {
    $user = User::create([
        'name' => '2FA Enabled User',
        'username' => 'user.2fa',
        'email' => 'user2fa@tarakan.local',
        'password' => Hash::make('password123'),
    ]);

    $secret = $this->twoFactorService->generateSecretKey();
    $validCode = $this->google2fa->getCurrentOtp($secret);
    $this->twoFactorService->confirm($user, $secret, $validCode);

    // Initial login attempt
    $response = $this->postJson('/api/login', [
        'username' => 'user.2fa',
        'password' => 'password123',
    ]);

    $response->assertStatus(202)
        ->assertJson([
            'status' => 'success',
            'data' => [
                'two_factor_required' => true,
            ],
        ]);

    $twoFactorToken = $response->json('data.two_factor_token');
    expect($twoFactorToken)->not->toBeNull();

    // Verify 2FA with invalid code fails
    $failResponse = $this->postJson('/api/verify-2fa', [
        'two_factor_token' => $twoFactorToken,
        'code' => '000000',
    ]);
    $failResponse->assertStatus(422);

    // Verify 2FA with current valid TOTP succeeds
    $currentCode = $this->google2fa->getCurrentOtp($secret);
    $successResponse = $this->postJson('/api/verify-2fa', [
        'two_factor_token' => $twoFactorToken,
        'code' => $currentCode,
    ]);

    $successResponse->assertOk()
        ->assertJsonPath('data.user.username', 'user.2fa')
        ->assertJsonStructure(['data' => ['access_token']]);
});

test('Livewire Login component prompts for 2FA when enabled and logs in upon valid code', function () {
    $user = User::create([
        'name' => 'Web 2FA User',
        'username' => 'web2fa',
        'email' => 'web2fa@tarakan.local',
        'password' => Hash::make('password123'),
    ]);

    $secret = $this->twoFactorService->generateSecretKey();
    $validCode = $this->google2fa->getCurrentOtp($secret);
    $this->twoFactorService->confirm($user, $secret, $validCode);

    Livewire::test(Login::class)
        ->set('username', 'web2fa')
        ->set('password', 'password123')
        ->call('authenticate')
        ->assertSet('step', '2fa')
        ->assertSet('pendingUserId', $user->id)
        ->set('twoFactorCode', '000000')
        ->call('verifyTwoFactor')
        ->assertHasErrors(['twoFactorCode'])
        ->set('twoFactorCode', $this->google2fa->getCurrentOtp($secret))
        ->call('verifyTwoFactor')
        ->assertHasNoErrors()
        ->assertRedirect(route('filament.admin.pages.dashboard'));

    $this->assertAuthenticatedAs($user);
});

test('2FA API endpoints status, setup, confirm, and disable work with FormRequests and Resources', function () {
    $user = User::create([
        'name' => 'API 2FA User',
        'username' => 'api.2fa',
        'email' => 'api2fa@tarakan.local',
        'password' => Hash::make('password123'),
    ]);

    // 1. Initial Status: not enabled
    $statusResponse = $this->actingAs($user, 'api')->getJson('/api/2fa/status');
    $statusResponse->assertOk()
        ->assertJsonPath('data.enabled', false)
        ->assertJsonPath('data.has_recovery_codes', false);

    // 2. Setup: returns secret, otpauth_url, pure SVG, recovery codes
    $setupResponse = $this->actingAs($user, 'api')->postJson('/api/2fa/setup');
    $setupResponse->assertOk()
        ->assertJsonStructure([
            'status',
            'data' => [
                'secret',
                'otpauth_url',
                'qr_code_svg',
                'recovery_codes',
            ],
        ]);

    $secret = $setupResponse->json('data.secret');
    $recoveryCodes = $setupResponse->json('data.recovery_codes');
    $otpAuthUrl = $setupResponse->json('data.otpauth_url');
    $qrSvg = $setupResponse->json('data.qr_code_svg');

    expect($otpAuthUrl)->toContain('otpauth://totp/')
        ->and($qrSvg)->toContain('<svg')
        ->and($recoveryCodes)->toHaveCount(8);

    // 3. Confirm with valid code
    $validCode = $this->google2fa->getCurrentOtp($secret);
    $confirmResponse = $this->actingAs($user, 'api')->postJson('/api/2fa/confirm', [
        'secret' => $secret,
        'code' => $validCode,
        'recovery_codes' => $recoveryCodes,
    ]);

    $confirmResponse->assertOk()
        ->assertJsonPath('data.enabled', true);

    $user->refresh();
    expect($user->hasTwoFactorEnabled())->toBeTrue();

    // 4. Disable with incorrect password fails
    $failDisable = $this->actingAs($user, 'api')->postJson('/api/2fa/disable', [
        'password' => 'wrongpassword',
    ]);
    $failDisable->assertStatus(403);
    expect($user->fresh()->hasTwoFactorEnabled())->toBeTrue();

    // 5. Disable with correct password succeeds
    $successDisable = $this->actingAs($user, 'api')->postJson('/api/2fa/disable', [
        'password' => 'password123',
    ]);
    $successDisable->assertOk()
        ->assertJsonPath('data.enabled', false);

    expect($user->fresh()->hasTwoFactorEnabled())->toBeFalse();
});
