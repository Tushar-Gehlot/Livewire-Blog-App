<div class="row">
    <div class="col-md-3">
        @livewire('common.sidebar')
    </div>
    <div class="col-md-9">
        <h1 class="text-center">Create Post</h1>

        <form wire:submit.prevent="save">
            @csrf

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" wire:model="title" class="form-control" id="title">
                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mt-2">
                <label for="content">Content</label>
                <textarea wire:model="content" class="form-control" id="content"></textarea>
                @error('content') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-3">Save</button>
        </form>
    </div>
</div>
