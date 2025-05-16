

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registrarse</title>
    <style>
        body {
            background: #f0f2f5;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h2 {
            text-align: center;
            margin-bottom: 1rem;
        }

        input {
            width: 100%;
            padding: 0.6rem;
            margin: 0.5rem 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            background: #28a745;
            color: white;
            border: none;
            padding: 0.7rem;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 1rem;
        }

        button:hover {
            background: #218838;
        }

        .message {
            color: red;
            text-align: center;
            margin-bottom: 1rem;
        }

        .link {
            margin-top: 1rem;
            text-align: center;
            font-size: 0.9rem;
        }

        .link a {
            color: #007BFF;
            text-decoration: none;
        }

        .link a:hover {
            text-decoration: underline;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container">
        <h2>Registrarse</h2>

    

        <form method="POST">
            <input type="text" name="username" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <input type="text" name="email" placeholder="Correo electrónico" required>
            <button type="submit">Crear cuenta</button>
        </form>

        <div class="link">
            ¿Ya tienes cuenta? <a href="index.php">Inicia sesión</a>
        </div>
    </div>
</body>

</html>