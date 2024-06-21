<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Event::create([
            'title' => 'Sample Event',
            'description' => 'This is a sample event description.',
            'image' => 'assets/hero.png', // Set the image path
            'date' => '2024-07-01',
            'heur' => '14:00:00',
            'price' => 49.99,
        ]);

    }
}
