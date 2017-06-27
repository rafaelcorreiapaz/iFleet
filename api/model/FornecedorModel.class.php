<?php

namespace model;
use model\Model;
use model\documento\ACadastroPessoa;

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

    public function setCpfCnpj(ACadastroPessoa $cpfcnpj)
    {
        $this->cpfcnpj = $cpfcnpj;
    }

    public function getCpfCnpj()
    {
        return $this->cpfcnpj;
    }

    public function validar()
    {
        if(empty($this->nome))
            throw new \Exception('Nome inválido');
        if(!$this->cpfcnpj->validarDocumento())
            throw new \Exception('Documento inválido');            
            
    }

    protected function popular(){}


}