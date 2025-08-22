<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $adminIds = User::where('is_admin', true)->pluck('id')->toArray();
        $userId = fake()->randomElement($adminIds);

        return [
            'content' => $this->faker->paragraph(),
            'ticket_id' => rand(1, Ticket::count()),
            'user_id' =>  $userId,
        ];
    }
}
