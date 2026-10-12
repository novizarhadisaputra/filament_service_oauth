<?php

namespace App\Livewire\Auth;

use App\Models\OAuthClient;
use App\Models\User;
use App\Services\TwoFactorService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Login')]
#[Layout('components.layouts.guest')]
class Login extends Component
{
    #[Validate('required|string')]
    public string $username = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;
    
    public ?string $appName = null;

    public string $step = 'login'; // 'login' or '2fa'

    public string $twoFactorCode = '';

    public ?string $pendingUserId = null;

    public function mount()
    {
        $intendedUrl = session()->get('url.intended');

        if ($intendedUrl && Str::contains($intendedUrl, '/oauth/authorize')) {
            $query = parse_url($intendedUrl, PHP_URL_QUERY);
            if ($query) {
                parse_str($query, $params);
                if (isset($params['client_id'])) {
                    $client = OAuthClient::where('client_id', $params['client_id'])->first();
                    if ($client) {
                        $this->appName = $client->name;
                    }
                }
            }
        }
    }

    public function authenticate()
    {
        $this->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Check if the input is an email or username
        $fieldType = filter_var($this->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = User::where($fieldType, $this->username)->first();

        if (! $user || ! Hash::check($this->password, $user->password)) {
            $this->addError('username', trans('auth.failed'));
            return;
        }

        // Check if user has 2FA enabled
        if ($user->hasTwoFactorEnabled()) {
            $this->step = '2fa';
            $this->pendingUserId = $user->id;
            $this->password = ''; // Clear sensitive input
            return;
        }

        Auth::login($user, $this->remember);
        session()->regenerate();

        // Redirect to intended URL (e.g. Passport authorization) or fallback to dashboard
        return redirect()->intended(route('filament.admin.pages.dashboard'));
    }

    public function verifyTwoFactor(TwoFactorService $twoFactorService)
    {
        $this->validate([
            'twoFactorCode' => 'required|string|min:6|max:20',
        ]);

        $user = User::find($this->pendingUserId);

        if (! $user) {
            $this->step = 'login';
            $this->addError('username', 'Sesi login kedaluwarsa. Silakan masuk kembali.');
            return;
        }

        if (! $twoFactorService->verify($user, $this->twoFactorCode)) {
            $this->addError('twoFactorCode', 'Kode 2FA tidak valid atau sudah kedaluwarsa.');
            return;
        }

        Auth::login($user, $this->remember);
        session()->regenerate();

        return redirect()->intended(route('filament.admin.pages.dashboard'));
    }

    public function backToLogin()
    {
        $this->step = 'login';
        $this->twoFactorCode = '';
        $this->pendingUserId = null;
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
