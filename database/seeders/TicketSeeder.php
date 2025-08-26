<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\Category;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();

        Ticket::factory()->count(25)->create()->each(function ($ticket) use ($categories) {
            $randomCategories = $categories->random(rand(1, 4))->pluck('id')->toArray();
            $ticket->categories()->attach($randomCategories);
        });
    }
}
