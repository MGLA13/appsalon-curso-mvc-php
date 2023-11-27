<div class="bar">
    <p>Hola: <?php echo $nombre ?? null; ?></p>
    <a class="button" href="/logout">Cerrar sesión</a>
</div>


<?php if(isset($_SESSION["admin"])){ ?>

    <div class="services-bar">
        <a class="button" href="/admin">Ver citas</a>
        <a class="button" href="/services">Ver servicios</a>
        <a class="button" href="/services/create">Crear servicios</a>   
    </div>
    
<?php } ?>