<?php include_once __DIR__ . "/../templates/bar.php"; ?>

<h1 class="page-name">Crear nueva cita</h1>
<p class="page-description">Elige tus servicios y coloca tus datos</p>


<div id="app">

    <nav class="tabs">

        <button type="button" data-step="1">Servicios</button>
        <button type="button" data-step="2">Información cita</button>
        <button type="button" data-step="3">Resumen</button>

    </nav>

    <div id="step-1" class="section">
        <h2>Servicios</h2>
        <p class="subtitle">Elige tus servicios a continuación</p>
        <div id="services" class="services-list">

        </div>
    </div>

    <div id="step-2" class="section">
        <h2>Tus datos y cita</h2>
        <p class="subtitle">Coloca la fecha de tu cita</p>

        <form class="form">
            <div class="input">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" placeholder="Tu nombre" value="<?php echo $nombre; ?>" disabled> 
            </div>

            <div class="input">
                <label for="fecha">Fecha</label>
                <!--strtotime, convierte una cadena en una fecha-->
                <input type="date" id="fecha" min="<?php echo date('Y-m-d',strtotime('+1 day')); ?>"> 
            </div>

           
            <div class="input">
                <label for="hora">Hora</label>
                <input type="time" id="hora"> 
            </div>

            <input type="hidden" id="id" value="<?php echo $id; ?>"> 

        </form>

    </div>

    <div id="step-3" class="section summary-content">
        <h2>Resumen</h2>
        <p class="subtitle">Verifica que la información sea correcta</p>
    </div>

    <div class="pagination">
        <button class="button" id="previous">&laquo; Anterior</button>
        <button class="button" id="next">Siguiente &raquo;</button>
    </div>

</div>

<?php $script = "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script src='build/js/app.js'></script>
"; ?>