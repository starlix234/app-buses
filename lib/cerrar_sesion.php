<?php
session_start();

// Elimina todas las variables de sesión
$_SESSION = array();

// Si se usa una cookie de sesión, la destruye también
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destruye la sesión por completo
session_destroy();

// Redirige al login
header("Location:../index.php");
exit();
?>
