<?php

namespace App\Jobs;

use App\Mail\PostPublishMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;


class SendPostPublishNotification implements ShouldQueue
{
    use Queueable;

    protected $userIds;
    protected $data;

    public function __construct($userIds, $data)
    {
        $this->userIds = $userIds;
        $this->data = $data;
    }

    public function handle()
    {
        foreach ($this->userIds as $userId) {
            $user = User::find($userId);

            Mail::to($user->email)->send(new PostPublishMail($this->data));
        }
    }
}
