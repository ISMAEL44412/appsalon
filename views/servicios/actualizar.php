<h1>Actualizar Servicios</h1>
<p class="descripcion-pagina">Modifica el servicio</p>

<?php 
    include_once __DIR__  . "/../templates/barra.php";
    include_once __DIR__ . "/../templates/alertas.php";
?>

<form method="post" class="formulario">

    <?php include_once __DIR__ . "/formulario.php"; ?>
    <input type="submit" class="boton" value="Editar Servicio">
</form>