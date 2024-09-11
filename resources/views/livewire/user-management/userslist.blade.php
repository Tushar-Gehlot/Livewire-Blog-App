<div class="row">
    <div class="col-md-3">
        @livewire('common.sidebar')
    </div>
    <div class="col-md-9">

        @if (session()->has('delete'))
            <div class="alert alert-success">
                {{ session('delete') }}
            </div>
        @endif
        @if (session()->has('user-updated'))
            <div class="alert alert-success">
                {{ session('user-updated') }}
            </div>
        @endif
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- <!-- Search Input -->
        <input type="text" wire:model.debounce.500ms="search" class="form-control" placeholder="Search users..."> --}}
        <div class="text-end">
            <a href="{{ route('create.user') }}" class="btn btn-primary right">Create User</a>
        </div>

        <!-- User List -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @foreach ($user->roles as $role)
                                <span>{{ $role->name }}</span>@if (!$loop->last), @endif
                            @endforeach
                        </td>
                        <td>
                            <button wire:click="edit({{ $user->id }})" class="btn btn-warning btn-sm">Edit</button>
                            <button wire:click="delete({{ $user->id }})" wire:confirm="Are you sure you want to delete this record?" class="btn btn-danger btn-sm">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No records found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination Links -->
        {{ $users->links() }}

         <!-- Edit Form Modal -->
        <div wire:ignore.self class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="update">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" wire:model="name" class="form-control">
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" wire:model="email" class="form-control">
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                @foreach ($roles as $role)
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" id="{{ $role->id }}" class="form-check-input" wire:model="role" value="{{ $role->name }}"
                                        {{ in_array($role->name, $this->role) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="{{ $role->id }}">{{ ucfirst($role->name) }}</label>
                                    </div>
                                @endforeach
                                @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="permissions">Permissions</label><br>
                                @foreach ($allPermissions as $permission)
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" class="form-check-input" wire:model="permissions" value="{{ $permission->name }}"
                                        {{ in_array($permission->name, $this->permissions) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="{{ $permission->name }}">{{ ucfirst($permission->name) }}</label>
                                    </div>
                                @endforeach
                                @error('permissions') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" wire:click="$set('showModal', false)" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:init', function () {
            Livewire.on('showModal', () => {
                const editModal = new bootstrap.Modal(document.getElementById('editModal'));
                editModal.show();
            });

            Livewire.on('hideModal', () => {
                const editModal = new bootstrap.Modal(document.getElementById('editModal'));
                editModal.hide();
            });
        });
    </script>

</div>
