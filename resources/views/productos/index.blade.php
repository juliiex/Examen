@extends('layouts.app')

@section('title', 'Gestor de Productos')

@section('content')
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

        <div style="display: flex; gap: 10px;">
            <a href="{{ route('categorias.index') }}" class="btn-crear" style="background-color: #4a5568;">
                Ver Categorías
            </a>

            <a href="{{ route('productos.create') }}" class="btn-crear">
                + Nuevo producto
            </a>
        </div>
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

    <div id="paginacion-container" style="margin-top: 20px;">
        {{ $productos->links() }}
    </div>
@endsection

@section('scripts')
    <script>
        const inputBusqueda = document.getElementById('busqueda');
        const tablaProductos = document.getElementById('tabla-productos');
        const paginacionContainer = document.getElementById('paginacion-container');
        const csrfToken = '{{ csrf_token() }}';
        let temporizador;

        function buscarProductos(query) {
            if (query === '') {
                window.location.reload();
                return;
            }

            if (paginacionContainer) {
                paginacionContainer.style.display = 'none';
            }

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
        }

        inputBusqueda.addEventListener('input', function () {
            clearTimeout(temporizador);

            temporizador = setTimeout(() => {
                buscarProductos(this.value.trim());
            }, 300);
        });
    </script>
@endsection
