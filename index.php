<?php
include 'db.php';
include 'funciones.php';

// consulta sql para alumnos y calcular su promedio 
$sql = "SELECT a.id, a.nombre, a.apellido, a.correo, AVG(n.valor) as promedio 
        FROM alumnos a 
        LEFT JOIN notas n ON a.id = n.alumno_id 
        GROUP BY a.id";
$stmt = $pdo->query($sql);
$alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css" rel="stylesheet">
</head>
<body class="container py-5">
    
    <h1 class="mb-4 text-center">Gestión academica</h1>

    <div class="mb-3">
        <a href="guardar_alumno.php" class="btn btn-primary">
            <i class="bi bi-person-plus"></i> Nuevo estudiante
        </a>
    </div>

    <table id="tablaAlumnos" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Promedio</th>
                <th>Resultado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alumnos as $alumno): ?>
                <?php $promedio = $alumno['promedio'] ? number_format($alumno['promedio'], 2) : null; ?>
                <tr>
                    <td><?= $alumno['id'] ?></td>
                    <td><?= htmlspecialchars($alumno['nombre']) ?></td>
                    <td><?= htmlspecialchars($alumno['apellido']) ?></td>
                    <td><?= htmlspecialchars($alumno['correo']) ?></td>
                    <td><?= $promedio ?? 'N/A' ?></td>
                    <td><?= obtenerResultado($promedio) ?></td>
                    <td>
                        <a href="ver_notas.php?id=<?= $alumno['id'] ?>" class="btn btn-sm btn-info text-white">Notas</a>
                        <a href="guardar_alumno.php?id=<?= $alumno['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                        <a href="eliminar.php?tipo=alumno&id=<?= $alumno['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Borrar alumno y sus notas?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tablaAlumnos').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel', 'pdf'
                ],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                }
            });
        });
    </script>
</body>
</html>