<?php

/**
 * Code digunakan untuk create release note baru
 */

namespace App\Livewire\Projects\Release;

use App\Http\Controllers\ReleaseNote;
use App\Models\Projects\Project;
use App\Models\Projects\ReleaseNote\ReleaseNotes;
use App\Models\Projects\Task\Task;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\Livewire;

class FormReleaseNote extends Component
{
    use WithFileUploads;

    public $releaseId; 
    public $title; 
    public $tag;
    public $content;
    public $projectId;

    #[Rule('required|sometimes|image|max:1024')]
    public $newattachments; // New file attachment

    public $attachments; // Path file attachment

    public $tasksForQuill = [];

    public $taskDoneId;


    // Edit release notes
    #[On('edit')]
    public function edit($id)
    {
        $value = ReleaseNotes::detail($id);
        $this->releaseId = $value[0]->id;
        $this->title = $value[0]->title;
        $this->tag = $value[0]->tag;
        $this->projectId = $value[0]->id_project;
        $this->content = $value[0]->content;
        $this->attachments = $value[0]->attachments;
        // dd($this->attachments);

        //Mengirimkan isi content ke view karena tidak bisa diambil dari modal
        $this->dispatch('load-content', content: $this->content);
        // $this->dispatch('attachment', $value[0]->attachments);
        // $this->attachments = $value[0]->attachments;
        // dd($this->content);
    }
    #[On('taskId')]
    public function taskDoneUpdate($tasks)
    {
        // dd($tasks);
        $this->taskDoneId =  $tasks;
        // return $this->taskDoneId;
    }


    public function save()
    {
        // dd($this->taskDoneId);

        $this->validate([
            // 'id'            => 'nullable',
            'title'         => 'required|string|max:255',
            'tag'           => 'nullable|string|max:255',
            'content'       => 'required',
            'attachments'   => 'nullable|max:1024',
            'projectId'    => 'required|exists:projects,id',
        ]);

        // dd($this->all());

        //Check data
        try {
            // Check jika ada releaseId maka lakukan Update data
            // Jika tidak ada releaseId maka lakukan Create data baru
            if ($this->releaseId) {
                /**
                 * Check data attachmen
                 * Jika ada attachment maka delete file lama
                 * Jika tidak, store file ke storage
                 */
                // if ($this->attachments) {
                //     // Delete exists file
                //     Storage::delete($this->attachments, 'public');
                // }

                if (!is_null($this->newattachments)) {
                    Storage::delete($this->attachments, 'public');
                    $this->newattachments = $this->newattachments->store('uploads', 'public');
                    ReleaseNotes::update([
                        'releaseId'     => $this->releaseId,
                        'tag'           => $this->tag,
                        'title'         => $this->title,
                        'content'       => $this->content,
                        'newattachments'   => $this->newattachments,
                        'projectId'    => $this->projectId,
                    ]);
                } else {
                    ReleaseNotes::update([
                        'releaseId'     => $this->releaseId,
                        'tag'           => $this->tag,
                        'title'         => $this->title,
                        'content'       => $this->content,
                        'newattachments'   => $this->attachments,
                        'projectId'    => $this->projectId,
                    ]);
                }
            } else {
                // Store image to storage
                if ($this->newattachments) {
                    $this->newattachments = $this->newattachments->store('uploads', 'public');
                }
                // Store data to database
                ReleaseNotes::create([
                    'releaseId'     => $this->releaseId,
                    'tag'           => $this->tag,
                    'title'         => $this->title,
                    'content'       => $this->content,
                    'newattachments'   => $this->newattachments,
                    'projectId'    => $this->projectId,
                ]);
            }
            $this->dispatch('close-offcanvas');
            $this->dispatch('swal:modal', [
                'type' => 'success',
                'message' => 'Data Saved',
                'text' => 'It will list on the table soon.'
            ]);
            // dd($this->taskDoneId);
            $taskDoneId = $this->taskDoneId;
            Task::updateStatusProd($this->taskDoneId, [
                'status_id' => 6,
                'updated_at' => now()
            ]);
            $this->reset();
            $this->reset('content');
            $this->dispatch('clear-content');
            $this->dispatch('formSubmitted');
            $this->dispatch('refresh');
            
        } catch (\Throwable $th) {
            throw $th;
            $this->js("alert('Project Unsaved!')");
        }
    }

    public function cancel()
    {
        $this->reset();
        $this->reset('content');
        $this->dispatch('clear-content');
        $this->dispatch('formSubmitted');
    }

    #[On('openModalWithData')]
    public function openModalWithData($data)
    {


        // Set tasks for Quill editor
        $this->tasksForQuill = $data['tasks'];

        // Trigger JS to open the modal and pass data to Quill
        $this->dispatch('populateQuill', tasks: $this->tasksForQuill);
    }

    public function render()
    {
        // dd($this->attachments);
        $projects = Project::getAll();
        return view('livewire.projects.release.form-release-note', compact('projects'));
    }
}
