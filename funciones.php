<?php
//  funcion para tener el resultado en base al promedio
function obtenerResultado($promedio) {
    if ($promedio === null) return "Sin notas";

    $p = floatval($promedio);

    if ($p < 5) return '<span class="badge bg-danger">Suspenso</span>';
    if ($p < 7) return '<span class="badge bg-warning text-dark">Bien</span>';
    if ($p < 9) return '<span class="badge bg-info text-dark">Notable</span>';
    return '<span class="badge bg-success">Sobresaliente</span>';
}
?>