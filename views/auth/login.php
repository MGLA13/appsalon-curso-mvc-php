
<h1 class="page-name">Iniciar sesión</h1>
<p class="page-description">Iniciar sesión con tus datos</p>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<form action="/" class="form" method="POST">

    <div class="input">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Tu email" name="email">
    </div>

    <div class="input">
        <label for="password">Contraseña</label>
        <input type="password" id="password" placeholder="Tu contraseña" name="password">
    </div>

    <div class="button-container">
        <input type="submit" class="button" value="Iniciar sesión">
    </div>
</form>

<div class="actions">

    <a href="/signup">¿Aún no tienes una cuenta? Crear una</a>
    <a href="/forgot">Olvidaste tu contraseña</a>

</div>