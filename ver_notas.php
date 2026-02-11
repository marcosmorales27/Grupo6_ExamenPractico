<?php
include 'db.php';

$alumno_id = $_GET['id'] ?? null;
if (!$alumno_id) header("Location: index.php");

// Obtener datos del alumno
$stmt = $pdo->prepare("SELECT * FROM alumnos WHERE id = ?");
$stmt->execute([$alumno_id]);
$alumno = $stmt->fetch();

// Insertar Nota
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $valor = $_POST['valor'];
    if ($valor >= 0 && $valor <= 10) {
        $stmt = $pdo->prepare("INSERT INTO notas (alumno_id, valor) VALUES (?, ?)");
        $stmt->execute([$alumno_id, $valor]);
    } else {
        $error = "La nota debe estar entre 0 y 10";
    }
}

// Obtener notas
$stmt = $pdo->prepare("SELECT * FROM notas WHERE alumno_id = ?");
$stmt->execute([$alumno_id]);
$notas = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Notas de <?= $alumno['nombre'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
    <h3>Notas de: <?= $alumno['nombre'] . ' ' . $alumno['apellido'] ?></h3>
    <a href="index.php" class="btn btn-outline-secondary mb-3">&larr; volver</a>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5>agregar calificacion</h5>
                    <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label>Valor (0-10)</label>
                            <input type="number" name="valor" step="0.01" min="0" max="10" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">agregar</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <table class="table table-bordered">
                <thead><tr><th>ID Nota</th><th>Valor</th><th>Acción</th></tr></thead>
                <tbody>
                    <?php foreach ($notas as $nota): ?>
                    <tr>
                        <td><?= $nota['id'] ?></td>
                        <td><?= $nota['valor'] ?></td>
                        <td>
                            <a href="eliminar.php?tipo=nota&id=<?= $nota['id'] ?>&alumno_id=<?= $alumno_id ?>" class="btn btn-sm btn-danger">eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>