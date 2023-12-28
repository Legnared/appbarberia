<?php

namespace Model;

class Address extends ActiveRecord {
     // Base de Datos
     protected static $tabla = 'address';
     protected static $columnasDB = ['address_id', 'customer_id', 'firstname', 'lastname', 'company', 'address_1', 'address_2', 'city', 'postcode', 'country_id', 'zone_id', 'custom_field'];
 
    public $address_id;
    public $customer_id;
    public $firstname; 
    public $lastname; 
    public $company;
    public $address_1;
    public $address_2;
    public $city;
    public $postcode;
    public $country_id;
    public $zone_id;
    public $custom_field;
 
     public function __construct($args = [])
     {
 
         
         $this->address_id = $args['address_id'] ?? null;
         $this->customer_id = $args['customer_id'] ?? null;
         $this->firstname = $args['firstname'] ?? '';
         $this->lastname = $args['lastname'] ?? '';
         $this->company = $args['company'] ?? '';
         $this->address_1 = $args['address_1'] ?? '';
         $this->address_2 = $args['address_2'] ?? '';
         $this->city = $args['city'] ?? '';
         $this->postcode = $args['postcode'] ?? '';
         $this->country_id = $args['country_id'] ?? null;
         $this->zone_id = $args['zone_id'] ?? null;'';
         $this->custom_field = $args['custom_field'] ?? '';
 
 
 
     }
}