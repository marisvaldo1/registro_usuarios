<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsuarioRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_registration_with_valid_data()
    {
        $response = $this->postJson('/api/usuarios', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(201)
            ->assertJson(['message' => 'Usuário registrado com sucesso']);

        $this->assertDatabaseHas('usuarios', [
            'email' => 'john@example.com',
        ]);
    }

    public function test_usuario_registration_with_invalid_data()
    {
        $response = $this->postJson('/api/usuarios', [
            'name' => 'Jo',
            'email' => 'invalid-email',
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'email', 'password']);
    }
}
