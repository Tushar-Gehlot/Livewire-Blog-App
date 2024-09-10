<?php

namespace App\Livewire\UserManagement;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Livewire\Attributes\Title;
use Spatie\Permission\Models\Permission;

#[Title('Dashboard')]
class Userslist extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedUserId = null;
    public $name, $email, $password, $permissions = [], $role = [];
    public $showModal = false;

    // Define pagination properties
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $users = User::with('roles', 'permissions')
            ->where('id', '!=', auth()->id())
            ->paginate(10);

        $roles = Role::all();
        $allPermissions = Permission::all();

        return view('livewire.user-management.userslist', [
            'users' => $users,'roles' => $roles,'allPermissions' => $allPermissions
        ]);
    }

    public function edit($userId)
    {
        $user = User::find($userId);
        $this->selectedUserId = $userId;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->roles->pluck('name')->toArray();
        $this->permissions = $user->permissions->pluck('name')->toArray();
        $this->showModal = true;
        $this->dispatch('showModal');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->selectedUserId,
            'role' => 'required|exists:roles,name',
            'permissions' => 'required'
        ]);

        $user = User::find($this->selectedUserId);
        $user->name = $this->name;
        $user->email = $this->email;

        $user->save();

        //update the role
        if (!empty($this->role)) {
            $user->syncRoles([$this->role]);
        }

        if (!empty($this->permissions)) {
            $user->syncPermissions($this->permissions);
        }

        session()->flash('user-updated', 'User updated successfully!');

        $this->showModal = false;
        $this->dispatch('hideModal');
    }

    public function delete($userId)
    {
        User::find($userId)->delete();
        session()->flash('delete', 'User deleted successfully!');
    }

    private function resetFields()
    {
        $this->selectedUserId = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = null;
    }
}
