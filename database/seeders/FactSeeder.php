<?php

namespace Database\Seeders;

use App\Models\Fact;
use Illuminate\Database\Seeder;

class FactSeeder extends Seeder
{
    public function run(): void
    {
        Fact::factory()->count(20)->create();
    }
}
