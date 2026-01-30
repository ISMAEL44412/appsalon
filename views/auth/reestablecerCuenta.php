<h1>Recuperar Contraseña</h1>
<?php include_once __DIR__ . "/../templates/alertas.php" ?>
<form class="formulario" method="post" action="/recuperarCuenta">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Ingresa tu email">
    </div>
    <input class="submit" type="submit" value="Enviar Instrucciones">

</form>
<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesion</a>
    <a href="/crearCuenta">¿Aun no tienes una cuenta?, Crea una aqui!</a>
</div>