<?php
session_start();
require_once __DIR__ . '/../app/Database.php';
require_once __DIR__ . '/../app/Auth.php';

$db = new Database();
$auth = new Auth($db->getConnection());

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if ($auth->login($username, $password)) {
        $_SESSION['login_success'] = "Bienvenido, $username";
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "❌ Credenciales incorrectas";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: #f0f2f5;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
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
            background: #007BFF;
            color: white;
            border: none;
            padding: 0.7rem;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 1rem;
        }

        button:hover {
            background: #0056b3;
        }

        .error {
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
</head>

<body>
    <?php if (isset($_SESSION['login_success'])): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Inicio de sesión exitoso',
                text: <?= json_encode($_SESSION['login_success']) ?>,
                confirmButtonColor: '#28a745'
            });
        </script>
        <?php unset($_SESSION['login_success']); ?>
    <?php endif; ?>

    <div class="container">
        <h2>Iniciar Sesión</h2>

        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="username" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Entrar</button>
        </form>

        <div class="link">
            ¿No tienes cuenta? <a href="register.php">Regístrate</a>
        </div>
    </div>
</body>

</html>