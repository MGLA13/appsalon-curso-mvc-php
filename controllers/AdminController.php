<?php


namespace Controllers;

use MVC\Router;
use Model\AdminCita;

class AdminController{


    public static function index(Router $router){

        session_start();

        //Comprobamos autenticación del usuario como administrador antes de mostrar la página
        isAdmin();
        
        //Asignamos la fecha actual en caso de que no se haya mandando una fecha en la petición a traves de GET  
        $date = $_GET["date"] ?? date("Y-m-d");

        //Dividimos la fecha (mes,dia,año) para poder validarla
        $dateParts = explode("-",$date);

        //Validamos la fecha que sea correcta usando la función checkdate, nos retorna false si la fecha es incorrecta
        if(!checkdate($dateParts[1],$dateParts[2],$dateParts[0])){
            //404, como tal no existe en el routing, por lo que se mostraria el msj de pagina no encontrada
            header("Location: /404");
        }


        //Consultar la base de datos
        //Crear la consulta
        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuarioId=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citasServicios ";
        $consulta .= " ON citasServicios.citaId=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citasServicios.servicioId ";
        $consulta .= " WHERE fecha = '$date'";

        //Consultar la BD con el método indicado del modelo
        $citas = AdminCita::SQL($consulta);

        
        $router->render("admin/index",[
            "nombre" => $_SESSION["nombre"],
            "citas" => $citas,
            "fecha" => $date
        ]);

    }

}