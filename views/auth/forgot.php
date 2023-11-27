
<h1 class="page-name">Olvide contraseña</h1>
<p class="page-description">Reestablce tu contraseña, escribiendo tu e-mail a continuación</p>


<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<form action="/forgot" class="form" method="POST">

    <div class="input">
        <label for="email">E-mail</label>
        <input type="email" id="email" placeholder="Tu E-mail" name="email">
    </div>

    <div class="button-container">
        <input type="submit" class="button" value="Enviar instrucciones">
    </div>

</form>


<div class="actions">

    <a href="/">¿Ya tienes una cuenta? Inicia sesión</a>
    <a href="/signup">¿Aún no tienes una cuenta? Crear una</a>

</div>