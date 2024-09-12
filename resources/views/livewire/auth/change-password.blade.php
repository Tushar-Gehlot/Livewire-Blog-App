<div class="row">
    <div class="col-md-3">
        @livewire('common.sidebar')
    </div>
    <div class="col-md-9">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form wire:submit.prevent="changePassword">
            <div class="mb-3">
                <label for="currentPassword" class="form-label">Current Password</label>
                <input type="password" id="currentPassword" class="form-control" wire:model="currentPassword">
                @error('currentPassword') <span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <div class="mb-3">
                <label for="newPassword" class="form-label">New Password</label>
                <input type="password" id="newPassword" class="form-control" wire:model="newPassword">
                @error('newPassword') <span class="text-danger">{{ $message }}</span>@enderror

            </div>
            <div class="mb-3">
                <label for="newPassword_confirmation" class="form-label">Confirm Password</label>
                <input type="password" id="newPassword_confirmation" class="form-control" wire:model="newPassword_confirmation">
                @error('newPassword_confirmation') <span class="text-danger">{{ $message }}</span>@enderror
            </div>
            <button type="submit" class="btn btn-primary">Change Password</button>
        </form>
    </div>
</div>
