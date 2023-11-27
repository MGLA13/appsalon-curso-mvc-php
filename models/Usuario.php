<?php

namespace Model;

class Usuario extends ActiveRecord{

    //bade de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id','nombre','apellido','email','telefono',
    'admin','confirmado','token','password'];
    
    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;
    public $password;


    public function __construct($args = []){

        $this->id = $args["id"] ?? null;
        $this->nombre = $args["nombre"] ?? null;
        $this->apellido= $args["apellido"] ?? null;
        $this->email = $args["email"] ?? null;
        $this->telefono = $args["telefono"] ?? null;
        $this->admin = $args["admin"] ?? 0;
        $this->confirmado = $args["confirmado"] ?? 0;
        $this->token = $args["token"] ?? "";
        $this->password = $args["password"] ?? null;

    }

    //Métodos de la clase (modelo)
    //Mensajes de validación para la creación de una cuenta
    public function validarNuevaCuenta(){

        if(!$this->nombre){
            self::$alertas["error"][] = "El nombre es obligatorio";
        }

        if(!$this->apellido){
            self::$alertas["error"][] = "El apellido es obligatorio";
        }

        if(strlen($this->telefono) < 10){
            self::$alertas["error"][] = "El teléfono debe contener 10 dígitos";
        }

        if(!$this->email){
            self::$alertas["error"][] = "El E-mail es obligatorio";
        }

        if(!$this->password){
            self::$alertas["error"][] = "La contraseña es obligatoria";
        }else if(strlen($this->password) < 6){
            self::$alertas["error"][] = "La contraseña debe contener al menos 6 caracteres";
        }

        return self::$alertas;

    }


    public function validarLogin(){

        if(!$this->email){
            self::$alertas["error"][] = "El E-mail es obligatorio";
        }

        if(!$this->password){
            self::$alertas["error"][] = "La contraseña es obligatoria";
        }

        return self::$alertas;
    }

    public function validarEmail(){

        if(!$this->email){
            self::$alertas["error"][] = "El E-mail es obligatorio";
        }

        return self::$alertas;
    }
    
    public function validarPassword(){

        if(!$this->password){
            self::$alertas["error"][] = "La contraseña es obligatoria";
        }else if(strlen($this->password) < 6){
            self::$alertas["error"][] = "La contraseña debe contener al menos 6 caracteres";
        }

        return self::$alertas;
    }


    //Revisa si el usuario ya existe
    public function existeUsuario(){

        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        //Nos retorna un objeto de tipo mysqli_result
        $resultado = self::$db->query($query);

        //Accedemos al atributo num_rows
        if($resultado->num_rows){ //Si tiene el valor de 1, significa que el correo ya esta registrado
            self::$alertas["error"][] = "El usuario ya esta registrado";
        }

        //Retornamos el resultado obtenido, las $alertas las podemos obtener desde el controlador usando algun metodo de la clase
        return $resultado;
    }


    public function hashPassword(){

        $this->password = password_hash($this->password, PASSWORD_BCRYPT); 

    }


    public function crearToken(){

        //uniqid, genera una cadena de 13 caracteres, correcto para ser usado como token 
        $this->token = uniqid();

    }

    public function comprobarPasswordAndVerificado($password){

        $resultado = password_verify($password,$this->password);

        if(!$resultado || !$this->confirmado){
            self::$alertas["error"][] = "Password incorrecto o tu cuenta no ha sido confirmada";
        }else{
            return true;
        }
    
    }


}