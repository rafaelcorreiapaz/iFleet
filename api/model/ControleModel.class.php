<?php

namespace model;

use model\ModeloModel;
use model\FornecedorModel;
use model\ItemControleModel;
use model\dao\Controle;
use model\dao\ItemControle;

class ControleModel extends Model
{

	private $dao;
	private $daoItemControle;
	private $id;
	private $data;
	private $fornecedor;
	private $itens_controle = [];

	public function __construct($id = '')
	{
		$this->dao = new Controle();
		$this->daoItemControle = new ItemControle();
		if(!empty($id))
		{
			$this->setId($id);
			$this->popular();
		}
	}

	private function setId($id)
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

	public function setFornecedor(FornecedorModel $fornecedor)
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
		if(count($this->itens_controle) == 0)
			throw new \Exception('Nâo possui itens de controle');
		if(empty($this->fornecedor))
			throw new \Exception('Fornecedor inválido');
			
	}

	protected function popular()
	{
		if(!empty($this->getId()))
		{
			$registro = $this->dao->load($this->getId());

			$this->setFornecedor(new FornecedorModel($registro['fornecedor']));
			$this->setData($registro['data']);

			$itens_controle = $this->daoItemControle->queryAllByControle($this->getId());
			foreach($itens_controle as $itemControle)
			{
				$this->addItemControle(new ItemControleModel($itemControle['id']));
			}
	   }
	}

	public function salvar()
	{
		$this->validar();
		if($this->dao->salvar($this))
		{
			
			if(empty($this->getId()))
				$this->setId($this->dao->getId());

			foreach($this->itens_controle as $itemControle)
			{
				$itemControle->setControle($this);
				$itemControle->salvar();
			}
		}
		else
			return false;
	}


}