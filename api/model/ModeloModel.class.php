<?php

namespace model;

use model\MarcaModel;
use model\dao\Modelo;

class ModeloModel extends Model
{
    private $dao;
    private $id;
    private $descricao;
    private $marca;

    public function __construct($id = '')
    {
        $this->dao = new Modelo();
        if(!empty($id))
        {
            $this->id = $id;
            $this->popular();
        }
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
            throw new \Exception('Descrição inválida');
        if(empty($this->marca))
            throw new \Exception('Marca inválida');
    }

    protected function popular()
    {
        $registro = $this->dao->load($this->getId());

        $this->setMarca(new MarcaModel($registro['marca']));
        $this->setDescricao($registro['descricao']);
    }

    public function salvar()
    {
        $this->validar();
        $this->dao->salvar($this);
    }

}