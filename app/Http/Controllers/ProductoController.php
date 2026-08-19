<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductoController extends Controller
{
    /**
     * Muestra el listado de productos con paginación.
     */
    public function index(): View
    {
        $productos = Producto::with('categoria')
            ->orderByDesc('id')
            ->paginate(10);

        return view('productos.index', compact('productos'));
    }

    /**
     * Endpoint de búsqueda dinámica por nombre (JSON).
     * Previene SQL Injection usando consultas parametrizadas con Eloquent.
     */
    public function buscar(Request $request): JsonResponse
    {
        $q = $request->input('q', '');

        $productos = Producto::with('categoria')
            ->where('nombre', 'like', '%' . $q . '%')
            ->orderByDesc('id')
            ->get();

        return response()->json($productos);
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     */
    public function create(): View
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('productos.create', compact('categorias'));
    }

    /**
     * Almacena un producto recién creado en la base de datos.
     */
    public function store(StoreProductoRequest $request): RedirectResponse
    {
        Producto::create($request->validated());

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto creado correctamente.');
    }

    /**
     * Muestra el detalle de un producto específico.
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Muestra el formulario de edición de un producto.
     */
    public function edit(Producto $producto): View
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('productos.edit', compact('producto', 'categorias'));
    }

    /**
     * Actualiza el producto especificado en la base de datos.
     */
    public function update(UpdateProductoRequest $request, Producto $producto): RedirectResponse
    {
        $producto->update($request->validated());

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Desactiva lógicamente el producto especificado.
     */
    public function destroy(Producto $producto): RedirectResponse
    {
        $producto->update([
            'activo' => false,
        ]);

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto desactivado exitosamente.');
    }
}
