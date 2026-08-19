<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Iniciar sesión</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 500px;
            margin: 80px auto;
            padding: 20px;
        }

        h1 {
            margin-bottom: 25px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        input {
            padding: 10px;
            font-size: 15px;
        }

        button {
            padding: 10px;
            cursor: pointer;
            margin-top: 10px;
        }

        .error {
            background: #ffe0e0;
            padding: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <h1>Iniciar sesión</h1>

    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="/login">

        @csrf

        <label for="email">
            Email
        </label>

        <input
            type="email"
            id="email"
            name="email"
            value="{{ old('email') }}"
            required
        >

        <label for="password">
            Contraseña
        </label>

        <input
            type="password"
            id="password"
            name="password"
            required
        >

        <button type="submit">
            Iniciar sesión
        </button>

    </form>

    <p>
        Demo: admin@demo.com / admin123
    </p>

</body>
</html>
