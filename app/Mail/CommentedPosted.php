<?php

namespace App\Mail;

use App\Models\comments;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentedPosted extends Mailable
{
    use Queueable, SerializesModels;

    public $comment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(comments $comment)
    {
      $this->$comment=$comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject="Commented was posted on your {$this->comment->commentable->title} blog post"; 
        return $this->subject($subject)
         ->view('emails.posts.commented');
    }
}
