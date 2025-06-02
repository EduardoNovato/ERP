<div class="users-container">
    <!-- Floating Add User Button -->
    <button class="floating-action-button" id="add-user-btn" title="Añadir nuevo usuario">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 5v14M5 12h14"/>
        </svg>
    </button>

    <!-- Header with KPIs -->
    <div class="users-header">
        <div class="header-title">
            <h1>Gestión de Usuarios</h1>
            <p class="subtitle">Administra los usuarios del sistema</p>
        </div>
        <div class="kpi-cards">
            <div class="kpi-card">
                <div class="kpi-icon total">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <div class="kpi-content">
                    <span class="kpi-label">Total Usuarios</span>
                    <span class="kpi-value"><?= $stats['total'] ?></span>
                </div>
            </div>
            <div class="kpi-card">
                <div class="kpi-icon active">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
                <div class="kpi-content">
                    <span class="kpi-label">Usuarios Activos</span>
                    <span class="kpi-value"><?= $stats['active'] ?></span>
                    <span class="kpi-subtitle">Últimos 30 días</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="filters-section">
        <form method="GET" class="filters-form">
            <div class="search-field">
                <input type="text" name="search" placeholder="Buscar usuarios..." 
                       value="<?= htmlspecialchars($search ?? '') ?>" class="search-input">
            </div>
            <div class="filter-field">
                <select name="status" class="filter-select">
                    <option value="">Estado</option>
                    <option value="active" <?= ($status ?? '') === 'active' ? 'selected' : '' ?>>Activos</option>
                    <option value="inactive" <?= ($status ?? '') === 'inactive' ? 'selected' : '' ?>>Inactivos</option>
                </select>
            </div>
            <div class="filter-field">
                <select name="date_range" class="filter-select">
                    <option value="">Fecha de registro</option>
                    <option value="week" <?= ($dateRange ?? '') === 'week' ? 'selected' : '' ?>>Última semana</option>
                    <option value="month" <?= ($dateRange ?? '') === 'month' ? 'selected' : '' ?>>Último mes</option>
                    <option value="year" <?= ($dateRange ?? '') === 'year' ? 'selected' : '' ?>>Último año</option>
                </select>
            </div>
            <button type="submit" class="filter-button">Aplicar filtros</button>
            <?php if (!empty($search) || !empty($status) || !empty($dateRange)): ?>
                <a href="/users" class="clear-filters">Limpiar filtros</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Users Table -->
    <div class="users-table-container">
        <?php if (empty($users)): ?>
            <div class="empty-state">
                <div class="empty-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="16"/>
                        <line x1="8" y1="12" x2="16" y2="12"/>
                    </svg>
                </div>
                <p>No se encontraron usuarios</p>
                <button class="btn-primary" id="add-first-user">Añadir primer usuario</button>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Información</th>
                            <th>Actividad</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td>
                                    <div class="user-info">
                                        <div class="user-avatar">
                                            <?= strtoupper(substr($user['username'], 0, 2)) ?>
                                        </div>
                                        <div class="user-details">
                                            <span class="username"><?= htmlspecialchars($user['username']) ?></span>
                                            <span class="user-email"><?= htmlspecialchars($user['email']) ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="info-group">
                                        <span class="info-label">Registro:</span>
                                        <span class="info-value"><?= date('d/m/Y', strtotime($user['created_at'])) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="activity-info">
                                        <div class="info-group">
                                            <span class="info-label">Último acceso:</span>
                                            <span class="info-value">
                                                <?php if ($user['last_login']): ?>
                                                    <?= date('d/m/Y H:i', strtotime($user['last_login'])) ?>
                                                <?php else: ?>
                                                    <span class="text-muted">Nunca</span>
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                        <div class="login-badge">
                                            <?= $user['login_count'] ?> sesiones
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge <?= $user['is_active'] ? 'active' : 'inactive' ?>">
                                        <?= $user['is_active'] ? 'Activo' : 'Inactivo' ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-icon edit" onclick="editUser(<?= $user['id'] ?>)" 
                                                title="Editar usuario">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" 
                                                 stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                            </svg>
                                        </button>
                                        <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                            <button class="btn-icon delete" 
                                                    onclick="deleteUser(<?= $user['id'] ?>, '<?= htmlspecialchars($user['username']) ?>')"
                                                    title="Eliminar usuario">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" 
                                                     stroke="currentColor" stroke-width="2">
                                                    <path d="M3 6h18"/>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                                </svg>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page - 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?><?= $status ? '&status=' . urlencode($status) : '' ?><?= $dateRange ? '&date_range=' . urlencode($dateRange) : '' ?>" 
                           class="pagination-btn">Anterior</a>
                    <?php endif; ?>

                    <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                        <a href="?page=<?= $i ?><?= $search ? '&search=' . urlencode($search) : '' ?><?= $status ? '&status=' . urlencode($status) : '' ?><?= $dateRange ? '&date_range=' . urlencode($dateRange) : '' ?>" 
                           class="pagination-btn <?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                        <a href="?page=<?= $page + 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?><?= $status ? '&status=' . urlencode($status) : '' ?><?= $dateRange ? '&date_range=' . urlencode($dateRange) : '' ?>" 
                           class="pagination-btn">Siguiente</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>