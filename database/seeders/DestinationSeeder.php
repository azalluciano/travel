<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;

/**
 * Seeder to create initial destinations
 */
class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destinations = [
            [
                'name' => 'Paris',
                'description' => '3 nights in an hotel. Experience the romantic atmosphere of the City of Light, visit the iconic Eiffel Tower, stroll along the Seine River, and explore the magnificent Louvre Museum.',
                'price' => 100.00,
                'duration' => 7,
            ],
            [
                'name' => 'Tunis',
                'description' => '10 in a villa with a swimming pool. Enjoy the Mediterranean climate, explore ancient ruins, relax on beautiful beaches, and experience the rich Tunisian culture.',
                'price' => 200.00,
                'duration' => 17,
            ],
            [
                'name' => 'Santorini',
                'description' => 'Experience the breathtaking beauty of this Greek island. Enjoy stunning sunsets, white-washed buildings with blue domes, crystal-clear waters, and delicious Mediterranean cuisine.',
                'price' => 250.00,
                'duration' => 10,
            ],
            [
                'name' => 'Bali',
                'description' => 'Discover the exotic beauty of Bali. Relax on pristine beaches, explore ancient temples, immerse yourself in Balinese culture, and enjoy luxurious accommodation surrounded by lush rice terraces.',
                'price' => 300.00,
                'duration' => 14,
            ],
            [
                'name' => 'Maldives',
                'description' => 'Experience paradise on earth with crystal-clear waters, white sandy beaches, and overwater bungalows. Perfect for couples seeking privacy, romance, and unforgettable underwater experiences.',
                'price' => 500.00,
                'duration' => 12,
            ],
        ];

        foreach ($destinations as $destination) {
            Destination::create($destination);
        }

        $this->command->info('5 destinations have been created');
    }
}