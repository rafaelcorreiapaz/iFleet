<?php

namespace model;

use model\ModeloModel;
use model\ItemControleModel;
use model\dao\Veiculo;
use model\dao\ItemControle;

class VeiculoModel extends Model
{

	private $dao;
	private $id;
	private $placa;
	private $modelo;
	private $kilometro_inical;
	private $kilometro_revisao;
	private $periodo_revisao;
	private $kilometro_ultima_revisao;
	private $data_ultima_revisao;

	public function __contruct()
	{
		$this->dao = new Veiculo();
	}

	public function setId($id)
	{
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
            throw new \Exception('Placa inv�lida');
        if(empty($this->periodo_revisao) || $this->periodo_revisao < 0)
            throw new \Exception('Per�odo de revis�o inv�lida');
        if(empty($this->kilometro_revisao) || $this->kilometro_revisao < 0)
            throw new \Exception('Per�odo de revis�o inv�lida');
    }

    protected function popular()
    {
    	if(!empty($this->getId()))
    	{
    		$registro = $this->dao->load($this->getId());

    		$modelo = new ModeloModel()
    		$modelo->setId($registro['placa']);

    		$this->setModelo($modelo);
    		$this->setPlaca($registro['placa']);
    		$this->setKilometroInicial($registro['kilometro_inical']);
    		$this->setKilometroRevisao($registro['kilometro_revisao']);
    		$this->setPeriodoRevisao($registro['periodo_revisao']);

    		$registroItemControle = new ItemControle();
    		$registroItemControle->loadUltimaRevisaoPorVeiculo($this->getId());
    		$this->setDataUltimaRevisao($registroItemControle['data']);
    		$this->setKilometroUltimaRevisao($registroItemControle['kilometro_atual']);
    	}
    }


}