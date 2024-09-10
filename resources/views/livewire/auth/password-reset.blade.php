<div>
    @if (session()->has('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form wire:submit.prevent="resetPassword">
        <input type="hidden" wire:model="token">

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" wire:model="email" class="form-control" readonly>
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <input type="password" id="password" wire:model="password" class="form-control">
            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" id="password_confirmation" wire:model="password_confirmation" class="form-control">
            @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Reset Password</button>
    </form>
</div>
