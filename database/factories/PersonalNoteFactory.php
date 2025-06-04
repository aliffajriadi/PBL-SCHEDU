<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PersonalNote>
 */
class PersonalNoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->text(15),
            'content' => $this->faker->text(30),
            'user_uuid' => '48952e16-9fa1-447a-b6ea-d3b54be08aad',
            'created_at' => now()->timestamp,
            'updated_at' => now()->timestamp,


        ];
    }
}
