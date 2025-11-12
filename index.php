<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login - SmartBus</title>
</head>
<body>
  <h2>Iniciar Sesión</h2>
  <form action="lib/sesion.php" method="POST">
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>
    
    <label>Contraseña:</label><br>
    <input type="password" name="clave" required><br><br>
    
    <button type="submit">Ingresar</button>
  </form>
</body>
</html>
