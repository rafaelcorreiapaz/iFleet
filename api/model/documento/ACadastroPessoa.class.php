<?php

namespace model\documento;

abstract class ACadastroPessoa
{

	protected $numeroDocumento;

	public function __construct($numeroDocumento)
	{
		$this->numeroDocumento = $numeroDocumento;
	}

	public function getDocumento()
	{
		return $this->numeroDocumento;
	}

	public abstract function validarDocumento();

}