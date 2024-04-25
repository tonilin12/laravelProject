<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Character;
use App\Models\CharacterContest;
use App\Models\Contest;

class CharacterContestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $characters = Character::all();
        $count = $characters->count();

        if ($count >= 2) {
            foreach (Contest::all() as $index => $contest) {
                $hero = $characters->filter(function ($character) {
                    return $character->enemy === false;
                })->random();
                if ($index === 0) {
                    $hero = $characters->filter(function ($character) {
                        return $character->enemy === false;
                    })->first();
                }
            
            
                
                $enemy = Character::whereHas('user', function ($query) {
                    $query->where('admin', true);
                })
                ->where('enemy', true)
                ->first();
                
                $hero_hp = $contest->win ? 0 : 20;
                $enemy_hp = $contest->win ? 20 : 0;

                CharacterContest::factory()->create([
                    'hero_id' => $hero->id,
                    'enemy_id' => $enemy->id,
                    'contest_id' => $contest->id,
                    'hero_hp' => $hero_hp,
                    'enemy_hp' => $enemy_hp,
                ]);
            }
        }
    }
}



