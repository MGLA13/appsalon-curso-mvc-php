<?php 


use Model\ActiveRecord;

require __DIR__ . '/../vendor/autoload.php';

//Usando la clase Dotenv usando el método estatico createImmutable y pasandole la ruta hasta el archivo actual va a encontar el archivo .env y lo va a registrar
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require 'funciones.php';
require 'database.php';

// Conectarnos a la base de datos
ActiveRecord::setDB($db);