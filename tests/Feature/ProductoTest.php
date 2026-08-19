<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductoTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_autenticado_puede_ver_productos(): void
    {
        $usuario = User::factory()->create();

        $response = $this->actingAs($usuario)
            ->get('/productos');

        $response->assertStatus(200);
    }

    public function test_usuario_puede_crear_un_producto(): void
    {
        $usuario = User::factory()->create();

        $categoria = Categoria::create([
            'nombre' => 'Electrónica',
        ]);

        $response = $this->actingAs($usuario)
            ->post('/productos', [
                'categoria_id' => $categoria->id,
                'nombre' => 'Teclado mecánico',
                'descripcion' => 'Teclado mecánico RGB',
                'precio' => 150,
                'stock' => 10,
                'activo' => 1,
            ]);

        $response->assertRedirect('/productos');

        $this->assertDatabaseHas('productos', [
            'nombre' => 'Teclado mecánico',
            'precio' => 150,
            'stock' => 10,
        ]);
    }

    public function test_no_se_puede_crear_producto_con_stock_negativo(): void
    {
        $usuario = User::factory()->create();

        $categoria = Categoria::create([
            'nombre' => 'Electrónica',
        ]);

        $response = $this->actingAs($usuario)
            ->post('/productos', [
                'categoria_id' => $categoria->id,
                'nombre' => 'Producto inválido',
                'descripcion' => 'Prueba',
                'precio' => 100,
                'stock' => -5,
                'activo' => 1,
            ]);

        $response->assertSessionHasErrors('stock');

        $this->assertDatabaseMissing('productos', [
            'nombre' => 'Producto inválido',
        ]);
    }

    public function test_no_se_puede_crear_producto_con_precio_negativo(): void
    {
        $usuario = User::factory()->create();

        $categoria = Categoria::create([
            'nombre' => 'Electrónica',
        ]);

        $response = $this->actingAs($usuario)
            ->post('/productos', [
                'categoria_id' => $categoria->id,
                'nombre' => 'Producto inválido',
                'descripcion' => 'Prueba',
                'precio' => -100,
                'stock' => 10,
                'activo' => 1,
            ]);

        $response->assertSessionHasErrors('precio');

        $this->assertDatabaseMissing('productos', [
            'nombre' => 'Producto inválido',
        ]);
    }

    public function test_usuario_puede_actualizar_un_producto(): void
    {
        $usuario = User::factory()->create();

        $categoria = Categoria::create([
            'nombre' => 'Electrónica',
        ]);

        $producto = Producto::create([
            'categoria_id' => $categoria->id,
            'nombre' => 'Mouse',
            'descripcion' => 'Mouse básico',
            'precio' => 20,
            'stock' => 10,
            'activo' => true,
        ]);

        $response = $this->actingAs($usuario)
            ->put("/productos/{$producto->id}", [
                'categoria_id' => $categoria->id,
                'nombre' => 'Mouse Gamer',
                'descripcion' => 'Mouse gamer RGB',
                'precio' => 50,
                'stock' => 15,
                'activo' => 1,
            ]);

        $response->assertRedirect('/productos');

        $this->assertDatabaseHas('productos', [
            'id' => $producto->id,
            'nombre' => 'Mouse Gamer',
            'precio' => 50,
            'stock' => 15,
        ]);
    }

    public function test_eliminar_producto_lo_desactiva(): void
    {
        $usuario = User::factory()->create();

        $categoria = Categoria::create([
            'nombre' => 'Hogar',
        ]);

        $producto = Producto::create([
            'categoria_id' => $categoria->id,
            'nombre' => 'Mesa',
            'descripcion' => 'Mesa de madera',
            'precio' => 200,
            'stock' => 5,
            'activo' => true,
        ]);

        $response = $this->actingAs($usuario)
            ->delete("/productos/{$producto->id}");

        $response->assertRedirect('/productos');

        $this->assertDatabaseHas('productos', [
            'id' => $producto->id,
            'activo' => false,
        ]);
    }
}
