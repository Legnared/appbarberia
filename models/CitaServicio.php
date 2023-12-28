<?php

namespace Model;

class CitaServicio extends ActiveRecord {

    protected static $tabla = 'citasservicios';
    protected static $columnasDB = ['id', 'CitaId', 'ServicioId'];

    public $id;
    public $CitaId;
    public $ServicioId;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->CitaId = $args['CitaId'] ?? '';
        $this->ServicioId = $args['ServicioId'] ?? '';
    }

}