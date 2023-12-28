<?php

namespace Model;

class Usuario extends ActiveRecord {
    //Base de Datos

    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 
    'telefono', 'admin', 'confirmado','activo', 'token', 'password'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;
    public $password;
    public $activo;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->activo = $args['activo'] ?? '1';
        $this->token = $args['token'] ?? '';
        $this->password = $args['password'] ?? '';
    }

    //Mensaje de validacion para la creacion de una cuenta
    public function validarNuevaCuenta(){
        if(!$this->nombre){
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }
        if(!$this->apellido){
            self::$alertas['error'][] = 'El Apellido es Obligatorio';
        }
        if(!$this->telefono){
            self::$alertas['error'][] = 'El Teléfono es Obligatorio';
        }
        if(!$this->email){
            self::$alertas['error'][] = 'El E-mail es Obligatorio';
        }
        if(!$this->password){
            self::$alertas['error'][] = 'El Password es Obligatorio';
        }
        if(strlen($this->password) < 6){
            self::$alertas['error'][] = 'El Password debe contener al menos 6 carácteres';
        }
        return self::$alertas;
    }
    //Mensaje de validacion para el inicio de sesion
    public function validarLogin(){
        if(!$this->email) {
            self::$alertas['error'][] = 'El E-mail es Obligatorio';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'El Password es Obligatorio';
        }
        return self::$alertas;
    }

    public function validarEmail(){

        if(!$this->email) {
            self::$alertas['error'][] = 'El E-mail es Obligatorio';
        }
        return self::$alertas;
    }

    public function validarPassword(){
        if(!$this->password) {
            self::$alertas['error'][] = 'El Password es Obligatorio';
        }
        if(strlen($this->password) < 6){
            self::$alertas['error'][] = 'El Password debe contener al menos 6 carácteres';
        }
        return self::$alertas;
    }

    //Revisa si el Usuario ya existe
    public function existeUsuario(){
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
       
        $resultado = self::$db->query($query);
    
        if ($resultado) {
            // Verifica si hay al menos una fila en el resultado
            if ($resultado->num_rows > 0) {
                self::$alertas['error'][] = 'El Usuario ya está Registrado';
            }
        } else {
            // Maneja el error de la consulta
            self::$alertas['error'][] = 'Error en la consulta: ' . self::$db->error;
        }
    
        return $resultado;
    }

    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }


    public function crearToken(){
        $this->token = uniqid();
    }

    public function comprobarPasswordVerificacion($password) {
        $resultado = password_verify($password, $this->password);
        // debuguear($resultado);
    
        if (!$resultado) {
            self::$alertas['error'][] = 'La contraseña proporcionada no coincide';
        }
    
        if (!$this->confirmado) {
            self::$alertas['error'][] = 'El usuario no está confirmado';
        }
    
        return $resultado && $this->confirmado;
    }

     // Limpiar los valores de los campos después de enviar el formulario
     public function limpiarInputs($campos) {
        foreach ($campos as $campo) {
            if (isset($_POST[$campo])) {
                $_POST[$campo] = htmlspecialchars($_POST[$campo]);
                $_POST[$campo] = trim($_POST[$campo]);
                $_POST[$campo] = stripslashes($_POST[$campo]);
            }
        }
    }

    
}