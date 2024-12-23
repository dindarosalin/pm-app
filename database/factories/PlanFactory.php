<?php

namespace Database\Factories;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plan>
 */
class PlanFactory extends Factory
{
    protected $model = Plan::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'kategori' => $this->faker->word,
            'sub_kategori' => $this->faker->word,
            'nama' => $this->faker->word,
            'uom' => $this->faker->randomElement(['pcs', 'box', 'kg', 'day']),
            'kuantitas' => $this->faker->numberBetween(1, 100),
            'harga_satuan' => $this->faker->randomFloat(2, 100, 10000),
            'total_per_item' => $this->faker->randomFloat(2, 100, 10000),
            'total_all' => $this->faker->randomFloat(2, 1000, 100000),
        ];
    }
}
