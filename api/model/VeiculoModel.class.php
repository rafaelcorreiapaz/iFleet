<?php

namespace model;

use model\ModeloModel;

class Veiculo implements Model
{

    private $id;
    private $placa;
    private $modelo;
    private $kilometro_inical;
    private $codigo_gps;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setPlaca($placa)
    {
        $this->placa = $placa;
    }

    public function getPlaca()
    {
        return $this->placa;
    }

    public function setModelo(ModeloModel $modelo)
    {
        $this->modelo = $modelo;
    }

    public function getModelo()
    {
        return $this->modelo;
    }

    public function setKilometroInicial($kilometro_inical)
    {
        $this->kilometro_inical = $kilometro_inical;
    }

    public function getKilometroInicial()
    {
        return $this->kilometro_inical;
    }


}