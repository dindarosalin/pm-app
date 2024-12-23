<?php

namespace Database\Factories;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $project = Project::inRandomOrder()->first();
        return [
            'project_id' => $project ? $project->id : null,
            'title' => $this->faker->sentence,
            'summary' => $this->faker->paragraph,
            'start_date_estimation' => $this->faker->date,
            'end_date_estimation' => $this->faker->date,
            'attachment' => $this->faker->url(),
            'create_by' => $this->faker->randomDigitNotNull,
            'assign_to' => $this->faker->randomDigitNotNull,
            'status' => 'new',
        ];
    }
}
