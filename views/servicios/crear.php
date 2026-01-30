<h1>Crear Servicio</h1>
<p class="descripcion-pagina">Llenar datos para crear servicio</p>

<?php 
    include_once __DIR__  . "/../templates/barra.php";
    include_once __DIR__ . "/../templates/alertas.php";
?>

<form action="/servicios/crear" method="post" class="formulario">

    <?php include_once __DIR__ . "/formulario.php"; ?>
    <input type="submit" class="boton" value="Crear Servicio">
</form>