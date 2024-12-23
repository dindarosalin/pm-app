<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Department;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    protected $model = Role::class;

    private static $roles = [
        'Automation Engineer',
        'Control Systems Engineer',
        'Maintenance Technician',
        'Production Manager',
        'Quality Assurance Specialist',
        'Industrial Electrician',
        'Process Engineer',
        'Mechanical Engineer',
        'Safety Coordinator',
        'Project Manager'
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $role = array_shift(self::$roles);
        $departmets = Department::inRandomOrder()->first();

        return [
            'role' => $role,
            'department_id' => $departmets->id,
        ];
    }
}
