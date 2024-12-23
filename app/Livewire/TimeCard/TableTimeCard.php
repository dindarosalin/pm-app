<?php

namespace App\Livewire\TimeCard;

use App\Models\Projects\Master\TaskStatuses as ModelTaskStatuses;
use App\Models\Projects\Project;
use App\Models\Projects\Task\Task;
use App\Models\TimeCard\TimeCard;
use Carbon\Carbon;
use Livewire\Component;

class TableTimeCard extends Component
{
    public $auth;
    public $timeCards;
    public $taskCount, $tasks, $taskStatuses;
    public $timeCardId, $duration, $taskStatus;

    public $search = '';
    public $filters = [];
    public $sortColumn = null;
    public $sortDirection = 'asc';

    public function render()
    {
        $this->loadTimeCard();
        $this->timeCards = $this->filter($this->timeCards);
        // dd($this->auth);
        $this->taskCount = $this->timeCards->count();

        return view('livewire.time-card.table-time-card', [
            'timeCards' => $this->timeCards,
        ]);
    }

    public function mount($auth)
    {
        $this->auth = $auth;
    }

    public function loadTimeCard()
    {
        $today = Carbon::today();

        $this->taskStatuses = ModelTaskStatuses::getAll();
        $this->timeCards = TimeCard::getAllByAuth($this->auth)
        ->filter(function ($timeCard) use ($today) {
                $timeCard->activity_date = Carbon::parse($timeCard->activity_date);
                return $timeCard->activity_date->isSameDay($today);
            });
    }

    public function update($id)
    {
        $timeCard = TimeCard::getById($id);

        if ($this->duration) {
            TimeCard::update($id, [
                'duration' => $this->duration,
                'created_at' => now()
            ]);
        }
        
        if($this->taskStatus == true) {
            Task::updateStatus($timeCard->task_id, [
                'status_id' => 5,
                'completion_time' => now()
            ]);
        } else {
            Task::updateStatus($timeCard->task_id, [
                'status_id' => 3
            ]);
        }

        Project::calculateCompletion($timeCard->project_id);
        $this->resetForm();
        $this->dispatch('swal:modal', [
            'type' => 'success',
            'message' => 'Data Saved',
            'text' => 'It will list on the table soon.'
        ]);
    }

    public function filter($timeCards)
    {
        // Pencarian
        if ($this->search) {
            $timeCards = TimeCard::scopeSearch($timeCards, $this->search);
        }

        // Filter berdasarkan kolom
        if ($this->filters) {
            foreach ($this->filters as $column => $value) {
                if (!empty($value)) {
                    $timeCards = Project::scopeFilter($timeCards, $column, $value);
                }
            }
        }

        // Sorting
        if ($this->sortColumn) {
            $timeCards = Project::scopeSorting($timeCards, $this->sortColumn, $this->sortDirection);
        }

        return $timeCards;
    }

    public function applySortBy($column)
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortColumn = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function resetForm()
    {
        $this->timeCardId = null;
        $this->duration = null;
        $this->taskStatus = null;
    }

    public function resetFilter()
    {
        $this->reset(['search', 'filters', 'sortColumn']);
    }
}
