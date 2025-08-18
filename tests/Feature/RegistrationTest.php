<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_register_with_valid_credentials()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(201)
                 ->assertJson(['message' => 'Usuário criado com sucesso!',
                    'user' => [
                        'name' => 'John Doe',
                        'email' => 'jhondoe@example.com',
                    ]
                ]);

        $this->assertDatabaseHas('users', ['email' => 'johndoe@example.com']);
        $this->assertCount(1, User::all());
    }

    /** @test */
    public function a_user_cannot_register_with_an_existing_email()
    {
        User::factory()->create(['email' => 'existing@example.com']);

        $data = [
            'name' => 'Jane Smith',
            'email' => 'existing@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function a_user_cannot_register_with_invalid_data()
    {
        $response = $this->postJson('/api/register', [
            'name' => '', // Nome vazio
            'email' => 'not-an-email', // Email inválido
            'password' => 'short', // Senha muito curta
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name', 'email', 'password']);
    }
}
