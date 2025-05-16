<?php
session_start();
require_once __DIR__ . '/../app/Database.php';
require_once __DIR__ . '/../app/Auth.php';

$db = new Database();
$auth = new Auth($db->getConnection());

if (!$auth->isLoggedIn()) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    <div class="sidebar">
        <h2>📊 Mi Panel</h2>
        <a href="dashboard.php">Inicio</a>
        <a href="#">Usuarios</a>
        <a href="#">Actividad</a>
        <a href="#">Gráficas</a>
        <a href="logout.php">Cerrar sesión</a>
    </div>

    <div class="content">
        <h1>Bienvenido al dashboard de administración</h1>
        <div class="card">
            <h2>Usuarios por mes</h2>
            <canvas id="userChart" width="400" height="200"></canvas>
        </div>
        <div class="card">
            <h2>Actividad reciente</h2>
            <canvas id="loginsChart" width="400" height="200"></canvas>
        </div>
    </div>
    <script>
        // Gráfica de usuarios por mes
        fetch('api/user-stats.php')
            .then(res => res.json())
            .then(data => {
                const labels = Object.keys(data);
                const counts = Object.values(data);

                const ctx = document.getElementById('userChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Usuarios registrados',
                            data: counts,
                            borderColor: 'rgba(52, 152, 219, 1)',
                            backgroundColor: 'rgba(52, 152, 219, 0.2)',
                            fill: true,
                            tension: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
    </script>

    <script>
        // Gráfica de inicios de sesión recientes
        fetch('api/logins_data.php')
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => item.date).reverse();
                const counts = data.map(item => item.count).reverse();

                const ctx = document.getElementById('loginsChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Inicios de sesión',
                            data: counts,
                            borderColor: 'rgb(75, 192, 192)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            fill: true,
                            tension: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                precision: 0
                            }
                        }
                    }
                });
            });
    </script>


</body>

</html>