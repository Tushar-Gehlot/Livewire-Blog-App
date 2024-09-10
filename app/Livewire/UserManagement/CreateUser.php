<?php

namespace App\Livewire\UserManagement;

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;

class CreateUser extends Component
{
    #[Title('Add User')]

    public $name, $email, $password, $role = [], $permissions = [];
    public $roles = [];
    public $allPermissions = [];

    public function mount()
    {
        $this->roles = Role::pluck('name')->toArray();
        $this->allPermissions = Permission::pluck('name')->toArray();
    }

    protected $rules = [
        'name' => 'required|min:4',
        'email' => 'required|email|unique:users,email',
        'role' => 'required',
        'permissions' => 'required'
    ];

    public function createUser()
    {
        $this->validate();

        // Create the user
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        // Assign role & permission
        $user->syncRoles($this->role);

        if (!empty($this->permissions)) {
            $user->syncPermissions($this->permissions);
        }

        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('success', 'User created successfully and password reset email sent!');
        } else {
            session()->flash('error', 'User created, but failed to send password reset email.');
            Log::error('Password error:' .$status);
        }

        // session()->flash('success', 'User created successfully!');

        // Reset form fields
        $this->reset(['name', 'email', 'password', 'role', 'permissions']);

        return redirect()->route('dashboard');
    }


    public function render()
    {
        return view('livewire.user-management.create-user');
    }
}
