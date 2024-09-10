<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;

class Profile extends Component
{
    #[Title('Profile')]
    public $user ,$name, $email;

    public function mount()
    {
        $this->user = Auth::user();
        $this->name = $this->user->name;
        $this->email = $this->user->email;
    }


    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user->id,
        ]);

        $user = Auth::user();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->save();

        session()->flash('success', 'Profile updated successfully!');
    }

    public function render()
    {
        return view('livewire.profile.profile');
    }
}
