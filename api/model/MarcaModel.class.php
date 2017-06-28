<?php

namespace model;

use model\dao\Marca;

class MarcaModel extends Model
{
	private $dao;
	private $id;
	private $descricao;

	public function __construct($id = '')
	{
		$this->dao = new Marca();
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

	public function validar()
	{
		if(empty($this->descricao))
			throw new \Exception('Descrição inválida');
	}

	protected function popular()
	{
		if(!empty($this->getId()))
		{
			$registro = $this->dao->load($this->getId());
			$this->setDescricao($registro['descricao']);
		}
	}

	public function salvar()
	{
		$this->validar();
		return $this->dao->salvar($this);
	}

}