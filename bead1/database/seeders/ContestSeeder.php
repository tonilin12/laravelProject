<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contest;
use App\Models\User;
use App\Models\Place;


class ContestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $places = Place::all();
        
        foreach (range(1, 10) as $index) {
            $randomUser = $users->random();
            $randomPlace = $places->random();


            Contest::factory()->create([
                'user_id' => $randomUser->id,
                'place_id' => $randomPlace->id,
                'win' => (bool) rand(0, 1), 

            ]);
        }
     
    }
}
