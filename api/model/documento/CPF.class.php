<?php

namespace model\documento;

use model\documento\ACadastroPessoa;

class CPF extends ACadastroPessoa
{

	public function validarDocumento()
	{
		$soma = 0;
		for($i = 0; $i < 9; $i++)
			$soma += ((10-$i)*$this->numeroDocumento[$i]);

		$d1 = ($soma % 11);
		$d1 = ($d1 < 2) ? 0 : 11-$d1;

		$soma = 0;
		for($i = 0; $i < 10; $i++)
			$soma += ((11-$i)*$this->numeroDocumento[$i]);
		
		$d2 = ($soma % 11);
		$d2 = ($d2 < 2) ? 0 : 11-$d2;

		return ($d1 == $this->numeroDocumento[9] && $d2 == $this->numeroDocumento[10]);
	}

}