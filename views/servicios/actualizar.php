<h1 class="page-name">Actualizar servicio</h1>
<p class="page-description">Modifica los valores del formulario</p>


<?php //include_once __DIR__ . "/../templates/bar.php";  ?>
<?php include_once __DIR__ . "/../templates/alertas.php";  ?>


<?php //Eliminamos el action del form para que no se pierda el id (que viene del query string) al momento de enviarse la petición y se pueda procesar (el id) en el controller
      //Un form sin action lo envia a la ruta por defecto con la se cargo?>
<form method="POST" class="form">

    <?php include_once __DIR__ . "/formulario.php"; ?>

    <input type="submit" class="button" value="Actualizar servicio">

</form>