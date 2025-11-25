<!-- BOTÓN HAMBURGUESA -->
<div class="btn-menu" onclick="toggleMenu()">
    <i class="fa-solid fa-bars"></i>
</div>

<!-- MENÚ LATERAL -->
<div class="sidebar" id="sidebar">

    <div class="profile">
        <img src="https://i.pravatar.cc/150?img=47">
        <h3><?php echo htmlspecialchars($nombre); ?></h3>
    </div>
  
    <?php
$inicio_url = "";

switch ($rol) {
    case 'admin':
        $inicio_url = "panel_admin.php";
        break;

    case 'conductores':
        $inicio_url = "panel_conductor.php";
        break;

    case 'pasajeros':
        $inicio_url = "panel_pasajero.php";
        break;
}
?>
<a href="<?php echo $inicio_url; ?>" class="menu-item active">
    <div class="menu-title">
        <i class="fa-solid fa-house menu-icon"></i> Inicio
    </div>
    <i class="fa-solid fa-chevron-right"></i>
</a>
 

    <?php if ($rol == 'admin' || $rol == 'conductores'): ?>
    <a href="reportes.php" class="menu-item">
        <div class="menu-title">
            <i class="fa-solid fa-chart-column menu-icon"></i> Reportes
        </div>
        <i class="fa-solid fa-chevron-right"></i>
    </a>
    <?php endif; ?>

    <a href="rutas.php" class="menu-item">
        <div class="menu-title">
            <i class="fa-solid fa-location-dot menu-icon"></i> Rutas
        </div>
        <i class="fa-solid fa-chevron-right"></i>
    </a>

    <?php if ($rol == 'pasajeros'): ?>
    <a href="billetera.php" class="menu-item">
        <div class="menu-title">
            <i class="fa-solid fa-wallet menu-icon"></i> Billetera
        </div>
        <i class="fa-solid fa-chevron-right"></i>
    </a>
    <?php endif; ?>

    <!-- Cerrar sesión -->
    <a href="lib/cerrar_sesion.php" class="menu-item logout">
        <div class="menu-title">
            <i class="fa-solid fa-right-from-bracket menu-icon"></i> Cerrar sesión
        </div>
    </a>

</div>