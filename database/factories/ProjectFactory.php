<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;
use App\Models\Department;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $projectManager = Employee::inRandomOrder()->first();
        $departmentIds = Department::inRandomOrder()
            ->take($this->faker->numberBetween(1, 5))
            ->pluck('id')
            ->toArray();

        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'client' => $this->faker->company(),
            'project_manager' => $projectManager ? $projectManager->id : null,
            'team' => json_encode($departmentIds),
            'budget' => $this->faker->randomFloat(2, 1000, 100000),
            'start_date' => $this->faker->date(),
            'due_date_estimation' => $this->faker->date('Y-m-d', '+1 month'),
            'completion' => 0,
            'attachments' => $this->faker->url(),
            'completion_date' => null,
            'created_by' => $projectManager ? $projectManager->id : null,
        ];
    }
}
