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
        @can('create posts')
            <div class="text-end">
                <a href="{{ route('post.create') }}" class="btn btn-primary">Add Post</a>
            </div>
        @endcan
        <!-- Post List -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Author</th>
                    @can('edit posts')
                        <th>Actions</th>
                    @elsecan('delete posts')
                        <th>Actions</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->content }}</td>
                        <td>{{ $post->user->name }}</td>
                        <td>
                            @can('edit posts')
                                <a href="{{ route('post.edit', $post->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            @endcan
                            @can('delete posts')
                                <button wire:click="delete({{ $post->id }})" wire:confirm="Are you sure you want to delete this record?" class="btn btn-danger btn-sm">Delete</button>
                            @endcan
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
        {{ $posts->links() }}
    </div>
</div>
