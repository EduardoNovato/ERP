<?php

class View
{
    public static function render($view, $params = [])
    {
        $viewPath = dirname(__DIR__, 2) . '/views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            die("Vista no encontrada: $viewPath");
        }

        // Extrae las variables del array $params
        extract($params);

        // Incluye la vista
        require $viewPath;
    }

    public static function renderWithLayout($view, $params = [], $layoutParams = [])
    {
        $viewPath = dirname(__DIR__, 2) . '/views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            die("Vista no encontrada: $viewPath");
        }

        // Extrae las variables del array $params para la vista
        extract($params);

        // Captura el contenido de la vista
        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        // Extrae las variables del layout
        extract($layoutParams);

        // Incluye el layout con el contenido
        require dirname(__DIR__, 2) . '/views/layouts/layout.php';
    }
}
