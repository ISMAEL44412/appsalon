<h1>Recuperar Contraseña</h1>
<?php include_once __DIR__ . "/../templates/alertas.php" ?>
<br>
<?php if($error )return; ?>
    <form class="formulario" method="post">
        <div class="campo">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Ingresa tu password">
        </div>
        <input class="submit" type="submit" value="Reestablecer Password">

    </form>
<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesion</a>
    <a href="/crearCuenta">¿Aun no tienes una cuenta?, Crea una aqui!</a>
</div>