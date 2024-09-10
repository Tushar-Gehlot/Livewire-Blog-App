<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Component;

class PasswordResetRequest extends Component
{
    public $email;

    protected $rules = [
        'email' => 'required|email|exists:users,email',
    ];

    public function sendResetLink()
    {
        $this->validate();

        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('status', 'Password reset link sent!');
        } else {
            session()->flash('error', 'Failed to send password reset link.');
        }
    }

    public function render()
    {
        return view('livewire.auth.password-reset-request');
    }
}
