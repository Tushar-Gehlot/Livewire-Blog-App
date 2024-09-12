<div class="row">
    <div class="col-md-3">
        {{-- include sidebar component --}}
        @livewire('common.sidebar')
    </div>
    <div class="col-md-9">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form wire:submit.prevent="createUser">
            <div class="mb-3">
                <label for="name">Name</label>
                <input type="text" id="name" class="form-control" wire:model="name">
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label for="email">Email</label>
                <input type="email" id="email" class="form-control" wire:model="email">
                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label for="role">Role</label><br>
                @foreach ($roles as $role)
                    <div class="form-check form-check-inline">
                        <input type="checkbox" id="{{ $role }}" class="form-check-input" wire:model="role" value="{{ $role }}">
                        <label class="form-check-label" for="{{ $role }}">{{ ucfirst($role) }}</label>
                    </div>
                @endforeach
                @error('role') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label for="permissions">Permissions</label><br>
                @foreach ($allPermissions as $permission)
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" wire:model="permissions" value="{{ $permission }}">
                        <label class="form-check-label" for="{{ $permission }}">{{ ucfirst($permission) }}</label>
                    </div>
                @endforeach
                @error('permissions') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
