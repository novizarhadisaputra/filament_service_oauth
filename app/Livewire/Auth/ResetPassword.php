<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

/**
 * Class ResetPassword
 *
 * Reset Password.
 */
#[Title('Reset Password')]
#[Layout('components.layouts.guest')]
class ResetPassword extends Component
{
    public string $token;

    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required|min:8|same:passwordConfirmation')]
    public string $password = '';

    public string $passwordConfirmation = '';

    /**
     * Execute Mount operation.
     *
     * @param string $token
     */
    public function mount(string $token)
    {
        $this->token = $token;
        $this->email = request()->query('email', '');
    }

    /**
     * Execute Reset Password operation.
     */
    public function resetPassword()
    {
        $this->validate();

        $status = Password::broker()->reset(
            [
                'token' => $this->token,
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->passwordConfirmation,
            ],
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            session()->flash('status', __($status));

            return redirect()->route('login');
        }

        $this->addError('email', __($status));
    }

    /**
     * Execute Render operation.
     */
    public function render()
    {
        return view('livewire.auth.reset-password');
    }
}
