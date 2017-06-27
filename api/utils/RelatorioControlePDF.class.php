<?php

use model\dao\Controle;
use model\dao\ItemControle;
use model\dao\Veiculo;

class RelatorioControlePDF extends APDF
{

	private $codigoControle;

	public function setCodigoControle($codigoControle)
	{
		$this->codigoControle = (int) $codigoControle;
	}

	protected function corpo()
	{

		$_GET['veiculo'] = (int) $_GET['veiculo'];
		$_GET['categoria_controle'] = (int) $_GET['categoria_controle'];

		$arrayCriterio = [];
		if(SystemHelper::validateDate($_GET['periodo_inicial'], 'Y-m-d'))
			$arrayCriterio[] = "controles.data >= '" . $_GET['periodo_inicial'] . "'";
		if(SystemHelper::validateDate($_GET['periodo_final'], 'Y-m-d'))
			$arrayCriterio[] = "controles.data >= '" . $_GET['periodo_final'] . "'";
		if($_GET['veiculo'] > 0)
			$arrayCriterio[] = "itenscontrole.veiculo = '" . $_GET['veiculo'] . "'";
		if($_GET['categoria_controle'] > 0)
			$arrayCriterio[] = "itenscontrole.categoria_controle = '" . $_GET['categoria_controle'] . "'";

		$this->setFont("Arial", "B", 10);
		$this->cell(0, 10, "RELATORIO DE CONTROLE" . (SystemHelper::validateDate($_GET['periodo_inicial'], 'Y-m-d') ? " DE " . date('d/m/Y', strtotime($_GET["periodo_inicial"])) : "") . (SystemHelper::validateDate($_GET['periodo_final'], 'Y-m-d') ? " ATÉ " . date('d/m/Y', strtotime($_GET["periodo_final"]))  : ""), 0, 1, "C");

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

	    $veiculo = new Veiculo();

		$itemControle = new ItemControle();
		$itensControle = $itemControle->queryAllOrderBy('controles.data', $arrayCriterio);
		$arrayValor = [];
		foreach($itensControle as $itemControle)
		{
			$arrayValor[] = $itemControle['valor'];
			$this->row([
				SystemConfig::getData('controles')[$itemControle['categoria_controle']]['descricao'],
				$veiculo->load($itemControle['veiculo'])['placa'],
				$itemControle['kilometro_atual'],
				SystemHelper::decimalFormat($itemControle['quantidade']),
				SystemHelper::decimalFormat($itemControle['valor'])
			]);
		}

	    $this->setFont('Arial', "B", 8);
	    $this->cell(152, 4, "", 0, 0, "C");
	    $this->cell(38, 4, SystemHelper::decimalFormat(array_sum($arrayValor)), 1, 1, "R", true);


	}
	
}