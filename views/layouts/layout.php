<?php
// Verificar autenticación
if (!isset($_SESSION['user_id'])) {
    header('Location: /');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?= $pageTitle ?? 'Dashboard' ?> - ERP Lite</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <?php if (isset($additionalCSS)): ?>
        <?php foreach ($additionalCSS as $css): ?>
            <link rel="stylesheet" href="<?= $css ?>">
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Scripts comunes -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php if (isset($includeChartJS) && $includeChartJS): ?>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php endif; ?>
</head>

<body>
    <?php
    // Incluir sidebar
    include __DIR__ . '/sidebar.php';
    ?>

    <div class="content">
        <?php
        // Contenido específico de cada página
        echo $content;
        ?>
    </div>

    <!-- Scripts comunes -->
    <script src="/assets/js/sidebar.js"></script>

    <?php if (isset($additionalJS)): ?>
        <?php foreach ($additionalJS as $js): ?>
            <script src="<?= $js ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>

</html>