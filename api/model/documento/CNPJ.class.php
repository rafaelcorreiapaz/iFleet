<?php

namespace model\documento;

use model\documento\ACadastroPessoa;

class CNPJ extends ACadastroPessoa
{

	public function validarDocumento()
	{
		$soma = 0;
		
		$soma += ($this->numeroDocumento[0] * 5);
		$soma += ($this->numeroDocumento[1] * 4);
		$soma += ($this->numeroDocumento[2] * 3);
		$soma += ($this->numeroDocumento[3] * 2);
		$soma += ($this->numeroDocumento[4] * 9); 
		$soma += ($this->numeroDocumento[5] * 8);
		$soma += ($this->numeroDocumento[6] * 7);
		$soma += ($this->numeroDocumento[7] * 6);
		$soma += ($this->numeroDocumento[8] * 5);
		$soma += ($this->numeroDocumento[9] * 4);
		$soma += ($this->numeroDocumento[10] * 3);
		$soma += ($this->numeroDocumento[11] * 2); 

		$d1 = $soma % 11; 
		$d1 = $d1 < 2 ? 0 : 11 - $d1; 

		$soma = 0;
		$soma += ($this->numeroDocumento[0] * 6); 
		$soma += ($this->numeroDocumento[1] * 5);
		$soma += ($this->numeroDocumento[2] * 4);
		$soma += ($this->numeroDocumento[3] * 3);
		$soma += ($this->numeroDocumento[4] * 2);
		$soma += ($this->numeroDocumento[5] * 9);
		$soma += ($this->numeroDocumento[6] * 8);
		$soma += ($this->numeroDocumento[7] * 7);
		$soma += ($this->numeroDocumento[8] * 6);
		$soma += ($this->numeroDocumento[9] * 5);
		$soma += ($this->numeroDocumento[10] * 4);
		$soma += ($this->numeroDocumento[11] * 3);
		$soma += ($this->numeroDocumento[12] * 2); 
		
		$d2 = $soma % 11; 
		$d2 = $d2 < 2 ? 0 : 11 - $d2; 

		return ($this->numeroDocumento[12] == $d1 && $this->numeroDocumento[13] == $d2);
	}
	
}