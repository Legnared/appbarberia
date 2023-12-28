<?php

namespace Controllers;
use MVC\Router;

class CitaController {

    public static function index( Router $router) {

        //iniciarSession();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        isAuth();
        //debuguear($_SESSION);

        $router->render('cita/index', [
            'nombre' => $_SESSION['nombre'],
            'id' => $_SESSION['id']
        ]);
    }
}