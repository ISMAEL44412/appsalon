<?php

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;
use Reflection;

class APIController {

    public static function index() {
        $servicios = Servicio::all();
        echo(json_encode($servicios));
    }

    public static function guardar() {

        $cita = new Cita($_POST);
        $resultado = $cita->guardar();
        $id = $resultado["id"];

        // Almacena los servicios con el ID de la cita
        $idServicios = explode(",", $_POST["servicios"]);
        foreach($idServicios as $idServicio) {
            $args = [
                "cita_id"=> $id,
                "servicio_id" => $idServicio,
            ];
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }
        // $respuesta = [
        //     "resultado" => $resultado
        // ];
        echo json_encode(["resultado"=>$resultado]);
    }
    public static function eliminar(){

        $referer = $_SERVER["HTTP_REFERER"] ?? "/admin";
        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            Header("Location: ". $referer);
            exit;
        }
        $id = filter_var($_POST["id"],FILTER_VALIDATE_INT);
        
        if(!$id){
            Header("Location: ". $referer);
            exit;
        }
        $cita = Cita::find($id);
        if ($cita) {
            $cita->eliminar();
        }

        Header("Location: ". $referer);
        exit;

    }
}