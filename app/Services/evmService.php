<?php

namespace App\Services;

class EvmService
{
    public static function calculateEVM($project)
    {
        if (
            $project->planned_done_task < 0 ||
            $project->actual_done_task < 0 ||
            $project->bac < 0 ||
            $project->ac < 0
        ) {
            throw new \InvalidArgumentException('Nilai tidak boleh negatif');
        }

        $planned_percent = $project->total_task > 0
            ? $project->planned_done_task / $project->total_task
            : 0;

        $ev_percent = $project->total_task > 0
            ? $project->actual_done_task / $project->total_task
            : 0;

        $pv = $planned_percent * $project->bac;
        $ev = $ev_percent * $project->bac;
        $ac = $project->ac ?? 0;

        return [
            'project_id' => $project->project_id,
            'project_title' => $project->project_title,
            'total_task' => $project->total_task,
            'budget_at_complated' => $project->bac,
            'planned_done_task' => $project->planned_done_task,
            'actual_done_task' => $project->actual_done_task,
            'planned_percent' => round($planned_percent * 100, 2) . '%',
            'earned_percent' => round($ev_percent * 100, 2) . '%',
            'planned_value' => round($pv, 2),
            'earned_value' => round($ev, 2),
            'actual_cost' => round($ac, 2),
            'spi' => $pv > 0 ? round($ev / $pv, 2) : 0,
            'cpi' => $ac > 0 ? round($ev / $ac, 2) : 0,
        ];
    }
}
