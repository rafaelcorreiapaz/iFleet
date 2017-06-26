<?php

namespace model;
use model\Model;

class FornecedorModel extends Model
{

    private $id;
    private $nome;
    private $cpfcnpj;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setCpfCnpj($cpfcnpj)
    {
        $this->cpfcnpj = $cpfcnpj;
    }

    public function getCpfCnpj()
    {
        return $this->cpfcnpj;
    }

    public function validar()
    {
        
    }

}