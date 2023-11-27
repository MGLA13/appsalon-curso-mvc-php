<h1 class="page-name">Reestablecer contraseña</h1>
<p class="page-description">Coloca tu nueva contraseña, a continuación</p>


<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<?php //return en if (opcional a las {}), cuando solo se tiene una acción de condicional (es decir sin un else) ?>
<?php if($error) return; ?>
    <!--Sin atributo action, para evitar que se elimine el token de la url, en caso de que se presenten errores en las validaciones-->
    <form class="form" method="POST">

        <div class="input">
            <label for="password">Contraseña</label>
            <input type="password" id="password" placeholder="Tu contraseña" name="password">
        </div>

        <div class="button-container">
            <input type="submit" class="button" value="Cambiar contraseña">
        </div>

    </form>


    <div class="actions">

        <a href="/">¿Ya tienes una cuenta? Inicia sesión</a>
        <a href="/signup">¿Aún no tienes una cuenta? Crear una</a>

    </div>