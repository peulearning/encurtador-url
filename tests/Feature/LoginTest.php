<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_user_can_log_in_with_valid_credentials()
    {
        // Crie um usuário no banco de dados para o teste
        $user = User::factory()->create([
            'email' => 'jhondoe@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'jhondoe@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Login successful.',
                 ]);

        $this->assertIsString($response->json('token'));
        $response->assertHeader('Content-Type', 'application/json');


    }

    #[Test]
    public function a_user_cannot_log_in_with_invalid_credentials()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401) // 401 Unauthorized
                 ->assertJson(['message' => 'Invalid credentials.']);
    }
}
