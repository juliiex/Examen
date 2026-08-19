@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')
    <h1>Editar producto</h1>

    <a href="{{ route('productos.index') }}" class="btn-volver">
        ← Volver
    </a>

    @if ($errors->any())
        <div class="alert-error">
            <strong>Hay errores del servidor:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div id="errores-js"></div>

    <form
        id="producto-form"
        method="POST"
        action="{{ route('productos.update', $producto) }}"
        novalidate
    >
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input
                type="text"
                id="nombre"
                name="nombre"
                value="{{ old('nombre', $producto->nombre) }}"
                required
            >
        </div>

        <div class="form-group">
            <label for="categoria_id">Categoría</label>
            <select id="categoria_id" name="categoria_id" required>
                <option value="">Seleccione una categoría</option>
                @foreach ($categorias as $categoria)
                    <option
                        value="{{ $categoria->id }}"
                        @selected(old('categoria_id', $producto->categoria_id) == $categoria->id)
                    >
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion">{{ old('descripcion', $producto->descripcion) }}</textarea>
        </div>

        <div class="form-group">
            <label for="precio">Precio</label>
            <input
                type="number"
                id="precio"
                name="precio"
                step="0.01"
                value="{{ old('precio', $producto->precio) }}"
                required
            >
        </div>

        <div class="form-group">
            <label for="stock">Stock</label>
            <input
                type="number"
                id="stock"
                name="stock"
                value="{{ old('stock', $producto->stock) }}"
                required
            >
        </div>

        <div class="form-group">
            <label style="font-weight: normal; cursor: pointer;">
                <input
                    type="checkbox"
                    id="activo"
                    name="activo"
                    value="1"
                    @checked(old('activo', $producto->activo))
                >
                Producto activo
            </label>
        </div>

        <button type="submit" class="btn-submit">
            Actualizar producto
        </button>
    </form>
@endsection

@section('scripts')
    <script>
        const formulario = document.getElementById('producto-form');
        const nombre = document.getElementById('nombre');
        const categoria = document.getElementById('categoria_id');
        const precio = document.getElementById('precio');
        const stock = document.getElementById('stock');
        const errores = document.getElementById('errores-js');

        formulario.addEventListener('submit', function(event) {
            errores.innerHTML = '';
            const erroresEncontrados = [];

            if (!nombre.value.trim()) {
                erroresEncontrados.push('El nombre del producto es obligatorio.');
            }

            if (!categoria.value) {
                erroresEncontrados.push('Debe seleccionar una categoría.');
            }

            const precioValor = parseFloat(precio.value);
            const stockValor = parseInt(stock.value, 10);

            if (isNaN(precioValor) || precioValor <= 0) {
                erroresEncontrados.push('El precio debe ser mayor a 0.');
            }

            if (isNaN(stockValor) || stockValor < 0) {
                erroresEncontrados.push('El stock no puede ser negativo.');
            }

            if (erroresEncontrados.length > 0) {
                event.preventDefault();

                errores.innerHTML = `
                    <div class="alert-error">
                        <strong>Errores en el formulario:</strong>
                        ${erroresEncontrados.map(err => `<p>• ${err}</p>`).join('')}
                    </div>
                `;

                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        });
    </script>
@endsection
