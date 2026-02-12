<?php
// agregamos la conexion a la base de datos
include 'db.php';
//variables para editar o registrar alumno
$id = $_GET['id'] ?? null;
$alumno = ['nombre' => '', 'apellido' => '', 'correo' => ''];
//bloque if para obtener datos del alumno
if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM alumnos WHERE id = ?");
    $stmt->execute([$id]);
    $alumno = $stmt->fetch(PDO::FETCH_ASSOC);
}

// bloque if para registrar o editar alumno
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    
    if ($id) {
        $stmt = $pdo->prepare("UPDATE alumnos SET nombre=?, apellido=?, correo=? WHERE id=?");
        $stmt->execute([$nombre, $apellido, $correo, $id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO alumnos (nombre, apellido, correo) VALUES (?, ?, ?)");
        $stmt->execute([$nombre, $apellido, $correo]);
    }
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Guardar alumno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
    <div class="card col-md-6 mx-auto">
        <div class="card-header"><?= $id ? 'Editar' : 'Registrar' ?> Alumno</div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="<?= $alumno['nombre'] ?>" required>
                </div>
                <div class="mb-3">
                    <label>Apellido</label>
                    <input type="text" name="apellido" class="form-control" value="<?= $alumno['apellido'] ?>" required>
                </div>
                <div class="mb-3">
                    <label>Correo</label>
                    <input type="email" name="correo" class="form-control" value="<?= $alumno['correo'] ?>" required>
                </div>
                <button type="submit" class="btn btn-success">Guardar</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</body>
</html>