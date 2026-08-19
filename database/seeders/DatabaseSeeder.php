<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $electronica = Categoria::create([
            'nombre' => 'Electrónica',
        ]);

        $hogar = Categoria::create([
            'nombre' => 'Hogar',
        ]);

        $oficina = Categoria::create([
            'nombre' => 'Oficina',
        ]);

        $deportes = Categoria::create([
            'nombre' => 'Deportes',
        ]);

        Producto::create([
            'categoria_id' => $electronica->id,
            'nombre' => 'Audífonos Bluetooth',
            'descripcion' => 'Audífonos inalámbricos con cancelación de ruido',
            'precio' => 89.90,
            'stock' => 25,
            'activo' => true,
        ]);

        Producto::create([
            'categoria_id' => $electronica->id,
            'nombre' => 'Cargador USB-C 20W',
            'descripcion' => 'Cargador rápido compatible con múltiples dispositivos',
            'precio' => 15.50,
            'stock' => 60,
            'activo' => true,
        ]);

        Producto::create([
            'categoria_id' => $electronica->id,
            'nombre' => 'Mouse inalámbrico',
            'descripcion' => 'Mouse ergonómico con receptor USB',
            'precio' => 22.00,
            'stock' => 40,
            'activo' => true,
        ]);

        Producto::create([
            'categoria_id' => $hogar->id,
            'nombre' => 'Set de sábanas',
            'descripcion' => 'Juego de sábanas 100% algodón, cama queen',
            'precio' => 45.00,
            'stock' => 15,
            'activo' => true,
        ]);

        Producto::create([
            'categoria_id' => $hogar->id,
            'nombre' => 'Lámpara de escritorio LED',
            'descripcion' => 'Lámpara regulable con puerto USB',
            'precio' => 32.75,
            'stock' => 20,
            'activo' => true,
        ]);

        Producto::create([
            'categoria_id' => $oficina->id,
            'nombre' => 'Silla ergonómica',
            'descripcion' => 'Silla de oficina con soporte lumbar',
            'precio' => 210.00,
            'stock' => 8,
            'activo' => true,
        ]);

        Producto::create([
            'categoria_id' => $oficina->id,
            'nombre' => 'Organizador de escritorio',
            'descripcion' => 'Organizador de madera para útiles de oficina',
            'precio' => 18.30,
            'stock' => 30,
            'activo' => true,
        ]);

        Producto::create([
            'categoria_id' => $deportes->id,
            'nombre' => 'Balón de fútbol',
            'descripcion' => 'Balón oficial talla 5',
            'precio' => 25.90,
            'stock' => 50,
            'activo' => true,
        ]);

        Producto::create([
            'categoria_id' => $deportes->id,
            'nombre' => 'Botella deportiva',
            'descripcion' => 'Botella térmica de 1 litro',
            'precio' => 12.00,
            'stock' => 70,
            'activo' => true,
        ]);
    }
}
