@extends('layouts.app')

@section('title', 'Categorías - Gestor de Productos')

@section('content')
    <div class="header-top">
        <h1 style="margin: 0;">Categorías</h1>

        <a href="{{ route('productos.index') }}" class="btn-volver" style="margin-bottom: 0;">
            ← Volver a Productos
        </a>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 100px;">ID</th>
                <th>Nombre</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($categorias as $categoria)
                <tr>
                    <td>{{ $categoria->id }}</td>
                    <td>{{ $categoria->nombre }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No hay categorías registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
