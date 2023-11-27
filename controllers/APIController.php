<?php 

namespace Controllers;

use MVC\Router;
use Model\Servicio;
use Model\Cita;
use Model\CitaServicio;

class APIController{


    public static function index(){

        $servicios = Servicio::all();
        
        echo json_encode($servicios);

    }


    public static function save(){

        //Almacena la cita y devuelve el ID referente a la cita;
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();

        //Guardamos el id resultante de la cita recien creada 
        $id = $resultado["id"];

        //Almacena los servicio(s) de la anterior cita
        //Al estar como string los ids de los servicios "1,2,3" se convierten a un array [1,2,3]
        $idServicios = explode(",",$_POST["servicios"]);

        //Recorremos el array para ir almacenado cada servicio referente a la cita con $id
        foreach($idServicios as $idServicio){

            //Array asociativo que nos servira para instanciar la clase de CitaServicio
            $args = [
                "citaId" => $id,
                "servicioId" => $idServicio
            ];

            //Instancia de la clase
            $citaServicio = new CitaServicio($args);
            //Almacenamos el servicio de la cita
            $citaServicio->guardar();
            
        }

        //Devolvemos una respuesta a la petición 
        echo json_encode(["resultado" => $resultado]);

    }


    public static function delete(){
       
        if($_SERVER["REQUEST_METHOD"] === "POST"){

            //Obtenemos el id de la cita a eliminar
            $id = $_POST["id"];

            //Comprobamos que dicha cita exista, en caso de que existase nos retorna un objeto correspondiente a la cita
            $cita = Cita::find($id);

            //Si la cita es correcta, la eliminamos, sino se podria redirigir al usuario a alguna página con una alerta de error indicando el fallo           
            if($cita->eliminar()){
                //Si la cita fue eliminada correctamente rederigimos a la página de la cual el usuario envio la petición
                header("Location:" . $_SERVER["HTTP_REFERER"]);
            }else{
                //En caso de que la cita no haya sido eliminada, rederigimos a la página de la cual el usuario envio la petición pero con un msj de error
            }

            
        }

    }


}