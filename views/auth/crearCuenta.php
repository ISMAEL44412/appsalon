<h1> Crear Cuenta</h1>
<?php include_once __DIR__ . "/../templates/alertas.php" ?>
<form class="formulario" action="/crearCuenta" method="post" >
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input 
                type="text" 
                id="nombre" 
                name="nombre" 
                placeholder="Ingresa tu nombre"
                value="<?php echo s($usuario -> nombre); ?>"
            >
        </div>
        <div class="campo">
            <label for="apellido">Apellido</label>
            <input 
                type="text" 
                id="apellido" 
                name="apellido" 
                placeholder="Ingresa tu apellido"
                value="<?php echo s($usuario -> apellido); ?>"
            >
        </div>
        <div class="campo">
            <label for="tel">Telefono</label>
            <input 
                type="text" 
                id="telefono" 
                name="telefono" 
                placeholder="Ingresa tu telefono"
                value="<?php echo s($usuario -> telefono); ?>"
            >
        </div>
        <div class="campo">
            <label for="email">Email</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                placeholder="Ingresa tu email"
                value="<?php echo s($usuario -> email); ?>"
                >
        </div>
        <div class="campo">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña">
        </div>
    </fieldset>
    <input class="submit" type="submit" value="Crear Cuenta">
</form>
<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesion</a>
    <a href="/recuperarCuenta">Reestablecer cuenta</a>
</div>