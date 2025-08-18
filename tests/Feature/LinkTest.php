<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class LinkTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function an_authenticated_user_can_create_a_short_link()
    {
        // Crie um usuário para autenticação
        $user = User::factory()->create();

        $data = [
            'original_url' => 'https://www.google.com',
            'expires_at' => now()->addDays(7)->toIso8601String(), // Data futura
        ];

        $response = $this->actingAs($user)->postJson('/api/links', $data);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'message',
                     'link' => [
                         'original_url',
                         'slug',
                         'expires_at',
                         'short_url',
                         'qr_code'
                     ]
                 ]);

        // Verifique se o link foi salvo no banco de dados
        $this->assertDatabaseHas('links', [
            'user_id' => $user->id,
            'original_url' => 'https://www.google.com',
        ]);
    }

    #[Test]
    public function a_guest_user_cannot_create_a_short_link()
    {
        $data = [
            'original_url' => 'https://www.google.com'
        ];

        // Tente criar o link sem autenticação
        $response = $this->postJson('/api/links', $data);

        $response->assertStatus(401); // 401 Unauthorized
    }

    #[Test]
    public function creating_a_link_requires_a_valid_original_url()
    {
        $user = User::factory()->create();

        // Tente criar o link com uma URL inválida
        $response = $this->actingAs($user)->postJson('/api/links', [
            'original_url' => 'not-a-valid-url',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['original_url']);
    }
}
