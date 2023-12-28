<?php

namespace Controllers;


use Model\Address;

class APIAddressController {
    public static function index(){
       

         $address = Address::all();
         echo debuguear($address);
         echo json_encode($address);
    }
}