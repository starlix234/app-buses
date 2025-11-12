<?php include("conexion.php")?>
<?php
session_start();
include("conexion.php");

$email = $_POST['email'];
$clave = $_POST['clave'];

$sql = "SELECT u.id_usuario, u.nombre, u.clave, r.roles 
        FROM usuarios u 
        INNER JOIN roles r ON u.id_rol = r.id_rol 
        WHERE u.email = '$email'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();

    if ($clave === $usuario['clave']) { // login simple (sin hash aún)
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['rol'] = $usuario['roles'];

        // Redirección según el rol
        switch ($usuario['roles']) {
            case 'admin':
                header("Location:../panel_admin.php");
                break;
            case 'conductores':
                header("Location:../panel_conductor.php");
                break;
            case 'pasajeros':
                header("Location:../panel_pasajero.php");
                break;
            default:
                echo "Rol no reconocido.";
                break;
        }
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "Usuario no encontrado.";
}

$conn->close();
?>







?>