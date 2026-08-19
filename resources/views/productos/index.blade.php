<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gestor de Productos</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1100px;
            margin: 40px auto;
            padding: 20px;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .user-nav {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 10px;
        }

        #busqueda {
            padding: 8px 12px;
            font-size: 14px;
            width: 320px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #f5f5f5;
        }

        a, button {
            padding: 6px 12px;
            text-decoration: none;
            cursor: pointer;
            border-radius: 4px;
        }

        .btn-crear {
            display: inline-block;
            background: #222;
            color: white;
        }

        .btn-logout {
            background: #f4f4f4;
            color: #333;
            border: 1px solid #ccc;
        }

        .btn-eliminar {
            background: #e3342f;
            color: white;
            border: none;
        }
    </style>
</head>

<body>

    <div class="header-top">
        <h1 style="margin: 0;">Gestor de Productos</h1>

        <div class="user-nav">
            <span>Bienvenido, <strong>{{ auth()->user()->name ?? 'Usuario' }}</strong></span>

            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn-logout">Cerrar sesión</button>
            </form>
        </div>
    </div>

    <div class="header-actions">
        <input
            type="text"
            id="busqueda"
            placeholder="Buscar por nombre..."
            autocomplete="off"
        >

        <a href="{{ route('productos.create') }}" class="btn-crear">
            + Nuevo producto
        </a>
    </div>

    <table>

        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody id="tabla-productos">

            @forelse ($productos as $producto)

                <tr>
                    <td>{{ $producto->id }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->categoria ? $producto->categoria->nombre : '-' }}</td>
                    <td>${{ number_format($producto->precio, 2) }}</td>
                    <td>{{ $producto->stock }}</td>
                    <td>{{ $producto->activo ? 'Sí' : 'No' }}</td>
                    <td>
                        <a href="{{ route('productos.edit', $producto) }}">Editar</a>

                        <form
                            action="{{ route('productos.destroy', $producto) }}"
                            method="POST"
                            style="display:inline;"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn-eliminar"
                                onclick="return confirm('¿Seguro que deseas eliminar este producto?')"
                            >
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="7">No hay productos registrados.</td>
                </tr>

            @endforelse

        </tbody>

    </table>

    <script>
        const inputBusqueda = document.getElementById('busqueda');
        const tablaProductos = document.getElementById('tabla-productos');
        const csrfToken = '{{ csrf_token() }}';

        inputBusqueda.addEventListener('input', function () {
            const query = this.value;

            fetch(`{{ route('productos.buscar') }}?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(productos => {
                    if (productos.length === 0) {
                        tablaProductos.innerHTML = `
                            <tr>
                                <td colspan="7">No se encontraron productos.</td>
                            </tr>
                        `;
                        return;
                    }

                    tablaProductos.innerHTML = productos.map(producto => `
                        <tr>
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td>${producto.categoria ? producto.categoria.nombre : '-'}</td>
                            <td>$${parseFloat(producto.precio).toFixed(2)}</td>
                            <td>${producto.stock}</td>
                            <td>${producto.activo ? 'Sí' : 'No'}</td>
                            <td>
                                <a href="/productos/${producto.id}/edit">Editar</a>

                                <form action="/productos/${producto.id}" method="POST" style="display:inline;">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button
                                        type="submit"
                                        class="btn-eliminar"
                                        onclick="return confirm('¿Seguro que deseas eliminar este producto?')"
                                    >
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    `).join('');
                })
                .catch(error => console.error('Error en la búsqueda:', error));
        });
    </script>

</body>
</html>
