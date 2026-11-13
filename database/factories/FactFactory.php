<?php

namespace Database\Factories;

use App\Models\Fact;
use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Fact>
 */
class FactFactory extends Factory
{
    public function definition(): array
    {
        $playerId = Player::query()->inRandomOrder()->value('id');

        return [
            'player_id' => $playerId ?: Player::factory()->create()->id,
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
        ];
    }
}
