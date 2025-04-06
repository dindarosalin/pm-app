<?php

namespace App\Livewire\Projects\Tasks;

use Livewire\Component;
use App\Models\Projects\Task\Task;
use App\Models\Projects\Master\TaskCriterias;
use App\Models\Projects\Master\TaskSubCriterias;
use Illuminate\Support\Facades\DB;

class Priorities extends Component
{
    public $tasks, $criterias;
    public $projectId, $auth;
    public $taskScored;

    public function render()
    {
        $this->loadData();
        // dd($this->tasks);
        $this->calculateScores(); 
        return view('livewire.projects.tasks.priorities');
    }

    public function mount()
    {
        $this->projectId;
    }

    public function loadData() 
    {
        // $this->tasks = Task::getAllProjectTasksByAuth($this->projectId, $this->auth);
        // $this->tasks->filter(function ($task) {
        //     return $task->status_id <= 4;
        // });

        $this->criterias = TaskCriterias::getAll();
    }

    // 3.7.2 Penentuan Rating Kecocokan
    public function taskRating(){
        
        $taskRatings = collect();

        foreach ($this->tasks as $task) {
            $ratings = [];
            foreach ($this->criterias as $c) {
                $cName = $c->c_name;
                $rating = null;

                if ($cName === 'use_holiday') {
                    $sc = DB::table('task_subcriterias')
                    ->where('criteria_id', $c->id)
                    ->where('sc_label', $task->use_holiday)->first();

                    $rating = $sc ? $sc->sc_value : null;
                } elseif ($cName === 'use_weekend') {
                    $sc = DB::table('task_subcriterias')
                    ->where('criteria_id', $c->id)
                    ->where('sc_label', $task->use_weekend)->first();

                    $rating = $sc ? $sc->sc_value : null;
                } elseif ($cName === 'flag') {
                    $flags = explode(',', $task->flag);
                    $tFlags = count($flags);
                
                    $sc = DB::table('task_subcriterias')
                        ->where('criteria_id', $c->id)
                        ->where(function ($query) use ($tFlags) {
                            $query->where(function ($q) use ($tFlags) {
                                $q->where('sc_min', '<=', $tFlags)
                                ->where('sc_max', '>=', $tFlags);
                            })->orWhere(function ($q) use ($tFlags) {
                                $q->where('sc_min', '=', $tFlags)
                                ->where('sc_max', '=', $tFlags);
                            });
                        })
                        ->first();

                    $rating = $sc->sc_value ?? null;

                } elseif ($cName === 'end_date_estimation') {
                    $tDays = now()->startOfDay()->diffInDays(
                        \Carbon\Carbon::parse($task->end_date_estimation)->startOfDay()
                    );                    
                
                    // dd($tDays);
                    $sc = DB::table('task_subcriterias')
                        ->where('criteria_id', $c->id)
                        ->where(function ($query) use ($tDays) {
                            $query->where(function ($q) use ($tDays) {
                                $q->where('sc_min', '<=', $tDays)
                                ->where(function ($qq) use ($tDays) {
                                    $qq->where('sc_max', '>=', $tDays)
                                        ->orWhereNull('sc_max');
                                });
                            });
                        })
                        ->orderBy('sc_min')
                        ->first();

                    $rating = $sc ? $sc->sc_value : null;
                }
                
                $ratings[$cName] = $rating;
            }

            // $taskRatings->push([
            //     'task_id' => $task->id,
            //     'ratings' => $ratings,
            // ]);

            $taskRatings->push(array_merge(
                ['task_id' => $task->id],
                $ratings
            ));

        }

        return $taskRatings;

    }

    public function normalizeMatrix()
    {
        $taskRatings = $this->taskRating();
        $criterias = $this->criterias;

        $normalized = collect();

        // 1. Ambil nilai max/min untuk tiap kriteria
        $criteriaValues = [];
        foreach ($criterias as $c) {
            $col = $c->c_name;
            $values = $taskRatings->pluck($col)->filter();
            $criteriaValues[$col] = [
                'attribute' => $c->c_attribute,
                'value' => $c->c_attribute === 'benefit'
                    ? $values->max()
                    : $values->min(),
            ];
        }

        // 2. Normalisasi tiap alternatif
        foreach ($taskRatings as $row) {
            $normalizedRow = ['task_id' => $row['task_id']];

            foreach ($criterias as $c) {
                $col = $c->c_name;
                $val = $row[$col] ?? 0;
                $ref = $criteriaValues[$col]['value'];
                $attribute = $criteriaValues[$col]['attribute'];

                $normalizedRow[$col] = $ref == 0 ? 0 : (
                    $attribute === 'benefit'
                        ? $val / $ref
                        : $ref / ($val == 0 ? 1 : $val)
                );
            }

            $normalized->push($normalizedRow);
        }

        return $normalized;

        // dd( $normalized);
    }

    // Proses Perangkingan
    public function calculateScores()
    {
        $normalizedMatrix = $this->normalizeMatrix();
        $criterias = $this->criterias;

        $finalScores = collect();

        foreach ($normalizedMatrix as $row) {
            $score = 0;
            foreach ($criterias as $c) {
                $col = $c->c_name;
                $weight = $c->c_value/100;
                $score += ($row[$col] ?? 0) * $weight;
            }

            $finalScores->push((object)[
                'task_id' => $row['task_id'],
                'task' => Task::getById($row['task_id']),
                'score' => round($score, 4),
            ]);
        }

        // hasilnya atau urutkan
        $this->taskScored = $finalScores->sortByDesc('score')->values();
        $this->dispatch('update-task-score', $this->taskScored);
        // dd($this->taskScored);
    }

}
