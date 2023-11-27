<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\LoginController;
use Controllers\CitaController;
use Controllers\APIController;
use Controllers\AdminController;
use Controllers\ServicioController;
use MVC\Router;

$router = new Router();

//Iniciar sesión
$router -> get("/",[LoginController::class,"login"]);
$router -> post("/",[LoginController::class,"login"]);
$router -> get("/logout",[LoginController::class,"logout"]);

//Recuperar password
$router -> get("/forgot",[LoginController::class,"forgot"]);
$router -> post("/forgot",[LoginController::class,"forgot"]);
$router -> get("/reset",[LoginController::class,"reset"]);
$router -> post("/reset",[LoginController::class,"reset"]);


//Crear cuenta
$router -> get("/signup",[LoginController::class,"signup"]);
$router -> post("/signup",[LoginController::class,"signup"]);

//Confirmar cuenta
$router -> get("/confirm-account",[LoginController::class,"confirm"]);

//Mensaje para confirmar cuenta
$router -> get("/message",[LoginController::class,"message"]);

//Area privada
$router -> get("/appointments",[CitaController::class,"index"]);

//Area privada admin
$router -> get("/admin",[AdminController::class,"index"]);



//API de citas
$router -> get("/api/services",[APIController::class,"index"]);      //select
$router -> post("/api/appointments",[APIController::class,"save"]);  //insert
$router -> post("/api/delete",[APIController::class,"delete"]);      //delete


//CRUD de servicios
$router->get("/services",[ServicioController::class,"index"]);
$router->get("/services/create",[ServicioController::class,"create"]);
$router->post("/services/create",[ServicioController::class,"create"]);
$router->get("/services/update",[ServicioController::class,"update"]);
$router->post("/services/update",[ServicioController::class,"update"]);
$router->post("/services/delete",[ServicioController::class,"delete"]);



// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();