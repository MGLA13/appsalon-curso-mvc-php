<?php 

namespace Controllers;

use MVC\Router;
use Model\Usuario;
use Classes\Email;

class LoginController{

    public static function login(Router $router){

        $alertas = [];

        if($_SERVER["REQUEST_METHOD"] === "POST"){

            $auth = new Usuario($_POST);

            $alertas = $auth->validarLogin();

            if(empty($alertas)){
                //Comprobar que exista el usuario
                $usuario = Usuario::where("email",$auth->email);
                
                if($usuario){
                    //Verificar password
                    if($usuario->comprobarPasswordAndVerificado($auth->password)){
                      //Autenticar al usuario
                      session_start();

                      $_SESSION["id"] = $usuario->id;
                      $_SESSION["nombre"] = $usuario->nombre . " " . $usuario->apellido;
                      $_SESSION["email"] = $usuario->email;
                      $_SESSION["login"] = true;


                      //Redireccionamiento
                      if($usuario->admin === "1"){
                        //Usuario admin
                        $_SESSION["admin"] = $usuario->admin ?? null;
                        header("Location: /admin");
                      }else{
                        //Usuario cliente
                        header("Location: /appointments");
                      }

                    }

                }else{
                    Usuario::setAlerta("error","Usuario no encontrado");
                }

            }

        }

        $alertas = Usuario::getAlertas();

        $router -> render ("auth/login",[
            "alertas" => $alertas
        ]);
        
    }


    public static function logout(){
       
        session_start();

        $_SESSION = [];

        header("Location: /");

    }


    public static function forgot(Router $router){

        $alertas = [];

        if($_SERVER["REQUEST_METHOD"] === "POST"){

            $auth = new Usuario($_POST);

            $alertas = $auth->validarEmail();

            if(empty($alertas)){

                $usuario = Usuario::where("email",$auth->email);

                if($usuario and $usuario->confirmado === "1"){
                    
                    //Generar un token
                    $usuario->crearToken();

                    //Actualizar la información del usuario, con nuevo token
                    $resultado = $usuario->guardar();

                    if($resultado){ //La consulta SQL se llevo acabo
                        
                        //Enviar el email
                        $email = new Email($usuario->email,$usuario->nombre,$usuario->token);
                        $email->enviarInstrucciones();
                        
                        //Alerta de exito
                        Usuario::setAlerta("success","Revisa tu e-mail");
                    
                    }
            
                }else{
                    Usuario::setAlerta("error","Usuario no existe o no esta confirmado");
                }
            }

        }

        $alertas = Usuario::getAlertas();

        $router->render("auth/forgot",[
            "alertas" => $alertas    
        ],
        
    );

    }

    public static function reset(Router $router){

        $alertas = [];
        $error = false;

        $token = s($_GET["token"]);

        //Buscar usuario por su token
        $usuario = Usuario::where("token",$token);
        
        if(empty($usuario)){
            //Mostrar mensaje de error
            Usuario::setAlerta("error","Token no válido");
            $error = true;
        }

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            //Leer nuevo password y actualizar en la BD

            //Creamos un objeto en base al password proporcionado, esto para despues verificar dicho password 
            //con el correspondiente método de validación que tiene dicho modelo
            $password = new Usuario($_POST);

            $alertas = $password->validarPassword();

            if(empty($alertas)){

                //Se cambia el valor de passwor del objeto creado anteriormente
                $usuario->password = null;

                //Se añade el nuevo valor de password a objeto
                $usuario->password = $password->password;

                //Hasheamos el nuevo valor de password
                $usuario->hashPassword();

                //Cambiamos el valor del token
                $usuario->token = null;

                //Actualizamos en la BD
                $resultado = $usuario->guardar();

                if($resultado){
                    header("Location: /");
                }

            }

        }

        $alertas = Usuario::getAlertas();

        $router->render("auth/reset",[
            "alertas"=>$alertas,
            "error"=>$error
        ]);

    }

    public static function signup(Router $router){

        $usuario = new Usuario;

        //alertas vacias
        $alertas = [];

        if($_SERVER["REQUEST_METHOD"] === "POST"){
           
            $usuario->sincronizar($_POST);

            $alertas = $usuario->validarNuevaCuenta();

            //Revisar que alertas este vacía para registrar nuevo usuario
            if(empty($alertas)){
                
                //verificar (email) que el usuario no este registrado
                $resultado = $usuario->existeUsuario();
                
                if($resultado->num_rows){ //Nuevamente aqui verificamos, si tiene el valor de 1, significa que el correo 
                                          //ya esta registrado
                    
                    //Al tener un usuario registrado obtenemos las alertas, previamente llenada en el modelo (clase)                      
                    $alertas = Usuario::getAlertas();

                }else{  //No esta registrado el usuario
                    
                    //Hashear el password
                    $usuario->hashPassword();

                    //Generar un token único que servira para confirmar la nueva cuenta del usuario
                    $usuario->crearToken();

                    //Enviar email
                    $email = new Email($usuario->email,$usuario->nombre,$usuario->token);

                    $email->enviarConfirmacion();

                    //Crear el usuario
                    $resultado = $usuario->guardar();

                    if($resultado){
                        header("Location: /message");    
                    }

                }

            }


        }
        
        $router->render("auth/signup",[
            "usuario" => $usuario,
            "alertas" => $alertas
        ]);

    }

    public static function message(Router $router){

        $router->render("auth/message");

    }


    public static function confirm(Router $router){

        $alertas = [];

        //Sanitizar lo que se este obteniedo de la ruta 
        $token = s($_GET["token"]);

        $usuario = Usuario::where("token",$token);

        if(empty($usuario)){
            //Mostrar mensaje de error
            Usuario::setAlerta("error","Token no válido");

        }else{
            //Modificar a usuario confirmado
            $usuario->confirmado = 1;
            $usuario->token = null;
            $usuario->guardar();

            Usuario::setAlerta("success","Cuenta confirmada correctamente");
        }

        $alertas = Usuario::getAlertas();

        $router->render("auth/confirm",[
            "alertas" => $alertas
        ]);

    }

}