<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Forgot Password')]
#[Layout('components.layouts.guest')]
class ForgotPassword extends Component
{
    #[Validate('required|email')]
    public string $email = '';

    public ?string $status = null;

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

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
