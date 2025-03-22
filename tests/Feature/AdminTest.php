<?php

namespace Tests\Feature;

use App\Models\Destination;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected $middlewareExcludedFromDisabling = [];

    private User $admin;
    private User $user;
    private Destination $destination;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);
        $this->withoutExceptionHandling();

        // Création des utilisateurs
        $this->admin = User::factory()->create(['is_admin' => true]);
        $this->user = User::factory()->create(['is_admin' => false]);
        $this->destination = Destination::factory()->create();
    }

    public function test_admin_access_is_restricted(): void
    {
        // Non-authentifié -> redirection login
        $this->get(route('admin.destinations.index'))
            ->assertRedirect(route('login'));

        // Utilisateur normal -> redirection login
        $this->actingAs($this->user)
            ->get(route('admin.destinations.index'))
            ->assertRedirect(route('login'));

        // Admin -> accès autorisé
        $this->actingAs($this->admin)
            ->get(route('admin.destinations.index'))
            ->assertStatus(200)
            ->assertSee('Manage Destinations');
    }

    public function test_admin_can_create_destination(): void
    {
        Storage::fake('public');
        
        $this->actingAs($this->admin)
            ->post(route('admin.destinations.store'), [
                '_token' => csrf_token(),
                'name' => 'New Destination',
                'description' => 'New Description',
                'price' => 150,
                'duration' => 10,
            ])
            ->assertRedirect(route('admin.destinations.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('destinations', [
            'name' => 'New Destination',
            'description' => 'New Description',
            'price' => 150,
            'duration' => 10,
        ]);
    }

    public function test_admin_can_update_destination(): void
    {
        $this->actingAs($this->admin)
            ->put(route('admin.destinations.update', $this->destination), [
                '_method' => 'PUT',
                '_token' => csrf_token(),
                'name' => 'Updated Destination',
                'description' => 'Updated Description',
                'price' => 200,
                'duration' => 14,
            ])
            ->assertRedirect(route('admin.destinations.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('destinations', [
            'id' => $this->destination->id,
            'name' => 'Updated Destination',
            'description' => 'Updated Description',
            'price' => 200,
            'duration' => 14,
        ]);
    }

    public function test_admin_can_delete_destination(): void
    {
        $this->actingAs($this->admin)
            ->delete(route('admin.destinations.destroy', $this->destination), [
                '_token' => csrf_token(),
            ])
            ->assertRedirect(route('admin.destinations.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('destinations', [
            'id' => $this->destination->id,
        ]);
    }
}
