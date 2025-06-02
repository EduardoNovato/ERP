<?php
function timeRelative($datetime)
{
    $timestamp = strtotime($datetime);
    $diferencia = time() - $timestamp;

    if ($diferencia < 60)
        return 'Hace unos segundos';
    if ($diferencia < 3600)
        return 'Hace ' . floor($diferencia / 60) . ' minutos';
    if ($diferencia < 86400)
        return 'Hace ' . floor($diferencia / 3600) . ' horas';
    return 'Hace ' . floor($diferencia / 86400) . ' días';
}
?>