<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Character;
use Database\Factories\CharacterFactory;
use App\Models\User;

class CharacterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $adminUser = User::where('admin', true)->first();
        Character::factory()->create([
            'user_id' => $adminUser->id,
            'enemy'=>true,

        ]);
        Character::factory()->create([
            'user_id' => $adminUser->id,
            'enemy'=>false,

        ]);
        
        foreach (range(1, 10) as $index) {
            $randomUser = $users->random();

            Character::factory()->create([
                'user_id' => $randomUser->id,
            ]);
        }
     

    }
}
