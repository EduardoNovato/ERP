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
}
