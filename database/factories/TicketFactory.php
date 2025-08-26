<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $adminIds = User::where('is_admin', true)->pluck('id')->toArray();
        $assigneeId = fake()->randomElement($adminIds);

        return [
            'title' => $this->faker->sentence(4),
            'status' => $this->faker->randomElement(['open', 'in_progress', 'closed']),
            'reporter_id' => rand(1, User::count()),
            'made_timestamp' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'last_update_on' => now(),
            'assignee_id' => $assigneeId,
        ];
    }
}
