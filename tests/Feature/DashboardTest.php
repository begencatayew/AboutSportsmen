<?php

use App\Models\Category;
use App\Models\Player;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(LazilyRefreshDatabase::class);

test('authenticated users can see dashboard statistics and recent players', function () {
    $category = Category::factory()->create([
        'name' => 'Goalkeepers',
        'slug' => 'goalkeepers',
    ]);

    Player::factory()->for($category)->create([
        'name' => 'Aylin Yilmaz',
        'slug' => 'aylin-yilmaz',
    ]);

    $response = $this->actingAs(User::factory()->create())
        ->get(route('dashboard'));

    $response->assertOk()
        ->assertViewIs('dashboard')
        ->assertSee('Goalkeepers')
        ->assertSee('Aylin Yilmaz')
        ->assertSee(route('categories.index'), false)
        ->assertSee(route('players.index'), false)
        ->assertSee(route('facts.index'), false);
});
