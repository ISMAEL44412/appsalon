<h1> Iniciar Sesion</h1>
<?php include_once __DIR__ . "/../templates/alertas.php" ?>
<form class="formulario" method="post" action="/login">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Ingresa tu email">
    </div>

    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña">
    </div>

    <input class="submit" type="submit" value="Iniciar sesion">

</form>
<div class="acciones">
    <a href="/crearCuenta">¿Aun no tienes una cuenta?, Crea una aqui!</a>
    <a href="/recuperarCuenta">Reestablecer Password</a>
</div>