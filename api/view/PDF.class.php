<?php

// header('Content-type: application/pdf; charset=iso-8859-1');

class PDF 
{
	public function retornarControle()
	{
		$controle = new ControlePDF();
		$controle->setCodigoControle($_GET['id']);
		$controle->montarPDF();
	}

	public function retornarRelatorioControle()
	{
		$controle = new RelatorioControlePDF();
		$controle->setCodigoControle($_GET['id']);
		$controle->montarPDF();
	}


}