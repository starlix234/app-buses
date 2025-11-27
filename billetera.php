<?php
session_start();
require_once __DIR__ . '/lib/conexion.php';

// Si no hay usuario logueado → impedir acceso
if (!isset($_SESSION['id_usuario'])) {
    die("No tienes permiso para acceder aquí.");
}

$id_usuario = $_SESSION['id_usuario'];
$nombre = $_SESSION['nombre'];
$rol = $_SESSION['rol'];
// Consultar tarjetas del usuario
$sql = "SELECT id, token_tarjeta, ultimos_4, tipo_tarjeta, marca, creada_en 
        FROM tarjetas_tokenizadas
        WHERE id_usuario = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Billetera</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="assets/js/menu.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="assets/js/js-efectos.js"></script>






</script>
</head>
<body class="bg-cuerpo">
    <?php include("menu.php")?>
      
    <div class="container mt-4">
        <h2 class="mb-4">Billetera</h2>
         <h2 id="sal">💳 Saldo</h2>
         <div id="saldo">
          <?php include("saldo.php")?>

         </div>

        <h2 class="mb-4" id="tarjeta">💳 Agregar Tarjeta</h2>
        <div id="tarjeta-cont" class>
          <?php include("agregar-tarjeta.php")?>
         </div>            
          <h2 class="mb-4" id="tar">💳 Mis Tarjetas Guardadas</h2>
        <div id="lista-tarjeta">

        <?php if ($result->num_rows === 0): ?>
    <div class="alert alert-info">
        No tienes tarjetas guardadas aún.
    </div>

<?php else: ?>

    <div class="row row-cols-1 row-cols-md-3 g-4">

        <?php while ($row = $result->fetch_assoc()): ?>

            <div class="col">
                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        <h5 class="card-title">
                            <?= strtoupper($row['marca']) ?> •••• <?= $row['ultimos_4'] ?>
                        </h5>

                        <p class="card-text">
                            <strong>Tipo:</strong> <?= ucfirst($row['tipo_tarjeta']) ?><br>
                            <strong>Token:</strong> <?= $row['token_tarjeta'] ?><br>
                            <strong>Guardada el:</strong> <?= $row['creada_en'] ?>
                        </p>

                        <!-- Botón recargar -->
                        <a class="boton" href="recargar.php?tarjeta=<?= $row['id'] ?>">
                            Recargar con esta tarjeta
                        </a>

                        <br><br>

                        <!-- Botón eliminar -->
                        <a href="lib/eliminar-tarjeta.php?id=<?= $row['id'] ?>"
                           class="boton"
                           style="background:#e40303;"
                           onclick="return confirm('¿Seguro que deseas eliminar esta tarjeta? Se borrarán todas sus recargas asociadas.')">
                           Eliminar tarjeta
                        </a>

                    </div>
                </div>
            </div>

        <?php endwhile; ?>

    </div>

<?php endif; ?>


        </div>
         
        <h2 class="mb-4" id="tran">💳 Historial de Gastos</h2>
        <div id="trans">
        <?php include("historial-transacciones.php")?>


        </div>
    </div>

  
</body>
</html>
