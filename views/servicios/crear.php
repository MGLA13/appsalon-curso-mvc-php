<h1 class="page-name">Nuevo servicio</h1>
<p class="page-description">Llena todos los campos para crear un nuevo servicio</p>

<?php //include_once __DIR__ . "/../templates/bar.php";  ?>
<?php include_once __DIR__ . "/../templates/alertas.php";  ?>


<form action="/services/create" method="POST" class="form">

    <?php include_once __DIR__ . "/formulario.php"; ?>

    <input type="submit" class="button" value="Guardar servicio">

</form>