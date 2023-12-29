<?php

namespace Controllers;

use Model\Servicio;
use Model\Cita;
use Model\CitaServicio;

class APIController {
    public static function index(){
        $servicios = Servicio::all();
        //echo debuguear($servicios);
        echo json_encode($servicios);
        
    }
    public static function guardar(){
    
        // Almacena la cita y devuelve el ID
         $cita = new Cita($_POST);
         $resultado = $cita->guardar();

         $id = $resultado['id'];

        // Almacena las servicios con el ID de la Cita

        $idServicios = explode(",",$_POST['servicios']);

        foreach($idServicios as $idServicio){
            $args = [
                'CitaId' => $id,
                'ServicioId' => $idServicio
            ];
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }

        // Retornamos una respuesta
        echo json_encode(['resultado' => $resultado]);
    }

    public static function eliminar(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            // debuguear($_SERVER);

            $cita = Cita::find($id);
            $cita->eliminar();
            header('Location:'. $_SERVER['HTTP_REFERER']);
        }
    }
}