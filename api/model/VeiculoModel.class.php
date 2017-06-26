<?php

namespace model;

use model\ModeloModel;

class VeiculoModel extends Model
{

	private $id;
	private $placa;
	private $modelo;
	private $kilometro_inical;
	private $kilometro_revisao;
	private $periodo_revisao;

	public function setId($id)
	{
		$this->id = $id;
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

    public function validar()
    {
        
    }


}