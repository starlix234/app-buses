<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/estilos.css">
    <title>Tarjeta</title>
</head>
<body>
<form class="form-tar col-lg-2" action="lib/guardar-tarjeta.php" method="POST">
    
    <input type="hidden" name="id_usuario" value="<?php echo $_SESSION['id_usuario']; ?>">
    <label for="card_number">Número de Tarjeta:</label>
    <input type="text" id="card_number" name="card_number" required>

    <label for="expiry">Fecha de Expiración (MM/AA):</label>
    <input type="text" id="expiry" name="expiry" required>

    <label for="cvv">CVV:</label>
    <input type="text" id="cvv" name="cvv" required>

    <button type="submit">Guardar Tarjeta</button>
</form>




</body>
</html>