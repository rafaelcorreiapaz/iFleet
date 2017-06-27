<?php

namespace model;

use model\MarcaModel;

class ModeloModel extends Model
{
    private $id;
    private $descricao;
    private $marca;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setMarca(MarcaModel $marca)
    {
        $this->marca = $marca;
    }

    public function getMarca()
    {
        return $this->marca;
    }

    public function validar()
    {
        if(empty($this->descricao))
            throw new \Exception('Descri��o inv�lida');
        if(empty($this->marca))
            throw new \Exception('Marca inv�lida');
    }

    protected function popular(){}


}