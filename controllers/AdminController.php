<?php

namespace Controllers;

use Classes\Email;
use Model\AdminCita;
use MVC\Router;
use Model\Usuario;
class AdminController {
    
    public static function index(Router $router) {
        
        if(!isset($_SESSION)) {
            session_start();
        }        
        isAdmin();

        $fecha = $_GET["fecha"] ?? date('Y-m-d');
        $fechas = explode('-', $fecha);
        if(!checkdate($fechas[1], $fechas[2], $fechas[0])){
            Header("Location: /404");
        }
        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuario_id = usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citasServicios ";
        $consulta .= " ON citasServicios.cita_id= citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id = citasServicios.servicio_id ";
        $consulta .= " WHERE fecha =  '$fecha' ";

        $citas = AdminCita::SQL($consulta);

    $router->render('admin/index', [
        "nombre" => $_SESSION["nombre"],
        'citas'=> $citas,
        'fecha'=> $fecha,
    ]);
    }
}