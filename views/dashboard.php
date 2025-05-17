
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/assets/css/style.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>


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
    const usersByMonth = <?= json_encode($usersByMonth) ?>;
    const userLabels = Object.keys(usersByMonth);
    const userCounts = Object.values(usersByMonth);

    const ctx1 = document.getElementById('userChart').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: userLabels,
            datasets: [{
                label: 'Usuarios registrados',
                data: userCounts,
                borderColor: 'rgba(52, 152, 219, 1)',
                backgroundColor: 'rgba(52, 152, 219, 0.2)',
                fill: true,
                tension: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Gráfica de inicios de sesión
    const loginsData = <?= json_encode($loginsData) ?>.reverse();
    const loginLabels = loginsData.map(item => item.date);
    const loginCounts = loginsData.map(item => item.count);

    const ctx2 = document.getElementById('loginsChart').getContext('2d');
    new Chart(ctx2, {
        type: 'line',
        data: {
            labels: loginLabels,
            datasets: [{
                label: 'Inicios de sesión',
                data: loginCounts,
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
</script>


</body>

</html>