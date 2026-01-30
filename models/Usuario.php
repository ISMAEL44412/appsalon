<?php

namespace Model;

class Usuario extends ActiveRecord {

    protected static $tabla = 'usuarios';
    protected static $columnasDB = ["id", "nombre", "apellido", "email", "password", "telefono", "admin", "confirmado", "token" ];
    protected static $alertas = [];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->nombre = $args["nombre"] ?? '';
        $this->apellido = $args["apellido"] ?? '';
        $this->email = $args["email"] ?? '';
        $this->password = $args["password"] ?? '';
        $this->telefono = $args["telefono"] ?? '';
        $this->admin = $args["admin"] ?? 0;
        $this->confirmado = $args["confirmado"] ?? 0;
        $this->token = $args["token"] ?? null;

    }
    public  function validarNuevaCuenta() {
        if(!$this->nombre) {
            self::$alertas["error"][] = "El nombre es obligatorio";
        }
        if(!$this->apellido) {
            self::$alertas["error"][] = "El apellido es obligatorio";
        }
        if(!$this->email) {
            self::$alertas["error"][] = "El email es obligatorio";
        }
        if(!$this->telefono) {
            self::$alertas["error"][] = "El telefono es obligatorio";
        }
        if(!$this->password) {
            self::$alertas["error"][] = "La contraseña es obligatoria";
        } else {
            if(strlen($this->password) <= 8) {
                self::$alertas["error"][] = "La contraseña debe ser mayor a 8 caracteres";
            }
        }

        return self::$alertas;
    }
    public function buscarEmail() {
        $stmt = self::$db->prepare("SELECT * FROM ". self::$tabla . " WHERE email = ? LIMIT 1");
        $stmt->bind_param('s', $this->email);
        $stmt->execute();

        $resultado = $stmt->get_result();
        $usuario = $resultado->fetch_assoc();
        return $usuario;
    }

    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken() {
        $this->token = substr(md5(uniqid(mt_rand(), true)), 0, 15);
        return $this->token;
    }
    public function verificarPassword($password, $hash) {
        $passwordResultado = password_verify($password, $hash);
        return $passwordResultado;
    }

    public  function  validarLogin() {
        if(!$this->email) {
            self::$alertas["error"][] = "El email es obligatorio";
        }
        if(!$this->password) {
            self::$alertas["error"][] = "El password es obligatorio";
        }
        return self::$alertas;
    }
    public function validarEmail() {
        if(!$this->email) {
            self::$alertas["error"][] = "El email es obligatorio";
        }
        return self::$alertas;
    }
    public function validarContraseña() {
        if(!$this->password) {
            self::$alertas["error"][] = "La contraseña es obligatoria";
        } else {
            if(strlen($this->password) <= 8) {
                self::$alertas["error"][] = "La contraseña debe ser mayor a 8 caracteres";
            }
        }
        return self::$alertas;
    }

    public function validarConfirmadoPassword($password, $passwordBD) {
        $resultado = password_verify($password, $passwordBD);
        if($this->confirmado == "0" || !$resultado) {
            self::$alertas["error"][] = "Cuenta no verificada o password incorrecto";
        } else {
            return true;
        }
    }
}
