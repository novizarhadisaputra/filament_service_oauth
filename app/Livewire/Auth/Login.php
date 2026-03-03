<?php

namespace App\Livewire\Auth;

use App\Models\OAuthClient;
use Illuminate\Support\Facades\Auth;
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
        $this->validate();

        // Check if the input is an email or username
        $fieldType = filter_var($this->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$fieldType => $this->username, 'password' => $this->password], $this->remember)) {
            session()->regenerate();

            // Redirect to intended URL (e.g. Passport authorization) or fallback to dashboard
            return redirect()->intended(route('filament.admin.pages.dashboard'));
        }

        $this->addError('username', trans('auth.failed'));
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
