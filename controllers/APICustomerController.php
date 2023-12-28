<?php

namespace Controllers;


use Model\Customer;

class APICustomerController {
    public static function index(){
       

         $customers = Customer::all();
         echo debuguear($customers);
         echo json_encode($customers);
    }
}