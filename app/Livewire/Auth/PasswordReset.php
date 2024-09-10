<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset as ChangePassword;
use Livewire\Attributes\Title;

class PasswordReset extends Component
{
    #[Title('Reset Password')]

    public $email;
    public $token;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'email' => 'required|email|exists:users,email',
        'password' => 'required|min:8|confirmed',
        'password_confirmation' => 'required|min:8',
    ];

    public function mount($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function resetPassword()
    {
        $this->validate();

        $status = Password::reset(
            ['email' => $this->email, 'password' => $this->password, 'token' => $this->token],
            function ($user) {
                $user->password = Hash::make($this->password);
                $user->save();
                event(new ChangePassword($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            session()->flash('status', 'Password reset successfully! You can now log in.');
            return redirect()->route('login');
        } elseif ($status === Password::INVALID_TOKEN) {
            session()->flash('error', 'The password reset link is invalid or has expired.');
            return redirect()->route('password.request'); // Redirect to request a new reset link
        } else {
            session()->flash('error', 'Failed to reset password.');
        }
    }

    public function render()
    {
        return view('livewire.auth.password-reset');
    }
}
