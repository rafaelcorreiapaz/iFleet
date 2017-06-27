<?php

namespace model;

use model\ModeloModel;

class ItemControleModel extends Model
{

    private $id;
    private $veiculo;
    private $kilometro_atual;
    private $controle;
    private $categoria_controle;
    private $quantidade;
    private $valor;

    public function setId($id)
    {
    	$this->id = $id;
    }

    public function getId()
    {
    	return $this->id;
    }

    public function setVeiculo($veiculo)
    {
    	$this->veiculo = $veiculo;
    }

    public function getVeiculo()
    {
    	return $this->veiculo;
    }

    public function setKilometroAtual($kilometro_atual)
    {
    	$this->kilometro_atual = (int) $kilometro_atual;
    }

    public function getKilometroAtual()
    {
    	return $this->kilometro_atual;
    }

    public function setCategoriaControle($categoria_controle)
    {
        $this->categoria_controle = $categoria_controle;
    }

    public function getCategoriaControle()
    {
        return $this->categoria_controle;
    }

    public function setControle($controle)
    {
    	$this->controle = $controle;
    }

    public function getControle()
    {
    	return $this->controle;
    }

    public function setQuantidade($quantidade)
    {
    	$this->quantidade = $quantidade;
    }

    public function getQuantidade()
    {
    	return $this->quantidade;
    }

    public function setValor($valor)
    {
    	$this->valor = $valor;
    }

    public function getValor()
    {
    	return $this->valor;
    }

	public function validar()
	{
		
	}

    protected function popular(){}

}