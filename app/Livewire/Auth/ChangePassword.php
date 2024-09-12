<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;


class ChangePassword extends Component
{
    #[Title('Change Password')]

    public $currentPassword, $newPassword, $newPassword_confirmation;
    protected $rules = [
        'currentPassword' => 'required',
        'newPassword' => 'required|min:8|confirmed',
        'newPassword_confirmation' => 'required',
    ];

    public function changePassword()
    {
        $this->validate();

        if(!Hash::check($this->currentPassword, Auth::user()->password))
        {
            session()->flash('error', 'Current password is incorrect.');
            return;
        }

        Auth::user()->update([
            'password' => Hash::make($this->newPassword)
        ]);

        $this->resetFields();

        session()->flash('success','Password changed successfully!');
    }

    public function resetFields()
    {
        $this->currentPassword = '';
        $this->newPassword = '';
        $this->newPassword_confirmation = '';
    }

    public function render()
    {
        return view('livewire.auth.change-password');
    }
}
