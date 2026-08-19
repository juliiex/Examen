<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_no_autenticado_no_puede_acceder_a_productos(): void
    {
        $response = $this->get('/productos');

        $response->assertRedirect('/login');
    }

    public function test_usuario_puede_iniciar_sesion(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@demo.com',
            'password' => 'admin123',
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@demo.com',
            'password' => 'admin123',
        ]);

        $this->assertAuthenticatedAs($user);

        $response->assertRedirect('/productos');
    }

    public function test_usuario_no_puede_iniciar_sesion_con_credenciales_incorrectas(): void
    {
        User::factory()->create([
            'email' => 'admin@demo.com',
            'password' => 'admin123',
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@demo.com',
            'password' => 'contraseña_incorrecta',
        ]);

        $this->assertGuest();

        $response->assertSessionHasErrors('email');
    }

    public function test_usuario_puede_cerrar_sesion(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post('/logout');

        $this->assertGuest();

        $response->assertRedirect('/login');
    }
}
