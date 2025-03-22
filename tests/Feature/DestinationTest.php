<?php

namespace Tests\Feature;

use App\Models\Destination;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Feature tests for the destinations functionality
 */
class DestinationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the homepage displays destinations.
     */
    public function test_homepage_displays_destinations(): void
    {
        // Create some destinations
        $destination = Destination::factory()->create([
            'name' => 'Test Destination',
        ]);

        // Visit the homepage
        $response = $this->get(route('destinations.index'));

        // Assert successful response
        $response->assertStatus(200);
        
        // Assert the destination is displayed
        $response->assertSee('Test Destination');
    }

    /**
     * Test the destination detail page.
     */
    public function test_destination_detail_page(): void
    {
        // Create a destination
        $destination = Destination::factory()->create([
            'name' => 'Detailed Destination',
            'description' => 'Detailed description',
            'price' => 150.75,
            'duration' => 9,
        ]);

        // Visit the destination detail page
        $response = $this->get(route('destinations.show', $destination));

        // Assert successful response
        $response->assertStatus(200);
        
        // Assert the destination details are displayed
        $response->assertSee('Detailed Destination');
        $response->assertSee('Detailed description');
        $response->assertSee('150.75');
        $response->assertSee('9 days');
    }

    /**
     * Test the name search filter.
     */
    public function test_destination_search_by_name(): void
    {
        // Create some destinations
        Destination::factory()->create(['name' => 'Paris Getaway']);
        Destination::factory()->create(['name' => 'London Adventure']);
        
        // Visit the homepage with search parameter
        $response = $this->get(route('destinations.index', ['name' => 'Paris']));

        // Assert successful response
        $response->assertStatus(200);
        
        // Assert the correct destination is found
        $response->assertSee('Paris Getaway');
        $response->assertDontSee('London Adventure');
    }
}