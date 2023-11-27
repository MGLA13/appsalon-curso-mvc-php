<?php

namespace Controllers;


use MVC\Router;
use Model\Servicio;


class ServicioController{

    public static function index(Router $router){

        //session_start(); Es ingorado ya que al momento de la autenticación del usuario, se hizo uso del mismo, quedando activo para ser usado en otras clases como esta
        
        isAdmin();
        
        $servicios = Servicio::all();


        $router->render("servicios/index",[
            "nombre" => $_SESSION["nombre"],
            "servicios" => $servicios
        ]);
    }

    public static function create(Router $router){

        isAdmin();

        $servicio = new Servicio;
        $alertas = [];


        if($_SERVER["REQUEST_METHOD"] === "POST"){

            $servicio->sincronizar($_POST);

            $servicio->validar();

            $alertas = $servicio::getAlertas();

            if(empty($alertas)){
                $servicio->guardar();
                header("Location: /services");
            }

        }


        $router->render("servicios/crear",[
            "nombre" => $_SESSION["nombre"],
            "servicio" => $servicio,
            "alertas" => $alertas
        ]);
    }

     public static function update(Router $router){

        isAdmin();

        //Validamos el id recibido en GET
        //En caso de no ser un id valido redireccionamos
        if(!is_numeric($_GET["id"])) header("Location: /services");

        //Encontramos el servicio con el id
        $servicio = Servicio::find($_GET["id"]);
        $alertas = [];

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            
            //Sincronizamos la nueva información recibida al objeto creado anteriormente
            $servicio->sincronizar($_POST);

            $servicio->validar();

            $alertas = $servicio::getAlertas();

            if(empty($alertas)){
                $servicio->guardar();
                header("Location: /services");
            }

        }

        $router->render("servicios/actualizar",[
            "nombre" => $_SESSION["nombre"],
            "servicio" => $servicio,
            "alertas" => $alertas,
        ]);
    }

    public static function delete(){

        isAdmin();

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            
            $id = $_POST["id"];

            $servicio = Servicio::find($id);

            $servicio->eliminar();
            header("Location: /services");

        }
    }
}