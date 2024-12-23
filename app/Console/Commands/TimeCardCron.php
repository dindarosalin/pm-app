<?php

namespace App\Console\Commands;

use App\Models\Projects\Task\Task;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TimeCardCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'timecard:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Time Card';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        info("Cron Job running at ". now());

        $tasks = Task::getAllTask()->whereBetween('status_id', [2, 4]);

        foreach ($tasks as $task) {
            DB::table('time_cards')->insert([
                'project_id' => $task->project_id,
                'task_id' => $task->id,
                'employee_id' => $task->assign_to,
                'created_at' => now(),
                'activity_date' => now()
            ]);
        }

        return Command::SUCCESS;
    }
}
