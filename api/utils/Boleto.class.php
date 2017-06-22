<?php

class Boleto
{
	private $boleto;
	private $arrayBoleto;
	public $status = true;

	public function __construct(&$boleto, $arrayBoleto = [], $layout = "P")
	{
		if($arrayBoleto === false OR count($arrayBoleto) === 0)
		{
			$this->status = false;
			return false;
		}

		$this->boleto  = $boleto;
		$this->paginas = $paginas;

		$y = $this->boleto->getY();
		$arrayBoleto["juro"] = $arrayBoleto["juro"] == 0 ? null : $arrayBoleto["juro"];

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
				$arrayBoleto["demonstrativo"] = "Data de vencimento original {$arrayBoleto["data_vencimento"]}";
				$arrayBoleto["data_vencimento"] = date("d/m/Y");
			}
		}
		else
		{
			if(date("Y-m-d", $arrayBoleto["timestamp_vencimento"]) < date("Y-m-d"))
			{
				$arrayBoleto["demonstrativo"] = "Data de vencimento original {$arrayBoleto["data_vencimento"]}";
				$arrayBoleto["data_vencimento"] = date("d/m/Y", strtotime(date("Y-m-d"))+(24*60*60));
			}
		}

		if($arrayBoleto["vencimento_original"] != "")
			$dadosboleto["demonstrativo1"] = "Boleto com a data de vencimento alterada, devido a pagamento errado, data de vencimento original " . date("d/m/Y", strtotime($arrayBoleto["vencimento_original"]));

		$arrayBoleto["sacado"] = strtoupper($arrayBoleto["sacado"]);
		$arrayBoleto["valor"] = SystemHelper::decimalFormat($arrayBoleto["valor"]);
		$arrayBoleto["desconto"] = $arrayBoleto["desconto"] > 0 ? SystemHelper::decimalFormat($arrayBoleto["desconto"]) : "";
		$arrayBoleto["data_processamento"] = date("d/m/Y");
		$arrayBoleto["nosso_numero_codigo_barras"] = $arrayBoleto['codigo_banco'] == 1 ? $arrayBoleto["nosso_numero"] : substr(trim($arrayBoleto["nosso_numero"]), 0, -1);
		$arrayBoleto["valor_codigo_barras"] = SystemHelper::formatarValorCodigoBarras($arrayBoleto["valor_cobrado"] != "" ? $arrayBoleto["valor_cobrado"] : $arrayBoleto["valor"], 10, 0, "valor");

		$arrayBoleto = array_merge($arrayBoleto, SystemConfig::getData($arrayBoleto['codigo_banco'] == 1 ? 'bb' : 'caixa'));
		$arrayBoleto['cnpjcpf'] = SystemHelper::maskValue(SystemConfig::getData('scm')['cnpjcpf'], '##.###.###/####-##') ;
		$arrayBoleto["agencia_codigo"] = "{$arrayBoleto["agencia"]}/{$arrayBoleto["codigo_cedente"]}-{$arrayBoleto["dv_codigo_cedente"]}";
		$arrayBoleto["fator_vencimento"] = SystemHelper::calcularFatorVencimento($arrayBoleto["data_vencimento"]);
		$arrayBoleto["endereco_beneficiario"] = strtoupper(SystemConfig::getData($_SESSION['_sistema'])['sva']['logradouro'] . ', ' . SystemConfig::getData($_SESSION['_sistema'])['sva']['numero'] . ' - '. SystemConfig::getData($_SESSION['_sistema'])['sva']['bairro'] . ' - ' . SystemConfig::getData($_SESSION['_sistema'])['sva']['localidade'] . '-' . SystemConfig::getData($_SESSION['_sistema'])['sva']['estado']);

		if($arrayBoleto['tipo'] === '0')
		{
			$arrayBoleto['instrucoes'][0] = 'SVA - SERV DE VALOR ADICIONADO:';
			$arrayBoleto['instrucoes'][1] = strtoupper(SystemConfig::getData($_SESSION["_sistema"])['sva']['nome']) . " - " . SystemConfig::getData('_imperatriz')['sva']['cnpjcpf'] . " - R$" . $arrayBoleto['vlrsva'];
			$arrayBoleto['instrucoes'][2] = 'SCM - SERV DE COMUNICAÇÃO MULTIMÍDIA:';
			$arrayBoleto['instrucoes'][3] = strtoupper(SystemConfig::getData('scm')['nome']) . " - " . SystemConfig::getData('scm')['cnpjcpf'] . " - R$" . $arrayBoleto['vlrscm'];

			if($arrayBoleto["formadepagamento"] != 0)
			{
				$arrayBoleto['instrucoes'][4] = ($arrayBoleto["meiodepagamento"] === 2) ? 'ÁREA DO CLIENTE: HTTP://WWW.JUPITER.COM.BR/AREADOCLIENTE' : '';
				$arrayBoleto['instrucoes'][5] = ($arrayBoleto["meiodepagamento"] === 2) ? 'JÚPITER INTERNET: ' . $arrayBoleto["endereco_beneficiario"] : '';
				$arrayBoleto['instrucoes'][6] = ($arrayBoleto["formadepagamento"] != 0) ? 'APÓS VENCIMENTO, COBRAR MULTA DE 2% E JUROS DE 1% AO MÊS' : '';
			}
			else
			{
				$arrayBoleto['instrucoes'][5] = 'BOLETO DE CONTRATO PRÉ-PAGO, APÓS O VENCIMENTO EMITIR NOVO DOCUMENTO';
				$arrayBoleto['instrucoes'][6] = 'SR CAIXA, NÃO RECEBER APÓS O VENCIMENTO';
			}

		}
		elseif($arrayBoleto['tipo'] === '4')
		{
			$arrayBoleto['instrucoes'][0] = 'BOLETO REFERENTE A SERVIÇO';
			$arrayBoleto['instrucoes'][6] = 'SR CAIXA, NÃO RECEBER APÓS O VENCIMENTO';
		}
		elseif($arrayBoleto['tipo'] === '9')
		{
			$arrayBoleto['instrucoes'][0] = 'BOLETO REFERENTE A SOLICITAÇÃO DE PEDIDO';
			$arrayBoleto['instrucoes'][6] = 'SR CAIXA, NÃO RECEBER APÓS O VENCIMENTO';
		}

		$this->arrayBoleto = $arrayBoleto;

		if($arrayBoleto['codigo_banco'] == 1)
			$arrayBoleto["codigo_barras"] = $this->retornarCodigoDeBarrasBB();
		else
		{
			if(isset($arrayBoleto["nosso_numero"][18]))
			{
				$arrayBoleto["codigo_barras"] = $this->retornarCodigoDeBarrasSICOB();
				$arrayBoleto["local_pagamento"] = $arrayBoleto["local_pagamento"];
			}
			else
			{
				$arrayBoleto["codigo_barras"] = $arrayBoleto["meiodepagamento"] === 2 ? $this->retornarCodigoDeBarrasCarne() : $this->retornarCodigoDeBarrasSIGCB();
				$arrayBoleto["local_pagamento"] = $arrayBoleto['meiodepagamento'] === 2 ? "PAGÁVEL COM CARTÃO DE CRÉDITO NA ÁREA DO CLIENTE OU NA JÚPITER INTERNET" : $arrayBoleto["local_pagamento"];
			}
		}

		if(strlen($arrayBoleto["codigo_barras"]) !== 44 && strlen($arrayBoleto["codigo_barras"]) !== 32)
			throw new Exception("Error Processing Request" . $arrayBoleto["codigo_barras"]);

		$arrayBoleto["cedente"] = strtoupper($arrayBoleto["cedente"]);
		if($arrayBoleto['codigo_banco'] == 104)
		{
			if(isset($arrayBoleto["nosso_numero"][18]))
				$arrayBoleto["carteira"] = $arrayBoleto["carteira"] === '1' ? "SR" : "CR";
			else
				$arrayBoleto["carteira"] = $arrayBoleto["carteira"] === '1' ? "RG" : "SR";

			$arrayBoleto["nosso_numero"]  = isset($arrayBoleto["nosso_numero"][18]) ? SystemHelper::maskValue($arrayBoleto["nosso_numero"], "##################-#") : SystemHelper::maskValue($arrayBoleto["nosso_numero"], "##/###############-#");
		}

		$arrayRecibo = [
			"id" => "NÚMERO DO DOCUMENTO",
			"data_vencimento" => "VENCIMENTO",
			"agencia_codigo" => "AGÊNCIA/CÓDIGO",
			"nosso_numero" => "NOSSO NÚMERO",
			"valor" => "( = ) VALOR DO DOCUMENTO",
			"desconto" => "( - ) DESCONTO",
			"juro" => "( + ) OUTROS ACRÉSCIMOS",
			"mora" => "( + ) MORA/MULTA",
			"valor_cobrado" => "( = ) VALOR COBRADO",
			"sacado" => "PAGADOR"
		];

		$arrayReciboCarne = [
			"id" => "NÚMERO DO DOCUMENTO",
			"data_vencimento" => "VENCIMENTO",
			"nosso_numero" => "NOSSO NÚMERO",
			"valor" => "( = ) VALOR DO DOCUMENTO",
			"desconto" => "( - ) DESCONTO",
			"juro" => "( + ) OUTROS ACRÉSCIMOS",
			"mora" => "( + ) MORA/MULTA",
			"valor_cobrado" => "( = ) VALOR COBRADO",
			"sacado" => "PAGADOR"
		];

		$arrayTitulosReciboRetrato = [
			"id" => "NÚMERO DO DOCUMENTO",
			"especie" => "ESPÉCIE",
			"quantidade" => "QTDE MOEDA",
			"data_vencimento" => "VENCIMENTO",
			"valor" => "VALOR DO DOCUMENTO",
			"nosso_numero" => "NOSSO NÚMERO",
			"desconto" => "( - ) DESCONTO/ABATIMENTO",
			"deducoes" => "( - ) OUTRAS DEDUÇÕES",
			"mora" => "( + ) MORA/MULTA",
			"juro" => "( + ) OUTROS ACRÉSCIMOS",
			"valor_cobrado" => "( = ) VALOR COBRADO",
			"cedente" => "BENEFICIÁRIO",
			"agencia_codigo" => "AGÊNCIA/CÓDIGO",
			"cnpjcpf" => "CPF/CNPJ DO BENEFICIÁRIO",
			"endereco_beneficiario" => "ENDEREÇO BENEFICIÁRIO",
			"sacado" => "PAGADOR"
		];

		$arrayLargurasReciboRetrato = [
			"id" => 35,
			"especie" => 20,
			"quantidade" => 25,
			"data_vencimento" => 34,
			"valor" => 36,
			"nosso_numero" => 40,
			"desconto" => 38,
			"deducoes" => 38,
			"mora" => 38,
			"juro" => 36,
			"valor_cobrado" => 40,
			"cedente" => 114,
			"agencia_codigo" => 36,
			"cnpjcpf" => 40,
			"endereco_beneficiario" => 190,
			"sacado" => 0
		];

		$arrayAlinhamentosReciboRetrato = [
			"id" => "R",
			"especie" => "L",
			"quantidade" => "L",
			"data_vencimento" => "L",
			"valor" => "R",
			"agencia_codigo" => "L",
			"nosso_numero" => "R",
			"desconto" => "R",
			"deducoes" => "R",
			"mora" => "R",
			"juro" => "R",
			"valor_cobrado" => "R",
			"cedente" => "L",
			"cnpjcpf" => "L",
			"endereco_beneficiario" => "L",
			"sacado" => "L"
		];

		$arrayBordasTitulosReciboRetrato = [
			"id" => "LR",
			"especie" => "R",
			"quantidade" => "",
			"data_vencimento" => "LR",
			"valor" => "R",
			"agencia_codigo" => "R",
			"nosso_numero" => "",
			"desconto" => "RL",
			"deducoes" => "R",
			"mora" => "R",
			"juro" => "R",
			"valor_cobrado" => "",
			"cedente" => "RL",
			"cnpjcpf" => "",
			"endereco_beneficiario" => "L",
			"sacado" => "L"
		];

		$arrayBordasValorReciboRetrato = [
			"id" => "BLR",
			"especie" => "RB",
			"quantidade" => "B",
			"data_vencimento" => "RBL",
			"valor" => "BR",
			"agencia_codigo" => "RB",
			"nosso_numero" => "B",
			"desconto" => "RBL",
			"deducoes" => "RB",
			"mora" => "RB",
			"juro" => "RB",
			"valor_cobrado" => "B",
			"cedente" => "RBL",
			"cnpjcpf" => "B",
			"endereco_beneficiario" => "BL",
			"sacado" => "L"
		];


		if($arrayBoleto["meiodepagamento"] === 2 && $arrayBoleto["nosso_numero"][0] === '1')
		{
			$this->boleto->SetLeftMargin(5);
			$this->boleto->SetX(5);
			$this->montarCarne($arrayBoleto, $arrayReciboCarne, $y);
		}
		else
		{
			if($layout === "P")
			{
				$this->boleto->SetLeftMargin(5);
				$this->boleto->SetX(5);
				$this->montarRecibo($arrayBoleto, $arrayRecibo, $y);
			}
			else
			{
				$this->header();
				$this->montarReciboRetrato($arrayBoleto, $arrayTitulosReciboRetrato, $arrayLargurasReciboRetrato, $arrayAlinhamentosReciboRetrato, $arrayBordasTitulosReciboRetrato, $arrayBordasValorReciboRetrato);
			}
		}


		$arrayTitulosFicha = [
			"local_pagamento" => "LOCAL DE PAGAMENTO",
			"data_vencimento" => "VENCIMENTO",
			"cedente" => "BENEFICIÁRIO",
			"agencia_codigo" => "AGÊNCIA/CÓDIGO",
			"data_emissao" => "DATA DOC",
			"id" => "NÚMERO DO DOC",
			"especie_doc" => "ESPÉCIE DOC.",
			"data_processamento" => "DATA PROCESSAMENTO",
			"nosso_numero" => "NOSSO NÚMERO",
			"banco" => "USO DO BANCO",
			"carteira" => "CARTEIRA",
			"especie" => "ESPÉCIE",
			"quantidade" => "QTDE MOEDA",
			"valor1" => "VALOR",
			"valor" => "( = ) VALOR DO DOCUMENTO"
		];

		$arrayTitulosFichaCarne = [
			"local_pagamento" => "LOCAL DE PAGAMENTO (NÃO É PAGÁVEL NA REDE BANCÁRIA)",
			"data_vencimento" => "VENCIMENTO",
			"cedente" => "BENEFICIÁRIO",
			"nosso_numero" => "NOSSO NÚMERO",
			"data_emissao" => "DATA DOC",
			"id" => "NÚMERO DO DOC",
			"especie_doc" => "ESPÉCIE DOC.",
			"data_processamento" => "DATA PROCESSAMENTO",
			"valor" => "( = ) VALOR DO DOCUMENTO"
		];

		$arrayLargurasFicha = [
			"local_pagamento" => 120,
			"data_vencimento" => 35,
			"cedente" => 120,
			"nosso_numero" => 35,
			"data_emissao" => 25,
			"id" => 27,
			"especie_doc" => 30,
			"data_processamento" => 38,
			"agencia_codigo" => 35,
			"banco" => 30,
			"carteira" => 15,
			"especie" => 20,
			"quantidade" => 30,
			"valor1" => 25,
			"valor" => 35
		];

		$arrayAlinhamentosFicha = [
			"local_pagamento" => "L",
			"data_vencimento" => "R",
			"cedente" => "L",
			"agencia_codigo" => "R",
			"data_emissao" => "L",
			"id" => "L",
			"especie_doc" => "R",
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
			"local_pagamento" => "R",
			"data_vencimento" => "L",
			"cedente" => "R",
			"agencia_codigo" => "T",
			"data_emissao" => "R",
			"id" => "R",
			"especie_doc" => "R",
			"data_processamento" => "R",
			"nosso_numero" => "",
			"banco" => "R",
			"carteira" => "R",
			"especie" => "R",
			"quantidade" => "R",
			"valor1" => "R",
			"valor" => "LT"
		];

		$arrayBordasValor = [
			"local_pagamento" => "RB",
			"data_vencimento" => "LB",
			"cedente" => "RB",
			"agencia_codigo" => "B",
			"data_emissao" => "RB",
			"id" => "RB",
			"especie_doc" => "RB",
			"data_processamento" => "RB",
			"nosso_numero" => "B",
			"banco" => "RB",
			"carteira" => "RB",
			"especie" => "RB",
			"quantidade" => "RB",
			"valor1" => "RB",
			"valor" => "BL"
		];

		$arrayTitulosFichaRetrato = [
			"local_pagamento" => "LOCAL DE PAGAMENTO",
			"data_vencimento" => "VENCIMENTO",
			"cedente" => "BENEFICIÁRIO",
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
			"quantidade" => "QTDE MOEDA",
			"valor1" => "VALOR",
			"valor" => "( = ) VALOR DO DOCUMENTO"
		];

		$arrayLargurasFichaRetrato = [
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

		$arrayAlinhamentosFichaRetrato = [
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

		$arrayBordasTituloRetrato = [
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

		$arrayBordasValorRetrato = [
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
			"desconto" => true
		];

		if($arrayBoleto["meiodepagamento"] === 2 && $arrayBoleto["nosso_numero"][0] === '1')
		{
			$this->boleto->SetLeftMargin(50);
			$this->boleto->SetX(5);
			$this->boleto->SetY($y);

			$this->montarCarneFichaCompensacao($arrayBoleto, $arrayTitulosFichaCarne, $arrayLargurasFicha, $arrayAlinhamentosFicha, $arrayBordasTitulo, $arrayBordasValor, $arrayFill, $y);

		}
		else
		{

			if($layout === "P")
			{
				$this->boleto->SetLeftMargin(50);
				$this->boleto->SetX(5);
				$this->boleto->SetY($y);
			}

			if($layout === "P")
				$this->montarFichaCompensacao($arrayBoleto, $arrayTitulosFicha, $arrayLargurasFicha, $arrayAlinhamentosFicha, $arrayBordasTitulo, $arrayBordasValor, $arrayFill, $y);
			else
				$this->montarFichaCompensacaoRetrato($arrayBoleto, $arrayTitulosFichaRetrato, $arrayLargurasFichaRetrato, $arrayAlinhamentosFichaRetrato, $arrayBordasTituloRetrato, $arrayBordasValorRetrato, $arrayFill, $y);
			
		}


		// $x = $this->boleto->getX();
		$y = $this->boleto->getY();

	}

	private function retornarCodigoDeBarrasCarne()
	{
		return "{$this->arrayBoleto["fator_vencimento"]}{$this->arrayBoleto["valor_codigo_barras"]}{$this->arrayBoleto["nosso_numero"]}";
	}

	private function retornarCodigoDeBarrasSICOB()
	{
		$dv = SystemHelper::calcularDigitoVerificadorBarra("{$this->arrayBoleto["codigo"]}{$this->arrayBoleto["moeda"]}{$this->arrayBoleto["fator_vencimento"]}{$this->arrayBoleto["valor_codigo_barras"]}{$this->arrayBoleto["carteira"]}{$this->arrayBoleto["codigo_cedente"]}{$this->arrayBoleto["nosso_numero_codigo_barras"]}");
		return "{$this->arrayBoleto["codigo"]}{$this->arrayBoleto["moeda"]}{$dv}{$this->arrayBoleto["fator_vencimento"]}{$this->arrayBoleto["valor_codigo_barras"]}{$this->arrayBoleto["carteira"]}{$this->arrayBoleto["codigo_cedente"]}{$this->arrayBoleto["nosso_numero_codigo_barras"]}";
	}

	private function retornarCodigoDeBarrasSIGCB()
	{
		$campoLivre  = "{$this->arrayBoleto["codigo_cedente"]}{$this->arrayBoleto["dv_codigo_cedente"]}".substr($this->arrayBoleto["nosso_numero"], 2, 3)."{$this->arrayBoleto["carteira"]}".substr($this->arrayBoleto["nosso_numero"], 5, 3).substr($this->arrayBoleto["nosso_numero"], 1, 1).substr($this->arrayBoleto["nosso_numero"], 8, 9);
		$campoLivre .= SystemHelper::modulo_11($campoLivre);

		$dv = SystemHelper::calcularDigitoVerificadorBarra("{$this->arrayBoleto["codigo"]}{$this->arrayBoleto["moeda"]}{$this->arrayBoleto["fator_vencimento"]}{$this->arrayBoleto["valor_codigo_barras"]}{$campoLivre}");

		return "{$this->arrayBoleto["codigo"]}{$this->arrayBoleto["moeda"]}{$dv}{$this->arrayBoleto["fator_vencimento"]}{$this->arrayBoleto["valor_codigo_barras"]}{$campoLivre}";
	}

	private function retornarCodigoDeBarrasBB()
	{
		$codigoDeBarras = "{$this->arrayBoleto["codigo"]}{$this->arrayBoleto["moeda"]}%s{$this->arrayBoleto["fator_vencimento"]}{$this->arrayBoleto["valor_codigo_barras"]}000000{$this->arrayBoleto["nosso_numero"]}{$this->arrayBoleto["carteira"]}";
		$dv = SystemHelper::calcularDigitoVerificadorBarra(sprintf($codigoDeBarras, ''));
		return sprintf($codigoDeBarras, $dv);
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

	public function montarCelulasRetrato(array $lista, array $titulos, array $larguras, array $alinhamentos, array $bordasTitulo, array $bordasValor, $fill = false){
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

	public function montarCelulas(array $lista, array $titulos, array $larguras, array $alinhamentos, array $bordasTitulo, array $bordasValor, array $fill){
		foreach ($titulos AS $chave => $valor) 
		{   
			$w = $larguras[$chave];
			$x = $this->boleto->getX();
			$y = $this->boleto->getY();
			$linha =+ $x;

			if ($linha >= 190.00125) {
				$linha = 0;
				$y += 6;
				$this->boleto->SetY($y);              
				$x = $this->boleto->getX();
			}

			$this->boleto->setFillColor(190, 190, 190);
			$this->boleto->setFont('Arial', 'B', 5);
			$this->boleto->Cell($w, 3, $titulos[$chave], $bordasTitulo[$chave], 2, "L", $fill[$chave]);
			$this->boleto->setFont('Arial', '', 7);
			$this->boleto->Cell($w, 3,  $lista[$chave], $bordasValor[$chave], 1 , $alinhamentos[$chave], $fill[$chave]);

			$x = $x+$w; 
			$this->boleto->SetY($y);
			$this->boleto->SetX($x);
		}
	}

	public function montarCarne(array $lista, array $titulos, $y)
	{

		// $this->boleto->Cell(25, 6, '', 'B');
		// $this->boleto->Image('imagens/logo_boleto.jpg', 7, $y, 7, 5);

		// $this->boleto->setFont('Arial', 'B', 12);
		// $this->boleto->Cell(15, 6, '', 'B', 1, 'C');

		foreach ($titulos AS $chave => $valor) 
		{
			$this->boleto->setFont('Arial', 'B', 5);
			$this->boleto->Cell(40, 3, $valor, "", 2, "L");
			$this->boleto->setFont('Arial', '', 7);
			$this->boleto->Cell(40, 3, ($chave == 'sacado' ? substr($lista[$chave], 0, 25) : $lista[$chave]), "B", 1, ($chave == 'sacado') ? 'L' : 'R');
		}

		$this->boleto->ln();

		$this->boleto->setFont('Arial', 'B', 6);
		$this->boleto->Cell(40, 1, "RECIBO DO PAGADOR", "", 1, "L");

	}

	public function montarRecibo(array $lista, array $titulos, $y)
	{

		$this->boleto->Cell(25, 6, '', 'RB');
		$this->boleto->Image($lista['logo'], 7, $y, 20, 5);

		$this->boleto->setFont('Arial', 'B', 12);
		// $this->boleto->Cell(15, 3, "Banco", "", 2, "C");
		$this->boleto->Cell(15, 6, $lista['codigo'].'-'.SystemHelper::modulo_11($lista['codigo']), "B", 1, "C");

		foreach ($titulos AS $chave => $valor) 
		{
			$this->boleto->setFont('Arial', 'B', 5);
			$this->boleto->Cell(40, 3, $valor, "", 2, "L");
			$this->boleto->setFont('Arial', '', 7);
			$this->boleto->Cell(40, 3, ($chave == 'sacado' ? substr($lista[$chave], 0, 25) : $lista[$chave]), "B", 1, ($chave == 'sacado') ? 'L' : 'R');
		}

		$this->boleto->ln();

		$this->boleto->setFont('Arial', 'B', 6);
		$this->boleto->Cell(40, 1, "RECIBO DO PAGADOR", "", 1, "L");

	}

	public function montarCarneFichaCompensacao(array $lista, array $titulos, array $larguras, array $alinhamentos, array $bordasTitulo,  array $bordasValor, array $fill, $y)
	{

		$this->montarCelulas(
			$lista,
			$titulos,
			$larguras,
			$alinhamentos,
			$bordasTitulo,
			$bordasValor,
			$fill
		);

		$this->boleto->ln(6);

		$this->boleto->setFont('Arial', 'B', 5);
		$this->boleto->Cell(120, 3, "Instruções (Texto de Responsabilidade do Beneficiário)", "", 0, "L");
		$this->boleto->setFont('Arial', 'B', 5);
		$this->boleto->Cell(35, 3, "( - ) DESCONTO/ABATIMENTO", "L", 1, "L", ($lista['desconto'] != ""));

		$this->boleto->setFont('Arial', 'B', 5);
		$this->boleto->Cell(120, 3, $lista['instrucoes'][0], "", 0, "L");

		$this->boleto->setFont('Arial', '', 7);
		$this->boleto->Cell(35, 3, $lista['desconto'], "BL", 1, "R", ($lista['desconto'] != ""));

		$this->boleto->setFont('Arial', 'B', 5);
		$this->boleto->Cell(120, 3, $lista['instrucoes'][1], "", 0, "L");

		$this->boleto->setFont('Arial', 'B', 5);
		$this->boleto->Cell(35, 3, "( + ) OUTROS ACRÉSCIMOS", "L", 1, "L", ($lista['juro'] != ""));

		$this->boleto->setFont('Arial', 'B', 5);
		$this->boleto->Cell(120, 3, $lista['instrucoes'][2], "", 0, "L");

		$this->boleto->setFont('Arial', '', 7);
		$this->boleto->Cell(35, 3, $lista["juro"], "BL", 1, "R", ($lista['juro'] != ""));

		$this->boleto->setFont('Arial', 'B', 5);
		$this->boleto->Cell(120, 3, $lista['instrucoes'][3], "", 0, "L");
		$this->boleto->setFont('Arial', 'B', 5);
		$this->boleto->Cell(35, 3, "( + ) MORA/MULTA", "L", 1, "L", ($lista['mora'] != ""));

		$this->boleto->setFont('Arial', 'B', 7);
		$this->boleto->Cell(120, 3, $lista['instrucoes'][4], "R", 0, "L");
		$this->boleto->setFont('Arial', '', 7);
		$this->boleto->Cell(35, 3, $lista["mora"], "B", 1, "R", ($lista['mora'] != ""));
		$this->boleto->setFont('Arial', 'UB', 7);
		$this->boleto->Cell(120, 3, $lista['instrucoes'][5], "", 0, "L");
		$this->boleto->setFont('Arial', 'B', 5);
		$this->boleto->Cell(35, 3, "( = ) VALOR COBRADO", "LT", 1, "L", ($lista['valor_cobrado'] != ""));
		$this->boleto->setFont('Arial', 'UB', 7);
		$this->boleto->Cell(120, 3, $lista['instrucoes'][6], "B", 0, "L");

		$this->boleto->setFont('Arial', '', 7);
		$this->boleto->Cell(35, 3, $lista['valor_cobrado'], "LB", 1, "R", ($lista['valor_cobrado'] != ""));

		$this->boleto->setFont('Arial', 'B', 5);
		$this->boleto->multicell(155, 3, "SACADO", "");
		$this->boleto->setFont('Arial', '', 7);
		$this->boleto->multicell(155, 3, strtoupper("{$lista['contrato']} - {$lista['sacado']}\n".substr($lista['endereco'], 0, 60)." - {$lista['localizacao']}"), "B");

		$yBarcode = $this->boleto->getY();

		$this->boleto->Cell(25, 7, '', '');
		$this->boleto->Image("http://localhost/api/utils/Barcode.php?n={$lista['codigo_barras']}&extensao=.png", 50, $yBarcode+2, 130, 10);
		$yBarcode = $this->boleto->getY();
		$this->boleto->setY($yBarcode);
		$this->boleto->setX(165);
		$this->boleto->Cell(105, 3, "Autenticação Mecânica", 0, 2, "L");
		$this->boleto->Cell(50, 3, "Ficha Compensação", 0, 1, "L");

		$this->boleto->ln(6);
		$this->boleto->SetX(3);
		for ($i=0; $i < 289; $i++)
			$this->boleto->Cell(0.7, 1, ".", 0, 0);
		$this->boleto->ln(4);

	}

	public function montarFichaCompensacao(array $lista, array $titulos, array $larguras, array $alinhamentos, array $bordasTitulo,  array $bordasValor, array $fill, $y)
	{

		$this->boleto->Cell(25, 6, '', 'RB');
		$this->boleto->Image($lista['logo'], 52, $y, 20, 5);

		$this->boleto->setFont('Arial', 'B', 12);
		$this->boleto->Cell(15, 6, $lista['codigo'].'-'.SystemHelper::modulo_11($lista['codigo']), "BR", 0, "C");

		$this->boleto->setFont('Arial', '', 10);
		$this->boleto->Cell(115, 6, SystemHelper::montarLinhaDigitavel($lista["codigo_barras"]), "B", 1, "R");

		$this->montarCelulas(
			$lista,
			$titulos,
			$larguras,
			$alinhamentos,
			$bordasTitulo,
			$bordasValor,
			$fill
		);

		$this->boleto->ln(6);

		$this->boleto->setFont('Arial', 'B', 5);
		$this->boleto->Cell(120, 3, "Instruções (Texto de Responsabilidade do Beneficiário)", "", 0, "L");
		$this->boleto->setFont('Arial', 'B', 5);
		$this->boleto->Cell(35, 3, "( - ) DESCONTO/ABATIMENTO", "L", 1, "L", ($lista['desconto'] != ""));

		$this->boleto->setFont('Arial', 'B', 5);
		$this->boleto->Cell(120, 3, $lista['instrucoes'][0], "", 0, "L");

		$this->boleto->setFont('Arial', '', 7);
		$this->boleto->Cell(35, 3, $lista['desconto'], "BL", 1, "R", ($lista['desconto'] != ""));

		$this->boleto->setFont('Arial', 'B', 5);
		$this->boleto->Cell(120, 3, $lista['instrucoes'][1], "", 0, "L");

		$this->boleto->setFont('Arial', 'B', 5);
		$this->boleto->Cell(35, 3, "( + ) OUTROS ACRÉSCIMOS", "L", 1, "L", ($lista['juro'] != ""));

		$this->boleto->setFont('Arial', 'B', 5);
		$this->boleto->Cell(120, 3, $lista['instrucoes'][2], "", 0, "L");

		$this->boleto->setFont('Arial', '', 7);
		$this->boleto->Cell(35, 3, $lista["juro"], "BL", 1, "R", ($lista['juro'] != ""));

		$this->boleto->setFont('Arial', 'B', 5);
		$this->boleto->Cell(120, 3, $lista['instrucoes'][3], "", 0, "L");
		$this->boleto->setFont('Arial', 'B', 5);
		$this->boleto->Cell(35, 3, "( + ) MORA/MULTA", "L", 1, "L", ($lista['mora'] != ""));

		$this->boleto->setFont('Arial', 'B', 7);
		$this->boleto->Cell(120, 3, $lista['instrucoes'][4], "R", 0, "L");
		$this->boleto->setFont('Arial', '', 7);
		$this->boleto->Cell(35, 3, $lista["mora"], "B", 1, "R", ($lista['mora'] != ""));
		$this->boleto->Cell(120, 3, $lista['instrucoes'][5], "", 0, "L");
		$this->boleto->setFont('Arial', 'B', 5);
		$this->boleto->Cell(35, 3, "( = ) VALOR COBRADO", "LT", 1, "L", ($lista['valor_cobrado'] != ""));
		$this->boleto->setFont('Arial', 'B', 7);
		$this->boleto->Cell(120, 3, $lista['instrucoes'][6], "B", 0, "L");

		$this->boleto->setFont('Arial', '', 7);
		$this->boleto->Cell(35, 3, $lista['valor_cobrado'], "LB", 1, "R", ($lista['valor_cobrado'] != ""));

		$this->boleto->setFont('Arial', '', 7);
		$this->boleto->multicell(155, 3, "Sacado\n{$lista['contrato']} - {$lista['sacado']}\n{$lista['endereco']} - {$lista['localizacao']}\nSacador/Avalista", "B");

		$yBarcode = $this->boleto->getY();

		$this->boleto->Cell(25, 7, '', '');
		$this->boleto->Image("http://localhost/api/utils/Barcode.php?n={$lista['codigo_barras']}&extensao=.png", 50, $yBarcode+2, 130, 12);
		$yBarcode = $this->boleto->getY();
		$this->boleto->setY($yBarcode);
		$this->boleto->setX(165);
		$this->boleto->Cell(105, 3, "Autenticação Mecânica", 0, 2, "L");
		$this->boleto->Cell(50, 3, "Ficha Compensação", 0, 1, "L");

		$this->boleto->ln(11);
		$this->boleto->SetX(3);
		for ($i=0; $i < 289; $i++)
			$this->boleto->Cell(0.7, 1, ".", 0, 0);
		$this->boleto->ln(4);

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
		$this->boleto->Cell(0, 4, "RECIBO DO PAGADOR", 0, 0, "R");
		$this->boleto->ln(4);

		$y = $this->boleto->getY();

		$this->boleto->Cell(25, 9, '', 'RB');
		$this->boleto->Image($lista['logo'], 11, $y+1, 22, 6);

		$this->boleto->setFont('Arial', 'B', 16);
		$this->boleto->Cell(17, 9, $lista['codigo'].'-'.SystemHelper::modulo_11($lista['codigo']), "BR", 0, "C");

		$this->boleto->setFont('Arial', '', 13);
		$this->boleto->Cell(148, 9, SystemHelper::montarLinhaDigitavel($lista["codigo_barras"]), "B", 1, "R");
		$this->montarCelulasRetrato(
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
		$this->boleto->Cell(150, 3, "Demonstrativo", "", 0, "L");
		$this->boleto->Cell(40, 3, "Autenticação mecânica", "", 1, "R");

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
		$this->boleto->Image($lista['logo'], 11, $y+1, 22, 6);

		$this->boleto->setFont('Arial', 'B', 16);
		$this->boleto->Cell(17, 9, $lista['codigo'].'-'.SystemHelper::modulo_11($lista['codigo']), "BR", 0, "C");

		$this->boleto->setFont('Arial', '', 13);
		$this->boleto->cell(148, 9, SystemHelper::montarLinhaDigitavel($lista["codigo_barras"]), "B", 1, "R");

		$this->montarCelulasRetrato(
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
		$this->boleto->Cell(150, 3.5, "Instruções (Texto de Responsabilidade do Beneficiário)", "L", 0, "L");
		$this->boleto->setFont('Arial', 'B', 6);
		$this->boleto->Cell(40, 3.5, "( - ) DESCONTO/ABATIMENTO", "L", 1, "L", ($lista['desconto'] != ""));

		$this->boleto->setFont('Arial', 'B', 5);
		$this->boleto->Cell(150, 3.5, $lista['instrucoes'][0], "L", 0, "L");

		$this->boleto->setFont('Arial', '', 7);
		$this->boleto->Cell(40, 3.5, $lista['desconto'], "BL", 1, "R", ($lista['desconto'] != ""));

		$this->boleto->setFont('Arial', 'B', 5);
		$this->boleto->Cell(150, 3.5, $lista['instrucoes'][1], "L", 0, "L");

		$this->boleto->setFont('Arial', 'B', 6);
		$this->boleto->Cell(40, 3.5, "( + ) OUTROS ACRÉSCIMOS", "L", 1, "L", ($lista['juro'] != ""));

		$this->boleto->setFont('Arial', 'B', 5);
		$this->boleto->Cell(150, 3.5, $lista['instrucoes'][2], "L", 0, "L");

		$this->boleto->setFont('Arial', '', 7);
		$this->boleto->Cell(40, 3.5, $lista['juro'], "BL", 1, "R", ($lista['juro'] != ""));

		$this->boleto->setFont('Arial', 'B', 5);
		$this->boleto->Cell(150, 3.5, $lista['instrucoes'][3], "L", 0, "L");
		$this->boleto->setFont('Arial', 'B', 6);
		$this->boleto->Cell(40, 3.5, "( + ) MORA/MULTA", "L", 1, "L", ($lista['mora'] != ""));

		$this->boleto->setFont('Arial', 'B', 7);
		$this->boleto->Cell(150, 3.5, $lista['instrucoes'][4], "RL", 0, "L");
		$this->boleto->setFont('Arial', '', 7);
		$this->boleto->Cell(40, 3.5, $lista['mora'], "B", 1, "R", ($lista['mora'] != ""));
		$this->boleto->Cell(150, 3.5, $lista['instrucoes'][5], "L", 0, "L");
		$this->boleto->setFont('Arial', 'B', 6);
		$this->boleto->Cell(40, 3.5, "( = ) VALOR COBRADO", "LT", 1, "L", ($lista['valor_cobrado'] != ""));
		$this->boleto->setFont('Arial', 'B', 7);
		$this->boleto->Cell(150, 3.5, $lista['instrucoes'][6], "BL", 0, "L");

		$this->boleto->setFont('Arial', '', 7);
		$this->boleto->Cell(40, 3.5, $lista['valor_cobrado'], "LB", 1, "R", ($lista['valor_cobrado'] != ""));

		$this->boleto->setFont('Arial', 'B', 6);
		$this->boleto->cell(150, 3.5, "PAGADOR", "RL", 0, "L");

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