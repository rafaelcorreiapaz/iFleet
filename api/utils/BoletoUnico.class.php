<?php

class BoletoUnico
{
	private $boleto;

	public function __construct(&$boleto, $arrayBoleto = [])
	{


		$this->boleto = $boleto;
        if(!SystemHelper::verificarDiaUtil(date('Y-m-d', $arrayBoleto["timestamp_vencimento"])))
        {
            $arrayBoleto["timestamp_vencimento"] = strtotime(SystemHelper::retornarProximoDiaUtil(date('Y-m-d', $arrayBoleto["timestamp_vencimento"])));
            $arrayBoleto["data_vencimento"] = date('d/m/Y', $arrayBoleto["timestamp_vencimento"]);
        }
		$arrayBoleto["valor_cobrado"] = $arrayBoleto["desconto"] > 0 ? SystemHelper::decimalFormat($arrayBoleto["valor"]-$arrayBoleto["desconto"]) : "";
		if($arrayBoleto["formadepagamento"] != 0)
		{
			if(date("Y-m-d", $arrayBoleto["timestamp_vencimento"]) < date("Y-m-d"))
			{
				$arrayBoleto["juro"] = SystemHelper::calcularJuroBoleto(($arrayBoleto["desconto"] > 0 ? $arrayBoleto["valor"]-$arrayBoleto["desconto"] : $arrayBoleto["valor"]), date("Y-m-d", $arrayBoleto["timestamp_vencimento"]));
				$arrayBoleto["mora"] = ($arrayBoleto["desconto"] > 0 ? $arrayBoleto["valor"]-$arrayBoleto["desconto"] : $arrayBoleto["valor"])*0.02;
				$arrayBoleto["valor_cobrado"] = SystemHelper::decimalFormat($arrayBoleto["valor"]-$arrayBoleto["desconto"]+$arrayBoleto["juro"]+$arrayBoleto["mora"]);
				$arrayBoleto["juro"] = SystemHelper::decimalFormat($arrayBoleto["juro"]);
				$arrayBoleto["mora"] = SystemHelper::decimalFormat($arrayBoleto["mora"]);
			}
		}
		$arrayBoleto["valor"] = SystemHelper::decimalFormat($arrayBoleto["valor"]);
		$arrayBoleto["desconto"] = $arrayBoleto["desconto"] > 0 ? SystemHelper::decimalFormat($arrayBoleto["desconto"]) : "";
		$arrayBoleto["data_processamento"] = date("d/m/Y");
		$arrayBoleto["nosso_numero_codigo_barras"] = substr(trim($arrayBoleto["nosso_numero"]), 0, 18);
		$arrayBoleto["valor_codigo_barras"] = SystemHelper::formatarValorCodigoBarras($arrayBoleto["valor_cobrado"] != "" ? $arrayBoleto["valor_cobrado"] : $arrayBoleto["valor"], 10, 0, "valor");

		// "$codigobanco$nummoeda$dv$fator_vencimento$valor$codigo_carteira$conta_cedente$nnum"
		$arrayBoleto = array_merge($arrayBoleto, SystemConfig::getData('caixa'));
		$arrayBoleto["agencia_codigo"] = "{$arrayBoleto["agencia"]}/{$arrayBoleto["codigo_cedente"]}-{$arrayBoleto["dv_codigo_cedente"]}";
		$arrayBoleto["fator_vencimento"] = SystemHelper::calcularFatorVencimento($arrayBoleto["data_vencimento"]);
		$dv = SystemHelper::calcularDigitoVerificadorBarra("{$arrayBoleto["codigo"]}{$arrayBoleto["moeda"]}{$arrayBoleto["fator_vencimento"]}{$arrayBoleto["valor_codigo_barras"]}{$arrayBoleto["carteira"]}{$arrayBoleto["codigo_cedente"]}{$arrayBoleto["nosso_numero_codigo_barras"]}");
		$arrayBoleto["codigo_barras"] = "{$arrayBoleto["codigo"]}{$arrayBoleto["moeda"]}{$dv}{$arrayBoleto["fator_vencimento"]}{$arrayBoleto["valor_codigo_barras"]}{$arrayBoleto["carteira"]}{$arrayBoleto["codigo_cedente"]}{$arrayBoleto["nosso_numero_codigo_barras"]}";

		$arrayBoleto['cnpjcpf'] = SystemHelper::maskValue(SystemConfig::getData('scm')['cnpjcpf'], '##.###.###/####-##');
		$arrayBoleto["cedente"] = strtoupper($arrayBoleto["cedente"]);


		$arrayTitulosRecibo = [
			"cedente" => "CEDENTE",
			"agencia_codigo" => "AGÊNCIA/CÓDIGO",
			"especie" => "ESPÉCIE",
			"quantidade" => "QUANTIDADE",
			"nosso_numero" => "NOSSO NÚMERO",
			"id" => "NÚMERO DO DOCUMENTO",
			"cnpjcpf" => "CPF/CNPJ",
			"data_vencimento" => "VENCIMENTO",
			"valor" => "VALOR DO DOCUMENTO",
			"desconto" => "( - ) DESCONTO/ABATIMENTO",
			"deducoes" => "( - ) OUTRAS DEDUÇÕES",
			"mora" => "( + ) MORA/MULTA",
			"juro" => "( + ) OUTROS ACRÉSCIMOS",
			"valor_cobrado" => "( = ) VALOR COBRADO",
			"sacado" => "SACADO",
		];

		$arrayLargurasRecibo = [
			"cedente" => 95,
			"agencia_codigo" => 25,
			"especie" => 13,
			"quantidade" => 17,
			"nosso_numero" => 40,
			"id" => 55,
			"cnpjcpf" => 47.5,
			"data_vencimento" => 47.5,
			"valor" => 40,
			"desconto" => 38,
			"deducoes" => 36,
			"mora" => 38,
			"juro" => 38,
			"valor_cobrado" => 40,
			"sacado" => 0
		];

		$arrayAlinhamentosRecibo = [
			"cedente" => "L",
			"agencia_codigo" => "L",
			"especie" => "L",
			"quantidade" => "L",
			"nosso_numero" => "R",
			"id" => "L",
			"cnpjcpf" => "L",
			"data_vencimento" => "L",
			"valor" => "R",
			"desconto" => "R",
			"deducoes" => "R",
			"mora" => "R",
			"juro" => "R",
			"valor_cobrado" => "R",
			"sacado" => "L"
		];

		$arrayBordasTitulosRecibo = [
			"cedente" => "RL",
			"agencia_codigo" => "R",
			"especie" => "R",
			"quantidade" => "R",
			"nosso_numero" => "",
			"id" => "RL",
			"cnpjcpf" => "R",
			"data_vencimento" => "R",
			"valor" => "",
			"desconto" => "RL",
			"deducoes" => "R",
			"mora" => "R",
			"juro" => "R",
			"valor_cobrado" => "",
			"sacado" => "L"
		];

		$arrayBordasValorRecibo = [
			"cedente" => "RBL",
			"agencia_codigo" => "RB",
			"especie" => "RB",
			"quantidade" => "RB",
			"nosso_numero" => "B",
			"id" => "RBLB",
			"cnpjcpf" => "RB",
			"data_vencimento" => "RB",
			"valor" => "B",
			"desconto" => "RBL",
			"deducoes" => "RB",
			"mora" => "RB",
			"juro" => "RB",
			"valor_cobrado" => "B",
			"sacado" => "L"
		];


		$this->header();

		$this->montarRecibo(
			$arrayBoleto,
			$arrayTitulosRecibo,
			$arrayLargurasRecibo,
			$arrayAlinhamentosRecibo,
			$arrayBordasTitulosRecibo,
			$arrayBordasValorRecibo
		);


		$arrayTitulosFicha = [
			"local_pagamento" => "LOCAL DE PAGAMENTO",
			"data_vencimento" => "VENCIMENTO",
			"cedente" => "CEDENTE",
			"agencia_codigo" => "AGÊNCIA/CÓDIGO",
			"data_emissao" => "DATA DO DOCUMENTO",
			"id" => "NÚMERO DO DOCUMENTO",
			"especie_doc" => "ESPÉCIE DOCUMENTO",
			"aceite" => "ACEITE",
			"data_processamento" => "DATA PROCESSAMENTO",
			"nosso_numero" => "NOSSO NÚMERO",
			"banco" => "USO DO BANCO",
			"carteira" => "CARTEIRA",
			"especie" => "ESPÉCIE",
			"quantidade" => "QUANTIDADE",
			"valor1" => "VALOR",
			"valor" => "( = ) VALOR DO DOCUMENTO"
		];

		$arrayLargurasFicha = [
			"local_pagamento" => 150,
			"data_vencimento" => 40,
			"cedente" => 150,
			"agencia_codigo" => 40,
			"data_emissao" => 40,
			"id" => 30,
			"especie_doc" => 30,
			"aceite" => 20,
			"data_processamento" => 30,
			"nosso_numero" => 40,
			"banco" => 40,
			"carteira" => 15,
			"especie" => 15,
			"quantidade" => 50,
			"valor1" => 30,
			"valor" => 40
		];

		$arrayAlinhamentosFicha = [
			"local_pagamento" => "L",
			"data_vencimento" => "R",
			"cedente" => "L",
			"agencia_codigo" => "R",
			"data_emissao" => "L",
			"id" => "L",
			"especie_doc" => "R",
			"aceite" => "R",
			"data_processamento" => "L",
			"nosso_numero" => "R",
			"banco" => "L",
			"carteira" => "L",
			"especie" => "L",
			"quantidade" => "L",
			"valor1" => "L",
			"valor" => "R"
		];

		$arrayBordasTitulo = [
			"local_pagamento" => "LR",
			"data_vencimento" => "LT",
			"cedente" => "LR",
			"agencia_codigo" => "T",
			"data_emissao" => "LR",
			"id" => "R",
			"especie_doc" => "R",
			"aceite" => "R",
			"data_processamento" => "R",
			"nosso_numero" => "",
			"banco" => "LR",
			"carteira" => "R",
			"especie" => "R",
			"quantidade" => "R",
			"valor1" => "R",
			"valor" => "LT"
		];

		$arrayBordasValor = [
			"local_pagamento" => "LRB",
			"data_vencimento" => "LB",
			"cedente" => "LRB",
			"agencia_codigo" => "B",
			"data_emissao" => "LRB",
			"id" => "RB",
			"especie_doc" => "RB",
			"aceite" => "RB",
			"data_processamento" => "RB",
			"nosso_numero" => "B",
			"banco" => "LRB",
			"carteira" => "RB",
			"especie" => "RB",
			"quantidade" => "RB",
			"valor1" => "RB",
			"valor" => "BL"
		];

		$arrayFill = [
			"data_vencimento" => true,
			"valor" => true,
			"desconto" => true,
		];	

		$this->montarFichaCompensacao(
			$arrayBoleto,
			$arrayTitulosFicha,
			$arrayLargurasFicha,
			$arrayAlinhamentosFicha,
			$arrayBordasTitulo,
			$arrayBordasValor,
			$arrayFill,
			$y
		);

	}

	public function montarCelulas(array $lista, array $titulos, array $larguras, array $alinhamentos, array $bordasTitulo, array $bordasValor, $fill = false){
		foreach ($titulos AS $chave => $valor) 
		{   
			$w = $larguras[$chave];
			$x = $this->boleto->getX();
			$y = $this->boleto->getY();
			$linha =+ $x;

			if ($linha >= 190.00125) {
				$linha = 0;
				$y += 7;
				$this->boleto->SetY($y);              
				$x = $this->boleto->getX();
			}

			$this->boleto->setFillColor(190, 190, 190);
			$this->boleto->setFont('Arial', 'B', 6);
			$this->boleto->Cell($w, 3.5, $titulos[$chave], $bordasTitulo[$chave], 2, "L", $fill[$chave]);
			$this->boleto->setFont('Arial', '', 7);
			$this->boleto->Cell($w, 3.5,  $lista[$chave], $bordasValor[$chave], 1 , $alinhamentos[$chave], $fill[$chave]);

			$x = $x+$w; 
			$this->boleto->SetY($y);
			$this->boleto->SetX($x);
		}
	}

	public function header()
	{

		$this->boleto->image("imagens/logo_relatorio.jpg", 10, 6, 20);

		$this->boleto->ln(2);

		$this->boleto->setFont('Arial', 'BU', 12);
		$this->boleto->cell(25);
		$this->boleto->cell(75, 0, "JÚPITER TELECOMUNICAÇÕES E INFORMÁTICA LTDA", 0, 0, 'L');

		$this->boleto->ln();
		$this->boleto->cell(25);
		$this->boleto->setFont('Arial', '', 7);
		$this->boleto->cell(75, 10, "RUA SIMPLÍCIO MOREIRA, 1.485B - CENTRO - FONE: (99) 3529-3131", 0, 0, 'L');

		$this->boleto->ln();
		$this->boleto->cell(25);
		$this->boleto->cell(75, -2, SystemConfig::getData("_imperatriz")['entidade'] . " - www.jupiter.com.br - sac@jupiter.com.br - " . date("d/m/Y H:i:s"), 0, 0, 'L');

		if($this->boleto->titulo != '')
		{
			$this->boleto->setY(6);
			$this->boleto->setX(160);
			$this->boleto->setFont('Arial', 'B', 10);
			$this->boleto->drawTextBox($this->boleto->titulo, 40, 20, 'C', 'M');
		}

		$this->boleto->ln($this->titulo != '' ? 15 : 10);
	}

	public function montarReciboRetrato(array $lista, array $titulos, array $larguras, array $alinhamentos, array $bordasTitulo,  array $bordasValor)
	{
		$this->boleto->SetLineWidth(0.05);

		$this->boleto->SetX(9);
		$this->boleto->setFont('Arial', '', 5);
		for ($i=0; $i < 271; $i++)
			$this->boleto->Cell(0.7, 1, ".", 0, 0);

		$this->boleto->ln(1);
		$this->boleto->setFont('Arial', 'B', 6);
		$this->boleto->Cell(0, 4, "RECIBO DO SACADO", 0, 0, "R");
		$this->boleto->ln(4);

		$y = $this->boleto->getY();

		$this->boleto->Cell(25, 9, '', 'RB');
		$this->boleto->Image('imagens/logocaixa.jpg', 11, $y+1, 22, 6);

		$this->boleto->setFont('Arial', 'B', 16);
		$this->boleto->Cell(17, 9, "104-0", "BR", 0, "C");

		$this->boleto->setFont('Arial', '', 13);
		$this->boleto->Cell(148, 9, SystemHelper::montarLinhaDigitavel($lista["codigo_barras"]), "B", 1, "R");
		$this->montarCelulas(
			$lista,
			$titulos,
			$larguras,
			$alinhamentos,
			$bordasTitulo,
			$bordasValor
		);

		$this->boleto->ln(7);

		$this->boleto->multiCell(0, 3.5, "{$lista['endereco']}\n{$lista['localizacao']}", "LB", "", 0);
		
		$this->boleto->ln(1);

		$this->boleto->setFont('Arial', '', 6);
		$this->boleto->Cell(150, 1, "Demonstrativo", "", 0, "L");
		$this->boleto->Cell(40, 1, "Autenticação mecânica", "", 1, "R");

		$this->boleto->setFont('Arial', '', 7);
		$this->boleto->multiCell(0, 3.5, $lista["demonstrativo"]);
		if(count(explode("\n", $lista["demonstrativo"])) < 5)
			$this->boleto->ln(10-count(explode("\n", $lista["demonstrativo"])));

		$this->boleto->SetX(9);
		$this->boleto->setFont('Arial', '', 5);
		for ($i=0; $i < 271; $i++)
			$this->boleto->Cell(0.7, 1, ".", 0, 0);

		$this->boleto->ln(4);

	}

	public function montarFichaCompensacaoRetrato(array $lista, array $titulos, array $larguras, array $alinhamentos, array $bordasTitulo,  array $bordasValor, array $fill, $y)
	{
		$y = $this->boleto->getY();
		$this->boleto->Cell(25, 9, '', 'RB');
		$this->boleto->Image('imagens/logocaixa.jpg', 11, $y+1, 22, 6);

		$this->boleto->setFont('Arial', 'B', 16);
		$this->boleto->Cell(17, 9, "104-0", "BR", 0, "C");

		$this->boleto->setFont('Arial', '', 13);
		$this->boleto->cell(148, 9, SystemHelper::montarLinhaDigitavel($lista["codigo_barras"]), "B", 1, "R");

		$this->montarCelulas(
			$lista,
			$titulos,
			$larguras,
			$alinhamentos,
			$bordasTitulo,
			$bordasValor,
			$fill
		);

		$this->boleto->ln(7);

		$this->boleto->setFont('Arial', 'B', 5);
		$this->boleto->Cell(150, 3.5, "Instruções (Texto de Responsabilidade do Cedente)", "L", 0, "L");
		$this->boleto->setFont('Arial', 'B', 6);
		$this->boleto->Cell(40, 3.5, "( - ) DESCONTO/ABATIMENTO", "L", 1, "L", ($lista['desconto'] != ""));

		$this->boleto->setFont('Arial', 'B', 5);
		$this->boleto->Cell(150, 3.5, "SVA - SERV DE VALOR ADICIONADO:", "L", 0, "L");

		$this->boleto->setFont('Arial', '', 7);
		$this->boleto->Cell(40, 3.5, $lista['desconto'], "BL", 1, "R", ($lista['desconto'] != ""));

		$this->boleto->setFont('Arial', 'B', 5);
		$this->boleto->Cell(150, 3.5, strtoupper(SystemConfig::getData('_imperatriz')['sva']['nome']) . " - " . SystemConfig::getData('_imperatriz')['sva']['cnpjcpf'] . " - R$" . $lista['vlrsva'] , "L", 0, "L");

		$this->boleto->setFont('Arial', 'B', 6);
		$this->boleto->Cell(40, 3.5, "( + ) OUTROS ACRÉSCIMOS", "L", 1, "L", ($lista['juro'] != ""));

		$this->boleto->setFont('Arial', 'B', 5);
		$this->boleto->Cell(150, 3.5, "SCM - SERV DE COMUNICAÇÃO MULTIMÍDIA:", "L", 0, "L");

		$this->boleto->setFont('Arial', '', 7);
		$this->boleto->Cell(40, 3.5, $lista['juro'], "BL", 1, "R", ($lista['juro'] != ""));

		$this->boleto->setFont('Arial', 'B', 5);
		$this->boleto->Cell(150, 3.5, strtoupper(SystemConfig::getData('scm')['nome']) . " - " . SystemConfig::getData('scm')['cnpjcpf'] . " - R$" . $lista['vlrscm'] , "L", 0, "L");
		$this->boleto->setFont('Arial', 'B', 6);
		$this->boleto->Cell(40, 3.5, "( + ) MORA/MULTA", "L", 1, "L", ($lista['mora'] != ""));

		$this->boleto->setFont('Arial', 'B', 5);
		$this->boleto->Cell(150, 3.5, "APÓS VENCIMENTO, COBRAR MULTA DE 2% E JUROS DE 1% AO MÊS", "RL", 0, "L");
		$this->boleto->setFont('Arial', '', 7);
		$this->boleto->Cell(40, 3.5, $lista['mora'], "B", 1, "R", ($lista['mora'] != ""));
		$this->boleto->Cell(150, 3.5, "", "L", 0, "L");
		$this->boleto->setFont('Arial', 'B', 6);
		$this->boleto->Cell(40, 3.5, "( = ) VALOR COBRADO", "LT", 1, "L", ($lista['valor_cobrado'] != ""));
		$this->boleto->Cell(150, 3.5, "", "BL", 0, "L");

		$this->boleto->setFont('Arial', '', 7);
		$this->boleto->Cell(40, 3.5, $lista['valor_cobrado'], "LB", 1, "R", ($lista['valor_cobrado'] != ""));

		$this->boleto->setFont('Arial', 'B', 6);
		$this->boleto->cell(150, 3.5, "SACADO", "RL", 0, "L");

		$this->boleto->setFont('Arial', 'B', 6);
		$this->boleto->cell(40, 3.5, "CPF/CNPJ", "", 1);

		$this->boleto->setFont('Arial', '', 7);
		$this->boleto->cell(150, 3.5, "{$lista['contrato']} - {$lista['sacado']}", "RL", 0, "L");
		$this->boleto->cell(40, 3.5, "", "", 1);
		$this->boleto->cell(150, 3.5, "{$lista['endereco']}", "RL", 0, "L");
		$this->boleto->cell(40, 3.5, "", "", 1);
		$this->boleto->cell(150, 3.5, "{$lista['localizacao']}", "RL", 0, "L");
		$this->boleto->cell(40, 3.5, "", "", 1);
		
		$this->boleto->cell(150, 3.5, "Sacador/Avalista", "BRL", 0, "L");
		$this->boleto->cell(40, 3.5, "Código da baixa", "B", 1);
		

		$yBarcode = $this->boleto->getY();

		$this->boleto->Cell(25, 7, '', '');
		$this->boleto->Image("http://localhost/api/utils/Barcode.php?n={$lista['codigo_barras']}&extensao=.png", 10, $yBarcode+3, 130, 13);
		$yBarcode = $this->boleto->getY();
		$this->boleto->setY($yBarcode);

		$this->boleto->setX(150);
		$this->boleto->setFont('Arial', 'B', 6);
		$this->boleto->Cell(0, 3.5, "Autenticação Mecânica - Ficha de Compensação", 0, 1, "L");

		$this->boleto->ln(15);
		$this->boleto->SetX(9);
		$this->boleto->setFont('Arial', '', 5);
		for ($i=0; $i < 271; $i++)
			$this->boleto->Cell(0.7, 1, ".", 0, 0);

		$this->boleto->ln(4);
		if(($this->boleto->h - $this->boleto->GetY()) <= 25)
			$this->boleto->AddPage();

	}
}