<div>
    @if (session()->has('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form wire:submit.prevent="sendResetLink">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" wire:model="email" class="form-control">
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Send Password Reset Link</button>
    </form>
</div>
