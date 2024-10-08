<?php

namespace App\Livewire\UserManagement;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Livewire\Attributes\Title;
use Spatie\Permission\Models\Permission;

#[Title('Users List')]
class Userslist extends Component
{
    use WithPagination;

    public $search = '';
    public $days = '';
    public $selectedUserId = null;
    public $name, $email, $password, $permissions = [], $role = [];
    public $showModal = false;

    // Define pagination properties
    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        if (!auth()->user()->can('view users')) {
            abort(403);
        }
    }


    public function render()
    {
        $users = User::with('roles', 'permissions')
            ->where('id', '!=', auth()->id())
            ->whereDoesntHave('roles', function($query) {
                $query->where('name', 'admin');
            })
            ->when($this->search, function($query) {
                $query->where(function($query) {
                    $query->where('name','like','%'.$this->search.'%')
                    ->orWhere('email','like','%'.$this->search.'%');
                });
            })
            ->when($this->days, function($query) {
                $query->where('created_at', '>=' ,now()->subDays($this->days));
            })
            ->paginate(5);

        $roles = Role::all();
        $allPermissions = Permission::all();

        return view('livewire.user-management.userslist', [
            'users' => $users,'roles' => $roles,'allPermissions' => $allPermissions
        ]);
    }

    public function updatedSearch()
    {
        $this->resetPage(); // Reset to page 1 when search input changes
    }

    public function updatedDays()
    {
        $this->resetPage(); // Reset to page 1 when days filter changes
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
