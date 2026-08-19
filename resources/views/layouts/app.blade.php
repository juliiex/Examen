<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Gestor de Productos')</title>

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

        .btn-volver {
            display: inline-block;
            margin-bottom: 20px;
            color: #555;
        }

        .btn-submit {
            background: #222;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="email"],
        input[type="password"],
        select,
        textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        textarea {
            height: 80px;
            resize: vertical;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px 15px;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .alert-error p {
            margin: 5px 0;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px 15px;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        /* Estilos limpios para la barra de paginación */
        nav[role="navigation"] {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
        }

        nav[role="navigation"] svg {
            width: 20px;
            height: 20px;
        }

        nav[role="navigation"] div:first-child {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        nav[role="navigation"] a,
        nav[role="navigation"] span[aria-disabled="true"],
        nav[role="navigation"] span[aria-current="page"] {
            padding: 6px 12px;
            border: 1px solid #ddd;
            margin: 0 2px;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
        }

        nav[role="navigation"] span[aria-current="page"] {
            background-color: #222;
            color: white;
            border-color: #222;
        }
    </style>

    @yield('styles')
</head>

<body>

    @if (session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert-error">
            {{ session('error') }}
        </div>
    @endif

    @yield('content')

    @yield('scripts')

</body>
</html>
