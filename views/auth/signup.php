
<h1 class="page-name">Crear cuenta</h1>
<p class="page-description">Llena el siguiente formulario para crear una cuenta</p>

<?php 

//incluimos un template
// /.. = salir de la carpeta actual
include_once __DIR__  . "/../templates/alertas.php";

?>


<form action="/signup" class="form" method="POST">

    <div class="input">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" placeholder="Tu nombre" name="nombre" value="<?php echo s($usuario->nombre); ?>">
    </div>

    <div class="input">
        <label for="apellido">Apellido</label>
        <input type="text" id="apellido" placeholder="Tu apellido" name="apellido" value="<?php echo s($usuario->apellido); ?>">
    </div>

    <div class="input">
        <label for="telefono">Teléfono</label>
        <input type="tel" id="telefono" placeholder="Tu teléfono" name="telefono" value="<?php echo s($usuario->telefono); ?>">
    </div>

    <div class="input">
        <label for="email">E-mail</label>
        <input type="email" id="email" placeholder="Tu E-mail" name="email" value="<?php echo s($usuario->email); ?>">
    </div>

    <div class="input">
        <label for="password">Contraseña</label>
        <input type="password" id="password" placeholder="Tu contraseña" name="password">
    </div>

    <div class="button-container">
        <input type="submit" class="button" value="Crear cuenta">
    </div>

</form>

<div class="actions">

    <a href="/">¿Ya tienes una cuenta? Inicia sesión</a>
    <a href="/forgot">Olvidaste tu contraseña</a>

</div>