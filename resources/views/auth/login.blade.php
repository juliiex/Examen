@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('styles')
    <style>
        body {
            max-width: 500px;
            margin: 60px auto;
        }

        .login-demo {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
            background: #f9f9f9;
            padding: 10px;
            border-radius: 4px;
            border: 1px dashed #ccc;
        }
    </style>
@endsection

@section('content')
    <h1 style="margin-bottom: 25px;">Iniciar sesión</h1>

    @if ($errors->any())
        <div class="alert-error">
            @foreach ($errors->all() as $error)
                <p>• {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="/login">
        @csrf

        <div class="form-group">
            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
            >
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input
                type="password"
                id="password"
                name="password"
                required
            >
        </div>

        <button type="submit" class="btn-submit" style="width: 100%; margin-top: 10px;">
            Iniciar sesión
        </button>
    </form>

    <div class="login-demo">
        <strong>Credenciales demo:</strong><br>
        <code>admin@demo.com</code> / <code>admin123</code>
    </div>
@endsection
