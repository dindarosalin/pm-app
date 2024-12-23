<?php

namespace App\Livewire\Projects\Tasks;

use App\Livewire\Projects\Tasks\Comments;
use Livewire\Attributes\On;
use Livewire\Component;



class Comment extends Component
{
    public  $comment;
    public $replyMessage;
    
    public function mount($comment)
    {
        $this->comment = $comment; // Initialize with passed data
    }

    public function sendComment($id)
    {
        // dd($this->replyMessage);
        $this->dispatch('reply', reply: $this->replyMessage, id: $id);
    }
    
    public function render()
    {
        return view('livewire.projects.tasks.comment');
    }
}
