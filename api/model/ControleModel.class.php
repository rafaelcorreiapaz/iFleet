<?php

namespace model;

use model\ModeloModel;

class ControleModel extends Model
{

	private $relacao = ['id' => 'Id', 'data' => 'Data', 'fornecedor' => 'Fornecedor'];

	private $id;
	private $data;
	private $fornecedor;
	private $itens_controle = [];

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setData($data)
	{
		$this->data = $data;
	}

	public function getData()
	{
		return $this->data;
	}

	public function setFornecedor($fornecedor)
	{
		$this->fornecedor = $fornecedor;
	}

	public function getFornecedor()
	{
		return $this->fornecedor;
	}

	public function addItemControle(ItemControleModel $itemControle)
	{
		$this->itens_controle[] = $itemControle;
	}

	public function getItensControle()
	{
		return $this->itens_controle;
	}

	public function validar()
	{

	}

}