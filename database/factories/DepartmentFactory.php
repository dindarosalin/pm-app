<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Department;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    protected $model = Department::class;

    private static $departments = [
        'Software Engineer',
        'Hardware Engineer',
        'Automation Engineer',
        'Project Management',
        'Quality Assurance',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $department = array_shift(self::$departments);

        return [
            'name' => $department,
        ];
    }
}
