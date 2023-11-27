
<?php

//templates, plantilllas que se pueden utilizar en varios archivos (vistas, layouts, etc)

//$alertas es un array asociativo enviado desde el controlador, contiene las alertas (errores y correctas), que corresponden a las keys
//$mensajes es un array, corresponde a cada uno de los mensajes, dicho array es el valor de las keys mencionadas 
foreach($alertas as $key => $mensajes):

    //recorremos los mensajes que tenga $mensajes (value) en turno
    foreach($mensajes as $mensaje):
?>
        <div class="alert <?php echo $key; ?>">
            <?php echo $mensaje; ?>
        </div>

<?php    
    endforeach;
endforeach;