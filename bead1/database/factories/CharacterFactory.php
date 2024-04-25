<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Character>
 */
class CharacterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $defence = 0;
        $strength = 0;
        $accuracy = 0;
        $magic = 0;

        // Generate values for each attribute while ensuring their sum is less than 20
        do {
            $defence = $this->faker->numberBetween(0, 3);
            $strength = $this->faker->numberBetween(0, 20);
            $accuracy = $this->faker->numberBetween(0, 20);
            $magic = $this->faker->numberBetween(0, 20);
        } while ($defence + $strength + $accuracy + $magic >= 20);

        return [
            'name' =>  $this->faker->firstName,
            'defence' => $defence,
            'strength' => $strength,
            'accuracy' => $accuracy, 
            'magic' => $magic,
        ];
    }
}
