<?php

namespace App\Livewire\Posts;

use App\Jobs\SendPostPublishNotification;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;


class PostCreate extends Component
{
    public $title;
    public $content;

    #[Title('')]

    public function mount()
    {
        if (!auth()->user()->can('create posts')) {
            abort(403);
        }
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        $newPost = Post::create([
            'title' => $this->title,
            'content' => $this->content,
            'user_id' => auth()->id(),
        ]);
        $this->sendMailToAllUsers($newPost);
        session()->flash('success', 'Post created successfully.');

        return redirect()->route('posts.index');
    }

    public function sendMailToAllUsers($post)
    {
        $userIds = User::where('id','!=',auth()->id())->pluck('id');

        $data = [
            'author' => Auth::user()->name,
            'subject' => "New Post Published",
            'post' => $post->title,
            'publish_date' => $post->created_at
        ];

        // Dispatch the job
        SendPostPublishNotification::dispatch($userIds, $data);
    }

    public function render()
    {
        return view('livewire.posts.post-create');
    }
}
