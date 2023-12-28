<?php

namespace Model;

class Customer extends ActiveRecord {
     // Base de Datos
     protected static $tabla = 'customer';
     protected static $columnasDB = ['customer_id', 'customer_group_id', 'store_id', 'language_id', 'firstname', 'lastname', 'email', 'telephone', 'profile_image', 'fax', 'password', 'salt', 'cart','wishlist', 'newsletter', 'address_id', 'custom_field', 'ip', 'status', 'safe', 'token', 'code', 'date_added'];
 
    public $customer_id;
    public $customer_group_id;
    public $store_id; 
    public $language_id; 
    public $firstname;
    public $lastname;
    public $email;
    public $telephone;
    public $profile_image;
    public $fax;
    public $password;
    public $salt;
    public $cart;
    public $wishlist;
    public $newsletter;
    public $address_id;
    public $custom_field;
    public $ip;
    public $status;
    public $safe;
    public $token;
    public $code;
    public $date_added;
 
     public function __construct($args = [])
     {
 
       
         $this->customer_id = $args['customer_id'] ?? null;
         $this->customer_group_id = $args['customer_group_id'] ?? null;
         $this->store_id = $args['store_id'] ?? null;
         $this->language_id = $args['language_id'] ?? null;
         $this->firstname = $args['firstname'] ?? '';
         $this->lastname = $args['lastname'] ?? '';
         $this->email = $args['email'] ?? '';
         $this->telephone = $args['telephone'] ?? '';
         $this->profile_image = $args['profile_image'] ?? '';
         $this->fax = $args['fax'] ?? '';
         $this->password = $args['password'] ?? '';
         $this->salt = $args['salt'] ?? '';
         $this->cart = $args['cart'] ?? '';
         $this->wishlist = $args['wishlist'] ?? '';
         $this->newsletter = $args['newsletter'] ?? null;
         $this->address_id = $args['address_id'] ?? null;
         $this->custom_field = $args['custom_field'] ?? '';
         $this->ip = $args['ip'] ?? '';
         $this->status = $args['status'] ?? null;
         $this->safe = $args['safe'] ?? null;
         $this->token = $args['token'] ?? '';
         $this->code = $args['code'] ?? '';
         $this->date_added = $args['date_added'] ?? '';

 
 
     }
}