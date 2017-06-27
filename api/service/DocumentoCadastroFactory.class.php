<?php

use model\documento\CNPJ;
use model\documento\CPF;

class DocumentoCadastroFactory
{

	public static function getObjeto($numeroDocumento)
	{
		if(strlen($numeroDocumento) === 11)
			return new CPF($numeroDocumento);
		elseif(strlen($numeroDocumento) === 14)
			return new CNPJ($numeroDocumento);
	}

}