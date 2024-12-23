<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Select a random role
        $role = Role::inRandomOrder()->first();

        return [
            'name' => $this->faker->name(),
            'role_id' => $role->id,
            'department_id' => $role->department_id, // Use the department_id from the selected role
        ];
    }
}
