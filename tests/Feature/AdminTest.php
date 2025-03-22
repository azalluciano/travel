<?php

namespace Tests\Feature;

use App\Models\Destination;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Feature tests for admin functionality
 */
class AdminTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $user;
    private Destination $destination;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

         // Désactiver le middleware CSRF en CI (GitHub Actions)
        if (getenv('CI') === 'true') {
            $this->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
        }


        // Create admin user
        $this->admin = User::factory()->create([
            'is_admin' => true,
        ]);

        // Create regular user
        $this->user = User::factory()->create([
            'is_admin' => false,
        ]);

        // Create a test destination
        $this->destination = Destination::factory()->create([
            'name' => 'Test Destination',
            'description' => 'Test Description',
            'price' => 100,
            'duration' => 7,
        ]);
    }

    /**
     * Test admin access is restricted to admin users.
     */
    public function test_admin_access_is_restricted(): void
    {
        // Non-authenticated user should be redirected to login
        $this->get(route('admin.destinations.index'))
            ->assertRedirect(route('login'));

        // Regular user should be redirected to login
        $this->actingAs($this->user)
            ->get(route('admin.destinations.index'))
            ->assertRedirect(route('login'));

        // Admin user should access admin panel
        $this->actingAs($this->admin)
            ->get(route('admin.destinations.index'))
            ->assertStatus(200)
            ->assertSee('Manage Destinations');
    }

    /**
     * Test admin can create a destination.
     */
public function test_admin_can_create_destination(): void
{
    Storage::fake('public');

    $this->actingAs($this->admin)
        ->post(route('admin.destinations.store'), [
            'name' => 'New Destination',
            'description' => 'New Description',
            'price' => 150,
            'duration' => 10,
            // L'image est commentée, donc elle ne sera pas envoyée
        ])
        ->assertRedirect(route('admin.destinations.index'))
        ->assertSessionHas('success');

    // Assert the destination was created in the database
    $this->assertDatabaseHas('destinations', [
        'name' => 'New Destination',
        'description' => 'New Description',
        'price' => 150,
        'duration' => 10,
    ]);

    // Assert the image was not stored (if image is optional)
    // Si l'image est optionnelle, il se peut qu'il n'y ait pas d'image
    $destination = Destination::where('name', 'New Destination')->first();
    $this->assertNull($destination->image); // Vérifier qu'aucune image n'a été associée
}


    /**
     * Test admin can update a destination.
     */
    public function test_admin_can_update_destination(): void
    {
        $this->actingAs($this->admin)
            ->put(route('admin.destinations.update', $this->destination), [
                'name' => 'Updated Destination',
                'description' => 'Updated Description',
                'price' => 200,
                'duration' => 14,
            ])
            ->assertRedirect(route('admin.destinations.index'))
            ->assertSessionHas('success');

        // Assert the destination was updated in the database
        $this->assertDatabaseHas('destinations', [
            'id' => $this->destination->id,
            'name' => 'Updated Destination',
            'description' => 'Updated Description',
            'price' => 200,
            'duration' => 14,
        ]);
    }

    /**
     * Test admin can delete a destination.
     */
    public function test_admin_can_delete_destination(): void
    {
        $this->actingAs($this->admin)
            ->delete(route('admin.destinations.destroy', $this->destination))
            ->assertRedirect(route('admin.destinations.index'))
            ->assertSessionHas('success');

        // Assert the destination was deleted from the database
        $this->assertDatabaseMissing('destinations', [
            'id' => $this->destination->id,
        ]);
    }
}
