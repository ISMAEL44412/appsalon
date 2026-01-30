<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\LoginController;
use Controllers\CitaController;
use Controllers\APIController;
use Controllers\AdminController;
use Controllers\ServicioController;

$router = new Router();

# Iniciar Sesion
$router ->get("/", [LoginController::class, "login"]);
$router ->post("/login", [LoginController::class, "login"]);

# Logout
$router -> get("/logout", [LoginController::class, "logout"]);
$router -> post("/logout", [LoginController::class, "logout"]);

# Crear Cuenta
$router -> get("/crearCuenta", [LoginController::class, "crearCuenta"]);
$router -> post("/crearCuenta", [LoginController::class, "crearCuenta"]);

# Recuperar Cuenta
$router -> get("/recuperarCuenta", [LoginController::class, "recuperarCuenta"]);
$router -> post("/recuperarCuenta", [LoginController::class, "recuperarCuenta"]);

$router -> get("/reestablecerPassword", [LoginController::class, "reestablecerPassword"]);
$router -> post("/reestablecerPassword", [LoginController::class, "reestablecerPassword"]);

# Verificar Cuenta
$router -> get("/verificarCuenta", [LoginController::class, "verificarCuenta"]);
$router -> get("/mensaje", [LoginController::class, "mensaje"]);


# AREA PRIVADA
$router -> get("/cita",[CitaController::class, "index"]);
$router -> get("/admin",[AdminController::class, "index"]);


# API
$router -> get("/api/servicios", [APIController::class, "index"]);
$router -> post("/api/citas", [APIController::class, "guardar"]);
$router -> post("/api/eliminar", [APIController::class, "eliminar"]);


# Crud
$router -> get("/servicios", [ServicioController::class, "index"]);
$router -> get("/servicios/crear", [ServicioController::class, "crear"]);
$router -> post("/servicios/crear", [ServicioController::class, "crear"]);
$router -> get("/servicios/actualizar", [ServicioController::class, "actualizar"]);
$router -> post("/servicios/actualizar", [ServicioController::class, "actualizar"]);
$router -> post("/servicios/eliminar", [ServicioController::class, "eliminar"]);
// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();