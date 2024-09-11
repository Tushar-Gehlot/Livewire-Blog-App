<?php

namespace App\Livewire\Posts;

use Livewire\WithPagination;
use App\Models\Post;
use Livewire\Attributes\Title;
use Livewire\Component;

class PostIndex extends Component
{
    use WithPagination;

    // Define pagination properties
    protected $paginationTheme = 'bootstrap';

    #[Title('Post')]

    public function mount()
    {
        if(!auth()->user()->can('view posts')) {
            abort(403);
        }
    }

    public function delete($postId)
    {
        if (!auth()->user()->can('delete posts')) {
            abort(403);
        }

        $post = Post::findOrFail($postId);
        $post->delete();

        session()->flash('message', 'Post deleted successfully.');
    }

    public function render()
    {
        $posts = Post::latest()->paginate(5);
        return view('livewire.posts.post-index',['posts' => $posts]);
    }
}
