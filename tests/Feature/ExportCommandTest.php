<?php
namespace Tests\Feature;

use App\Models\Destination;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Feature test for the export destinations command
 */
class ExportCommandTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the destinations export command.
     */
    public function test_export_destinations_command(): void
    {
        Storage::fake('public');

        // Create some destinations
        Destination::factory()->create([
            'name' => 'Paris',
            'description' => '3 nights in a hotel',
            'price' => 100,
            'duration' => 7,
        ]);

        Destination::factory()->create([
            'name' => 'Tunis',
            'description' => '10 in a villa with a swimming pool',
            'price' => 200,
            'duration' => 17,
        ]);

        // Run the command with a custom filename
        $this->artisan('destinations:export', ['--filename' => 'test-export.csv'])
            ->expectsOutput('Destinations exported successfully to: ' . Storage::disk('public')->path('test-export.csv'))
            ->assertExitCode(0);

        // Assert the file exists
        $this->assertTrue(Storage::disk('public')->exists('test-export.csv'));

        // Get the contents of the CSV file
        $contents = Storage::disk('public')->get('test-export.csv');

        // Assert the CSV contains the expected data
        $this->assertStringContainsString('name,description,price,duration', $contents);
        $this->assertStringContainsString('"Paris","3 nights in a hotel",100,7', $contents);
        $this->assertStringContainsString('"Tunis","10 in a villa with a swimming pool",200,17', $contents);
    }

    /**
     * Test the destinations export command with no destinations.
     */
    public function test_export_destinations_command_with_no_destinations(): void
    {
        // Run the command with no destinations in the database
        $this->artisan('destinations:export', ['--filename' => 'test-export.csv'])
            ->expectsOutput('No destinations found to export.')
            ->assertExitCode(1);
    }
}
