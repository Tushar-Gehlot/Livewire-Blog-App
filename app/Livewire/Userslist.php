<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Livewire\Attributes\Title;

#[Title('Dashboard')]
class Userslist extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedUserId = null;
    public $name, $email, $password,$role;
    public $showModal = false;

    // Define pagination properties
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $users = User::with('roles', 'permissions')
            ->where('id', '!=', auth()->id())
            ->paginate(10);

        $roles = Role::all();

        return view('livewire.userslist', [
            'users' => $users,'roles' => $roles
        ]);
    }

    public function edit($userId)
    {
        $user = User::find($userId);
        $this->selectedUserId = $userId;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->roles->pluck('name')->first();
        $this->showModal = true;
        $this->dispatch('showModal');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->selectedUserId,
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::find($this->selectedUserId);
        $user->name = $this->name;
        $user->email = $this->email;

        $user->save();

        //update the role
        $user->syncRoles([$this->role]);

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
