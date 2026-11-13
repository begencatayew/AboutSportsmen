<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Player>
 */
class PlayerFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->name();

        $categoryId = Category::query()->inRandomOrder()->value('id');

        return [
            'category_id' => $categoryId ?: Category::factory()->create()->id,
            'name' => $name,
            'slug' => Str::slug($name),
            'team' => $this->faker->company(),
            'position' => $this->faker->randomElement(['Forward', 'Midfielder', 'Defender', 'Goalkeeper']),
            'nationality' => $this->faker->country(),
            'date_of_birth' => $this->faker->dateTimeBetween('-35 years', '-18 years')->format('Y-m-d'),
            'height' => $this->faker->randomFloat(2, 170, 210),
            'weight' => $this->faker->randomFloat(2, 65, 110),
            'jersey_number' => $this->faker->numberBetween(1, 99),
            'image' => 'players/default.jpg',
            'biography' => $this->faker->paragraph(),
        ];
    }
}
