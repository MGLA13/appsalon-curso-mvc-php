<?php

//new mysqli y mysqli_connect ambos retornan un objeto
//$_ENV,el que se ha registrado en app.php, para variables de entorno local  
$db = mysqli_connect($_ENV["DB_HOST"],$_ENV["DB_USER"],$_ENV["DB_PASS"],$_ENV["DB_NAME"]);


$db->set_charset("utf8");


if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}
