<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../core/View.php';

class AuthController
{
    private function ensureSessionStarted()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login()
    {
        $this->ensureSessionStarted();

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $error = "⚠️ Todos los campos son obligatorios.";
            } else {
                $user = User::findByEmail($email);

                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['login_success'] = "Bienvenido, {$user['username']}";
                    header('Location: /dashboard');
                    exit;
                } else {
                    $error = "❌ Credenciales incorrectas.";
                }
            }
        }

        // Mostrar el formulario con error si hubo
        View::render('auth/login', ['error' => $error]);
    }

    public function register()
    {
        $this->ensureSessionStarted();

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($email) || empty($password)) {
                $error = "⚠️ Todos los campos son obligatorios.";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $result = User::create($username, $email, $hashedPassword);

                if ($result) {
                    $_SESSION['login_success'] = "Cuenta creada con éxito.";
                    header('Location: /');
                    exit;
                } else {
                    $error = "❌ Error al crear el usuario.";
                }
            }
        }

        View::render('auth/register', ['error' => $error]);
    }

    public function logout()
    {
        $this->ensureSessionStarted();
        $_SESSION = [];
        session_destroy();
        header('Location: /');
        exit;
    }

    public function isLoggedIn()
    {
        $this->ensureSessionStarted();
        return isset($_SESSION['user_id']);
    }

    public function getCurrentUser()
    {
        $this->ensureSessionStarted();
        if (!isset($_SESSION['user_id'])) {
            return null;
        }
        return User::findById($_SESSION['user_id']);
    }
}
