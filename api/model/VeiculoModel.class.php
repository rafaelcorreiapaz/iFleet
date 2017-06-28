<?php

namespace model;

use model\ModeloModel;
use model\ControleModel;
use model\ItemControleModel;
use model\dao\Veiculo;
use model\dao\ItemControle;

class VeiculoModel extends Model
{

	private $dao;
	private $daoItemControle;
	private $id;
	private $placa;
	private $modelo;
	private $controle;
	private $kilometro_inical;
	private $kilometro_revisao;
	private $periodo_revisao;
	private $kilometro_ultima_revisao;
	private $data_ultima_revisao;

	public function __construct($id = '')
	{
		$this->dao = new Veiculo();
		$this->daoItemControle = new ItemControle();
		if(!empty($id))
		{
			$this->id = $id;
			$this->setUltimaRevisao();
			$this->popular();
		}
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

	public function setControle(ControleModel $controle)
	{
		$this->controle = $controle;
		$this->setUltimaRevisao();
	}

	private function setUltimaRevisao()
	{

		$arrayCriterio = [];
		$arrayCriterio[] = 'itenscontrole.categoria_controle = 0';
		$arrayCriterio[] = 'itenscontrole.veiculo = ' . $this->getId();
		if(get_class($this->controle) === 'ControleModel')
			$arrayCriterio[] = "controles.data < '" . $this->getControle()->getData() . "'";

		$registroItemControle = $this->daoItemControle->queryAllOrderBy('itenscontrole.id DESC', $arrayCriterio);
		$this->setDataUltimaRevisao($registroItemControle['data']);
		$this->setKilometroUltimaRevisao($registroItemControle['kilometro_atual']);
	}

	public function getModelo()
	{
		return $this->modelo;
	}

	public function setKilometroInicial($kilometro_inical)
	{
		$this->kilometro_inical = (int) $kilometro_inical;
	}

	public function getKilometroInicial()
	{
		return $this->kilometro_inical;
	}

	public function setKilometroRevisao($kilometro_revisao)
	{
		$this->kilometro_revisao = (int) $kilometro_revisao;
	}

	public function getKilometroRevisao()
	{
		return $this->kilometro_revisao;
	}

	public function setPeriodoRevisao($periodo_revisao)
	{
		$this->periodo_revisao = (int) $periodo_revisao;
	}

	public function getPeriodoRevisao()
	{
		return $this->periodo_revisao;
	}

	private function setKilometroUltimaRevisao($kilometro_ultima_revisao)
	{
		$this->kilometro_ultima_revisao = $kilometro_ultima_revisao;
	}

	public function getKilometroUltimaRevisao()
	{
		return $this->kilometro_ultima_revisao;
	}

	private function setDataUltimaRevisao($data_ultima_revisao)
	{
		$this->data_ultima_revisao = $data_ultima_revisao;
	}

	public function getDataUltimaRevisao()
	{
		return $this->data_ultima_revisao;
	}

	public function validar()
	{
		if(empty($this->placa) || strlen($this->placa) != 7)
			throw new \Exception('Placa inválida');
		if(empty($this->periodo_revisao) || $this->periodo_revisao < 0)
			throw new \Exception('Período de revisão inválida');
		if(empty($this->kilometro_revisao) || $this->kilometro_revisao < 0)
			throw new \Exception('Período de revisão inválida');
	}

	protected function popular()
	{
		if(!empty($this->getId()))
		{
			$registro = $this->dao->load($this->getId());

			$this->setModelo(new ModeloModel($registro['modelo']));
			$this->setPlaca($registro['placa']);
			$this->setKilometroInicial($registro['kilometro_inical']);
			$this->setKilometroRevisao($registro['kilometro_revisao']);
			$this->setPeriodoRevisao($registro['periodo_revisao']);
		}
	}

	public function salvar()
	{
		$this->validar();
		$this->dao->salvar($this);
	}
}