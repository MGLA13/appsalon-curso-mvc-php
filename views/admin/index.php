<h1 class="page-name">Panel de administración</h1>

<?php include_once __DIR__ . "/../templates/bar.php"; ?>


<h2>Buscar citas</h2>
<div class="search">

    <form class="form">
        <div class="input">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo $fecha; ?>">
        </div>
    </form>

</div>


<?php 
    if(count($citas) === 0){

        echo "<h2>No hay citas para esta fecha</h2>";
    
    } ?>

<?php $idCita = null; ?>

<div id="appointments-admin">

    <ul class="appointments">
        <?php //key hace referencia al indice del objeto que se esta iterando, ya que $citas es un array de objetos ?>
        <?php foreach($citas as $key => $cita): 
            if($idCita !== $cita->id): ?>
                <!--$total, almacenara la suma de los precios de cada servicio correspondiente a una cita-->
                <?php $total = 0; ?>
                <li>
                    <p>ID: <span><?php echo $cita->id; ?></span></p>
                    <p>Hora: <span><?php echo $cita->hora; ?></span></p>
                    <p>Cliente: <span><?php echo $cita->cliente; ?></span></p>
                    <p>E-mail: <span><?php echo $cita->email; ?></span></p>
                    <p>Telefono: <span><?php echo $cita->telefono; ?></span></p>

                    <h3>Servicios</h3>
                <?php $idCita = $cita->id; ?>
            <?php endif; 
            $total += $cita->precio;
            ?>  
                    <p class="service"><?php echo $cita->servicio . " " . $cita->precio; ?></p>
               <!-- </li> Dejamos que HTML cierre el li, para evitar que el segundo parrafo (p) quede fuera del li, esto debido a que 
                    estamos iterando los valores de una variable y puede haber mas de un p de service pero estos ya aparecerian afuera
                    ocasinando que estos no se vean de la manera correcta en la página-->     

            <?php
                //obtenemos el id actual de la cita que se esta iterando y el id de la proxima cita
                $actual = $cita->id;
                $proximo = $citas[$key + 1]->id ?? 0;

                //Cuando los ids no coincidan significa que ya mostramos la información de una cita y se debe pasar a la otra
                //o bien que es la ultima cita a mostrar
                if(isLast($actual,$proximo)): ?>
                    <p class="total">Total <span>$ <?php echo $total; ?></span></p>    
                    
                    <form action="/api/delete" method="POST">
                        <input type="hidden" name="id" value="<?php echo $cita->id; ?>">
                        <input type="submit" class="delete-button" value="Eliminar cita">
                    </form>
                
                <?php endif; ?>        
        <?php endforeach; ?>    
    </ul>


</div>


<?php $script = "<script src='build/js/search.js'></script>"; ?>