<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Livewire\Attributes\Title;
use Livewire\Component;


class PostEdit extends Component
{
    public $postId;
    public $title;
    public $content;

    #[Title('Edit Post')]
    public function mount($id)
    {
        if (!auth()->user()->can('edit posts')) {
            abort(403);
        }

        $post = Post::findOrFail($id);

        $this->postId = $post->id;
        $this->title = $post->title;
        $this->content = $post->content;
    }

    public function update()
    {
        $this->validate(
            [
                'title' => 'required|string|max:255',
                'content' => 'required',
            ]
        );

        $post = Post::findOrFail($this->postId);
        $post->update([
            'title' => $this->title,
            'content' => $this->content,
        ]);

        session()->flash('success', 'Post updated successfully.');

        return redirect()->route('posts.index');
    }

    public function render()
    {
        return view('livewire.posts.post-edit');
    }
}
