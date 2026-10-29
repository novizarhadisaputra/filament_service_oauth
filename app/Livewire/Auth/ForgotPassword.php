<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

/**
 * Class ForgotPassword
 *
 * Forgot Password.
 */
#[Title('Forgot Password')]
#[Layout('components.layouts.guest')]
class ForgotPassword extends Component
{
    #[Validate('required|email')]
    public string $email = '';

    public ?string $status = null;

    /**
     * Execute Send Reset Link operation.
     */
    public function sendResetLink()
    {
        $this->validate();

        $status = Password::broker()->sendResetLink(
            ['email' => $this->email]
        );

        if ($status === Password::RESET_LINK_SENT) {
            $this->status = trans($status);
            $this->email = '';
        } else {
            $this->addError('email', trans($status));
        }
    }

    /**
     * Execute Render operation.
     */
    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
