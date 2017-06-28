<?php

use model\ControleModel;

class ControlePDF extends APDF
{

	private $codigoControle;

	public function setCodigoControle($codigoControle)
	{
		$this->codigoControle = (int) $codigoControle;
	}

	protected function corpo()
	{
		$controle = new ControleModel($this->codigoControle);

		$this->setFont('Arial', "B", 7);
		$this->cell(30, 4, "COD CONTROLE", "L:1; T:1;", 0, "L");
		$this->cell(25, 4, "DATA", "L:1; T:1;", 0, "L");
		$this->cell(135, 4, "FORNECEDOR", "L:1; T:1; R:1;", 1, "L");

		$this->setFont('Arial', "", 8);
		$this->cell(30, 4, $controle->getId(), "L:1; B:1;", 0, "L");
		$this->cell(25, 4, $controle->getData(), "L:1; B:1;", 0, "L");
		$this->cell(135, 4, $controle->getFornecedor()->getNome(), "L:1; R:1; B:1;", 1, "L");

		$this->ln();

	    $this->setFillColor(190, 190, 190);
	    $this->setFont('Arial', "B", 6, true);

	    $this->cell(38, 4, "CAT CONTROLE", 1,0, "C", true);
	    $this->cell(38, 4, "VEÍCULO", 1,0, "C", true);
	    $this->cell(38, 4, "KM ATUAL", 1,0, "C", true);
	    $this->cell(38, 4, "QUANTIDADE", 1,0, "C", true);
	    $this->cell(38, 4, "VALOR", 1,1, "C", true);

	    $this->setWidths([38,38,38,38,38]);
	    $this->setAligns(["L", "C", "R", "R", 'R']);
	    $this->setFont('Arial', "", 8);

		$itensControle = $controle->getItensControle();
		$arrayValor = [];
		foreach($itensControle as $itemControle)
		{
			$arrayValor[] = $itemControle->getValor();
			$this->row([
				SystemConfig::getData('controles')[$itemControle->getCategoriaControle()]['descricao'],
				$itemControle->getVeiculo()->getPlaca(),
				$itemControle->getKilometroAtual(),
				$itemControle->getQuantidadeFormatada(),
				$itemControle->getValorFormatado()
			]);
		}

	    $this->setFont('Arial', "B", 8);
	    $this->cell(152, 4, "", 0, 0, "C");
	    $this->cell(38, 4, SystemHelper::decimalFormat(array_sum($arrayValor)), 1, 1, "R", true);


	}
	
}