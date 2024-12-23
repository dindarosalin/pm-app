<?php

namespace App\Livewire\Projects\Tasks;

use App\Models\Projects\Task\Comment;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Comments extends Component
{
    public $taskId;

    // #[Validate('required')]
    public $comment;
    public $parent;

    public $countComment;
    public $comments = [];

    #[On('taskId')]
    public function getTaskId($taskId)
    {
        $this->taskId = $taskId;
        // dd($this->comments );
    }

    public function commentByTask($taskId)
    {
        return \App\Models\Projects\Task\Comment::getById($taskId);
    }

    public function sendComment()
    {
        $user = Auth::user()->user_id;
        if (empty($this->comment) || trim($this->comment) === '') {
            // Kirimkan pesan kesalahan jika komentar kosong
            $this->dispatch('swal:modal', [
                'type' => 'error',
                'message' => 'Error',
                'text' => 'Comment cannot be empty.'
            ]);
            return; // Hentikan eksekusi jika komentar kosong
        }
        // dd($user);
        $storeData = [
            'id_task' => $this->taskId,
            'id_employee' => $user,
            'parent'=> $this->parent,
            'comment' => $this->comment,
        ];

        \App\Models\Projects\Task\Comment::create($storeData);
        // return dd($this->taskShow);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Send',
            'text' => 'It will not list on the table.'
        ]);

        // dd($this->taskShow->id);
        $this->dispatch('clear-comment');
        // $this->dispatch('showById', id: $this->taskId);
        // $this->dispatch('taskId', taskId: $this->taskId);
        $this->getTaskId($this->taskId);
        $this->reset('comment');
        $this->reset('parent');
        // $this->comments = $this->commentByTask();
        
        // dd($this->comment);

    }

    #[On('reply')]
    public function reply($reply, $id)
    {
        // dd($reply, $id);
        $user = Auth::user()->user_id;
        if (empty($reply) || trim($reply) === '') {
            // Kirimkan pesan kesalahan jika komentar kosong
            $this->dispatch('swal:modal', [
                'type' => 'error',
                'message' => 'Error',
                'text' => 'Comment cannot be empty.'
            ]);
            return; // Hentikan eksekusi jika komentar kosong
        }
        $storeData = [
            'id_task' => $this->taskId,
            'id_employee' => $user,
            'parent'=> $id,
            'comment' => $reply,
        ];
        // dd($reply);

        \App\Models\Projects\Task\Comment::create($storeData);
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Send',
            'text' => 'It will not list on the table.'
        ]);

        $this->dispatch('clear-comment');
        $this->getTaskId($this->taskId);
        $this->reset('comment');
        $this->reset('parent');
        
    }

    public function render()
    {
        $this->countComment = \App\Models\Projects\Task\Comment::countByTask($this->taskId);
        $this->comments = Comments::commentByTask($this->taskId);
        return view('livewire.projects.tasks.comments');
    }
}
