<h1 class="dashboard-title">Panel de Control</h1>

<!-- Overview Stats -->
<div class="stats-container">
    <div class="stat-card">
        <div class="stat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
        </div>
        <div class="stat-content">
            <h3>Usuarios Totales</h3>
            <p class="stat-value"><?= $totalUsers ?? 0 ?></p>
            <p
                class="stat-change <?= isset($userGrowthPercentage) && $userGrowthPercentage >= 0 ? 'positive' : 'negative' ?>">
                <?= isset($userGrowthPercentage) ? (($userGrowthPercentage >= 0 ? '+' : '') . $userGrowthPercentage . '% este mes') : '0% este mes' ?>
            </p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
            </svg>
        </div>
        <div class="stat-content">
            <h3>Actividad Diaria</h3>
            <p class="stat-value"><?= $todayLogins ?? 0 ?> sesiones</p>
            <p
                class="stat-change <?= isset($todayLogins, $yesterdayLogins) && $todayLogins >= $yesterdayLogins ? 'positive' : 'negative' ?>">
                <?php if (isset($todayLogins, $yesterdayLogins)): ?>
                    <?php if ($todayLogins > $yesterdayLogins): ?>
                        +<?= $todayLogins - $yesterdayLogins ?> vs. ayer
                    <?php elseif ($todayLogins < $yesterdayLogins): ?>
                        -<?= $yesterdayLogins - $todayLogins ?> vs. ayer
                    <?php else: ?>
                        Similar al promedio
                    <?php endif; ?>
                <?php else: ?>
                    Similar al promedio
                <?php endif; ?>
            </p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
        </div>
        <div class="stat-content">
            <h3>Nuevos Hoy</h3>
            <p class="stat-value"><?= $newUsersToday ?? 0 ?> usuarios</p>
            <p
                class="stat-change <?= isset($newUsersToday, $newUsersYesterday) && $newUsersToday >= $newUsersYesterday ? 'positive' : 'negative' ?>">
                <?php if (isset($newUsersToday, $newUsersYesterday)): ?>
                    <?php if ($newUsersToday > $newUsersYesterday): ?>
                        +<?= $newUsersToday - $newUsersYesterday ?> vs. ayer
                    <?php elseif ($newUsersToday < $newUsersYesterday): ?>
                        -<?= $newUsersYesterday - $newUsersToday ?> vs. ayer
                    <?php else: ?>
                        Igual que ayer
                    <?php endif; ?>
                <?php else: ?>
                    Igual que ayer
                <?php endif; ?>
            </p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
        </div>
        <div class="stat-content">
            <h3>Estado Sistema</h3>
            <p class="stat-value">Operativo</p>
            <p class="stat-change positive">100% uptime</p>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card">
    <div class="card-header">
        <h2>Acciones Rápidas</h2>
    </div>
    <div class="quick-actions">
        <button class="action-button" data-action="add-user">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="8.5" cy="7" r="4"></circle>
                <line x1="20" y1="8" x2="20" y2="14"></line>
                <line x1="23" y1="11" x2="17" y2="11"></line>
            </svg>
            <span class="action-text">Añadir Usuario</span>
        </button>
        <button class="action-button" data-action="new-report">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="12" y1="18" x2="12" y2="12"></line>
                <line x1="9" y1="15" x2="15" y2="15"></line>
            </svg>
            <span class="action-text">Nuevo Reporte</span>
        </button>
        <button class="action-button" data-action="send-message">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
            </svg>
            <span class="action-text">Enviar Mensaje</span>
            <!-- <span class="action-badge">3</span> -->
        </button>
        <button class="action-button" data-action="more-actions">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="16"></line>
                <line x1="8" y1="12" x2="16" y2="12"></line>
            </svg>
            <span class="action-text">Más Acciones</span>
        </button>
    </div>
</div>

<!-- Recent Activity -->
<div class="card">
    <div class="card-header">
        <h2>Actividad Reciente</h2>
        <a href="#" class="view-all">Ver todo</a>
    </div>
    <div class="activity-list">
        <?php if (empty($recentEvents)): ?>
            <div class="activity-empty">
                <p>No hay actividad reciente para mostrar.</p>
            </div>
        <?php else: ?>
            <?php foreach ($recentEvents as $event): ?>
                <div class="activity-item">
                    <div class="activity-icon <?= $event['event_type'] ?>">
                        <?php if ($event['event_type'] === 'login'): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                <polyline points="10 17 15 12 10 7"></polyline>
                                <line x1="15" y1="12" x2="3" y2="12"></line>
                            </svg>
                        <?php elseif ($event['event_type'] === 'register'): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="8.5" cy="7" r="4"></circle>
                                <line x1="20" y1="8" x2="20" y2="14"></line>
                                <line x1="23" y1="11" x2="17" y2="11"></line>
                            </svg>
                        <?php elseif ($event['event_type'] === 'logout'): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                        <?php endif; ?>
                    </div>
                    <div class="activity-content">
                        <p>
                            <strong><?= htmlspecialchars($event['username']) ?></strong>
                            <?= match ($event['event_type']) {
                                'login' => 'inició sesión',
                                'register' => 'se registró en el sistema',
                                'logout' => 'cerró sesión',
                                default => 'realizó una acción',
                            } ?>
                        </p>
                        <span class="activity-time">
                            <?= function_exists('timeRelative') ? timeRelative($event['login_time']) : date('d/m/Y H:i', strtotime($event['login_time'])) ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Charts Row -->
<div class="charts-row">
    <div class="card chart-card">
        <div class="card-header">
            <h2>Usuarios por Mes</h2>
        </div>
        <canvas id="userChart" width="400" height="200"></canvas>
    </div>

    <div class="card chart-card">
        <div class="card-header">
            <h2>Actividad Reciente</h2>
        </div>
        <canvas id="loginsChart" width="400" height="200"></canvas>
    </div>
</div>

<script>
    // Gráfica de usuarios por mes
    const usersByMonth = <?= json_encode($usersByMonth ?? []) ?>;
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
    const loginsData = <?= json_encode($loginsData ?? []) ?>;

    const allDates = [...new Set(loginsData.map(item => item.date))].reverse();

    const types = ['login', 'logout', 'register'];
    const datasets = types.map(type => {
        const data = allDates.map(date => {
            const found = loginsData.find(item => item.date === date && item.event_type === type);
            return found ? parseInt(found.count) : 0;
        });
        return {
            label: type.charAt(0).toUpperCase() + type.slice(1),
            data: data,
            borderColor: {
                login: 'rgb(75, 192, 192)',
                logout: 'rgb(255, 99, 132)',
                register: 'rgb(255, 206, 86)'
            }[type],
            backgroundColor: {
                login: 'rgba(75, 192, 192, 0.2)',
                logout: 'rgba(255, 99, 132, 0.2)',
                register: 'rgba(255, 206, 86, 0.2)'
            }[type],
            fill: true,
            tension: 0.3
        };
    });

    const ctx2 = document.getElementById('loginsChart').getContext('2d');
    new Chart(ctx2, {
        type: 'line',
        data: {
            labels: allDates,
            datasets: datasets
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