<div class="dashboard-header">
    <div class="header-content">
        <h1 class="dashboard-title">Panel de Control</h1>
        <p class="dashboard-subtitle">Resumen general del sistema ERP</p>
    </div>
    <div class="header-actions">
        <div class="date-info">
            <span class="current-date"><?= date('d/m/Y') ?></span>
            <span class="current-time" id="current-time"><?= date('H:i') ?></span>
        </div>
    </div>
</div>

<!-- Métricas principales -->
<div class="metrics-container">
    <div class="metric-card primary">
        <div class="metric-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
        </div>
        <div class="metric-content">
            <h3>Total de Usuarios</h3>
            <p class="metric-value"><?= $totalUsers ?? 0 ?></p>
            <div class="metric-trend">
                <span class="trend-indicator <?= isset($userGrowthPercentage) && $userGrowthPercentage >= 0 ? 'positive' : 'negative' ?>">
                    <?php if (isset($userGrowthPercentage)): ?>
                        <?= $userGrowthPercentage >= 0 ? '↗' : '↘' ?> <?= abs($userGrowthPercentage) ?>%
                    <?php else: ?>
                        → 0%
                    <?php endif; ?>
                </span>
                <span class="trend-label">vs. mes anterior</span>
            </div>
        </div>
    </div>

    <div class="metric-card success">
        <div class="metric-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="M12 6v6l4 2"></path>
            </svg>
        </div>
        <div class="metric-content">
            <h3>Usuarios Activos</h3>
            <p class="metric-value"><?= $activeUsers ?? 0 ?></p>
            <div class="metric-trend">
                <span class="trend-label">Últimos 30 días</span>
            </div>
        </div>
    </div>

    <div class="metric-card info">
        <div class="metric-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
        </div>
        <div class="metric-content">
            <h3>Nuevos Este Mes</h3>
            <p class="metric-value"><?= $newUsersThisMonth ?? 0 ?></p>
            <div class="metric-trend">
                <span class="trend-label">Registros mensuales</span>
            </div>
        </div>
    </div>
</div>

<!-- Contenido principal -->
<div class="main-content">
    <!-- Acciones Rápidas -->
    <div class="section-card">
        <div class="section-header">
            <h2>Acciones Rápidas</h2>
            <p class="section-description">Operaciones frecuentes del sistema</p>
        </div>
        <div class="quick-actions-grid">
            <button class="action-card" data-action="add-user">
                <div class="action-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="8.5" cy="7" r="4"></circle>
                        <line x1="20" y1="8" x2="20" y2="14"></line>
                        <line x1="23" y1="11" x2="17" y2="11"></line>
                    </svg>
                </div>
                <div class="action-content">
                    <h4>Añadir Usuario</h4>
                    <p>Crear nueva cuenta de usuario</p>
                </div>
            </button>

            <button class="action-card" data-action="new-report">
                <div class="action-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="12" y1="18" x2="12" y2="12"></line>
                        <line x1="9" y1="15" x2="15" y2="15"></line>
                    </svg>
                </div>
                <div class="action-content">
                    <h4>Generar Reporte</h4>
                    <p>Crear reportes del sistema</p>
                </div>
            </button>

            <button class="action-card" data-action="backup-data">
                <div class="action-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="17 8 12 3 7 8"></polyline>
                        <line x1="12" y1="3" x2="12" y2="15"></line>
                    </svg>
                </div>
                <div class="action-content">
                    <h4>Respaldo de Datos</h4>
                    <p>Crear copia de seguridad</p>
                </div>
            </button>

            <button class="action-card" data-action="system-settings">
                <div class="action-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="3"></circle>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1 1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                    </svg>
                </div>
                <div class="action-content">
                    <h4>Configuración</h4>
                    <p>Ajustes del sistema</p>
                </div>
            </button>
        </div>
    </div>

    <!-- Layout de dos columnas -->
    <div class="two-column-layout">
        <!-- Actividad Reciente -->
        <div class="section-card">
            <div class="section-header">
                <h2>Actividad Reciente</h2>
                <a href="/users" class="view-all-link">Ver todos los usuarios</a>
            </div>
            <div class="activity-container">
                <?php if (empty($recentEvents)): ?>
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="16"></line>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                        </div>
                        <p>No hay actividad reciente para mostrar</p>
                    </div>
                <?php else: ?>
                    <div class="activity-list">
                        <?php foreach ($recentEvents as $event): ?>
                            <div class="activity-item">
                                <div class="activity-avatar">
                                    <div class="avatar-icon <?= $event['event_type'] ?>">
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
                                </div>
                                <div class="activity-details">
                                    <div class="activity-text">
                                        <strong><?= htmlspecialchars($event['username']) ?></strong>
                                        <?= match ($event['event_type']) {
                                            'login' => 'inició sesión en el sistema',
                                            'register' => 'se registró como nuevo usuario',
                                            'logout' => 'cerró sesión',
                                            default => 'realizó una acción',
                                        } ?>
                                    </div>
                                    <div class="activity-time">
                                        <?= function_exists('timeRelative') ? timeRelative($event['login_time']) : date('d/m/Y H:i', strtotime($event['login_time'])) ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Gráfica de Crecimiento -->
        <div class="section-card">
            <div class="section-header">
                <h2>Crecimiento de Usuarios</h2>
                <div class="chart-controls">
                    <select id="chartPeriod" class="chart-select">
                        <option value="6">Últimos 6 meses</option>
                        <option value="12" selected>Último año</option>
                    </select>
                </div>
            </div>
            <div class="chart-wrapper">
                <canvas id="userGrowthChart"></canvas>
            </div>
            <div class="chart-summary">
                <div class="summary-item">
                    <span class="summary-label">Total registrados:</span>
                    <span class="summary-value"><?= $totalUsers ?? 0 ?></span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Promedio mensual:</span>
                    <span class="summary-value"><?= isset($usersByMonth) ? round(array_sum($usersByMonth) / max(1, count($usersByMonth))) : 0 ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Actualizar hora en tiempo real
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('es-ES', {
            hour: '2-digit',
            minute: '2-digit'
        });
        const timeElement = document.getElementById('current-time');
        if (timeElement) {
            timeElement.textContent = timeString;
        }
    }

    // Actualizar cada minuto
    setInterval(updateTime, 60000);

    // Gráfica de crecimiento de usuarios
    const usersByMonth = <?= json_encode($usersByMonth ?? []) ?>;
    const userLabels = Object.keys(usersByMonth);
    const userCounts = Object.values(usersByMonth);

    const ctx = document.getElementById('userGrowthChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: userLabels.map(month => {
                const [year, monthNum] = month.split('-');
                const date = new Date(year, monthNum - 1);
                return date.toLocaleDateString('es-ES', {
                    month: 'short',
                    year: 'numeric'
                });
            }),
            datasets: [{
                label: 'Usuarios registrados',
                data: userCounts,
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#007bff',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        precision: 0,
                        color: '#6c757d'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#6c757d'
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
</script>