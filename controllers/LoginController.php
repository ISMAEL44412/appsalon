<?php

namespace  Controllers;

use Classes\Email;
use MVC\Router;
use Model\Usuario;
class  LoginController {

    // * Login funcionando
    public static function login(Router $router) {
        $alertas = [];

        if ($_SERVER["REQUEST_METHOD"]=== "POST") {
            $auth = new Usuario($_POST);

            $alertas = $auth->validarLogin();
            
            if(empty($alertas)) {
                $usuario = Usuario::buscarAtributo("email", $auth->email, 1);
                if (!$usuario) {
                    Usuario::setAlerta("error", "El usuario no existe");
                } else {
                    $resultado = $usuario->validarConfirmadoPassword($auth->password, $usuario->password);
                    if($resultado) {

                        // Autenticar al usuario
                        session_start();
                        $_SESSION["id"] = $usuario->id;
                        $_SESSION["email"] = $usuario->email;
                        $_SESSION["nombre"] = $usuario->nombre . " ". $usuario->apellido;
                        $_SESSION["login"] = true;

                        // Comprobar si el usuario es admin
                        if($usuario->admin == '1') {
                            $_SESSION["admin"] = $usuario->admin ?? null;
                            Header("Location: /admin");
                        } else {
                            Header("Location: /cita");
                        }
                    }
                }
            }
            $alertas = Usuario::getAlertas();
        }
        $router ->render("/auth/login", [
            "alertas" => $alertas,
        ]);
    }

    public static function logout(Router $router) {
        session_start();

        $_SESSION = [];

        Header("Location: /");
    }

    // * CrearCuenta funcionando
    public static function crearCuenta(Router $router) {
        $usuario = new Usuario();
        $alertas = [];
        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            if(empty($alertas)) {

                // Busqueda si el email ya existe
                $resultado = $usuario -> buscarEmail();
                if(!is_null($resultado)) {
                    $alertas['error'][] = "Este usuario ya existe";
                    
                } else {
                    // Hash Contraseña
                    $usuario->hashPassword();
                    $usuario->crearToken();

                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarEmail();
                    debuguear($usuario);
                    $resultado = $usuario->guardar();
                    if($resultado) {
                        Header("Location: /mensaje");
                    }
                }
            } 
        }
        $router ->render("/auth/crearCuenta", [
            "usuario"=>$usuario,
            "alertas" => $alertas,
        ]);
    }


    // ? REALIZAR PRUEBAS
    public static function recuperarCuenta(Router $router) {
        /* 
        Esta funcion va a enviar las instrucciones al email del usuario para que pueda verificar su password
        */
        $alertas = [];

        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();
            if(empty($alertas)){
                $usuario = Usuario::buscarAtributo("email", $auth->email, 1);
                if($usuario && $usuario->confirmado == "1") {
                    $usuario->crearToken();
                    $usuario->guardar();
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->mensajeReestablecerPassword();
                    Usuario::setAlerta("valido", "Instrucciones enviadas a tu email");
                } else {
                    Usuario::setAlerta("error", "El usuario no existe o no esta confirmado");
                }
            }

        }
        $alertas = Usuario::getAlertas();
        $router ->render("/auth/reestablecerCuenta", [
            "alertas"=>$alertas,
        ]);
    }

    // * reestablecerPasword Funcionado
    public  static  function  reestablecerPassword(Router $router){
        /* 
        Esta funcion va a funcionar cuando el usuario entre al Link que se le envio al email
        */
        $alertas = [];
        $error = false;
        $token = s($_GET["token"] ?? null);
        // ? Verificar si en GET se envio un TOKEN
        if(!$token) {
            Usuario::setAlerta('error', 'Token incorrecto');
            $error = true;
        } else {
            // ? Verificar si el TOKEN EXISTE
            $usuario = Usuario::buscarAtributo("token",$token, 1);
            if(empty($usuario)){
                Usuario::setAlerta("error", "Token no valido");
                $error = true;
            }
        }
        if($_SERVER["REQUEST_METHOD"]==="POST"){
            $usuario = Usuario::buscarAtributo("token",$token, 1);
            $password = new Usuario($_POST);
            $alertas = $password->validarContraseña();
            if(empty($alertas)) {
                $password->hashPassword();
                $usuario->password = $password->password;
                $usuario->token = null;
                $resultado = $usuario->guardar();
                if($resultado) {
                    $email = new Email($usuario->nombre, $usuario->email, null);
                    $email->passwordSuccess();
                    Header("Location: /mensaje");
                }

            }
        }
        $alertas = Usuario::getAlertas();
        $router ->render("/auth/reestablecerPassword", [
            "alertas" => $alertas,
            "error" => $error
        ]);
    }


    // * FUNCIONANDO
    public static function verificarCuenta(Router $router) {
        $alertas = [];
        if(empty($_GET["token"])) {
            Usuario::setAlerta('error', 'Datos incorrectos');
        } else {
            $token = s($_GET["token"]);

            $usuario = Usuario::buscarAtributo("token",$token, 1);
            if(!$usuario){
                Usuario::setAlerta("error", "Token no valido");
            } else {
                $usuario->token = null;
                $usuario->confirmado= "1";
                $usuario->guardar();
                Usuario::setAlerta("valido", "Cuenta confirmada exitosamente");

            }
        }
        $alertas = Usuario::getAlertas();
        $router -> render("/auth/verificarCuenta", [
            "alertas"=>$alertas,
        ]);
    }
    // * FUNCIONANDO
    public static function mensaje(Router $router) {
        $router -> render("/auth/mensaje");
    }
}