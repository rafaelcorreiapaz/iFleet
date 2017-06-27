<?php

namespace model;

class MarcaModel extends Model
{
	private $id;
	private $descricao;

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

	public function validar()
	{
        if(empty($this->descricao))
            throw new \Exception('Descrição inválida');
	}

    protected function popular(){}

}