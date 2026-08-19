<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Categorías - Gestor de Productos</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #f5f5f5;
        }

        .btn {
            display: inline-block;
            padding: 7px 12px;
            background: #222;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
</head>

<body>

    <div class="header">

        <h1>Categorías</h1>

        <a href="{{ route('productos.index') }}" class="btn">
            ← Productos
        </a>

    </div>

    <table>

        <thead>
            <tr>
                <th>ID</th>
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
                    <td colspan="2">
                        No hay categorías registradas.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</body>
</html>
