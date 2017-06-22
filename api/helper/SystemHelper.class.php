<?php

class SystemHelper
{

	public static function gerarToken($lenght){
		$rand = array(array(48, 57), array(65, 90), array(97, 122));
		$a = "";
		while(@$i++ < $lenght){
			$array = mt_rand(0, 2);
			$a .= @chr(mt_rand($rand[$array][0], $rand[$array][1]));
		}
		return $a;
	}

	public static function retornarValorAtualBoletoInternet($valor, $vencimento)
	{
		$vencimento = SystemHelper::formatDate($vencimento, 'd/m/Y', 'Y-m-d');
		if(!SystemHelper::verificarDiaUtil($vencimento))
			$vencimento = SystemHelper::retornarProximoDiaUtil($vencimento);

		if($vencimento < date("Y-m-d"))
		{
			$juros = SystemHelper::calcularJuroBoleto($valor, $vencimento);
			$mora  = $valor * 0.02;
			$valor = $valor + $juros + $valor;
		}

		return $valor;		
	}

	public static function stringToPgArray($string)
	{
		$valor = array('["', '"]');
		$valor1 = array("{{", "}}");
		$novaString = str_replace($valor, $valor1, $string);

		return $novaString;
	}

	public static function arrayPHPToPgArray($pgsqlArr)
	{
		$resultado = "";
		foreach($pgsqlArr as $key => $value)
		{
			$resultado .= "{\"".$key."\",\"".$value."\"},";
		}
		return "{".substr($resultado,0,-1)."}";
	}

	public static function trimValueArray(&$value)
	{
		$value = trim($value);
	}

	public static function toPHPArray($pgsqlArr)
	{
        preg_match('/^{(.*)}$/', $pgsqlArr, $matches);
        $chaves = [];
        $valores = [];
        $pgsqlArr = str_getcsv($matches[1]);
        foreach($pgsqlArr as $key => $value)
        {
                if($key%2==0)
                    $chaves[] = substr($value, 1);
                else
                    $valores[] = substr($value, 0, -1);
        }
        return count($chaves) == count($valores) ? array_combine($chaves, $valores) : [];
	}

    public static function array_column(array $array, $columnKey, $indexKey = null)
    {
        $result = [];
        foreach($array as $subArray)
        {
            if(!is_array($subArray))
                continue;
            elseif (is_null($indexKey) && array_key_exists($columnKey, $subArray))
                $result[] = $subArray[$columnKey];
            elseif (array_key_exists($indexKey, $subArray))
            {
                if(is_null($columnKey))
                    $result[$subArray[$indexKey]] = $subArray;
                elseif (array_key_exists($columnKey, $subArray))
                    $result[$subArray[$indexKey]] = $subArray[$columnKey];
            }
        }
        return $result;
    }

	public static function verificarDiaUtil($data) {
		$db = DB::getConection();
		$data = date("Y-m-d", strtotime($data));
		return !($db->query("SELECT * FROM vr_feriados WHERE data = '{$data}'")->rowCount() > 0 || date("w", strtotime($data)) == 0 || date("w", strtotime($data)) == 6);
	}

	public static function retornarProximoDiaUtil($data)
	{
		$data = date("Y-m-d", strtotime($data)+(24*60*60));
		$db = DB::getConection();
		$stmt = $db->query("SELECT * FROM vr_feriados WHERE data = '{$data}'");
		if($stmt->rowCount() > 0 || date("w", strtotime($data)) == 0 || date("w", strtotime($data)) == 6)
		    return SystemHelper::retornarProximoDiaUtil($data);
		else
		    return $data;
	}

	public static function calcularJuroBoleto($valor, $vencimento, $dataReferencia = null)
	{
		$dataReferencia = ($dataReferencia === null) ? date("Y-m-d") : $dataReferencia;
		if($vencimento < $dataReferencia)
		{
			$dataReferencia = new DateTime($dataReferencia);
			$vencimento     = new DateTime($vencimento);
			$intervalo      = $dataReferencia->diff($vencimento);
			return ($valor*(pow(1+1/3000, $intervalo->days)))-$valor;
		}
	}

	public static function retornarNumeroPorExtenso($valor = 0, $maiusculas = false)
	{
		// verifica se tem virgula decimal
		if (strpos($valor,",") > 0)
		{
		  // retira o ponto de milhar, se tiver
		  $valor = str_replace(".","",$valor);

		  // troca a virgula decimal por ponto decimal
		  $valor = str_replace(",",".",$valor);
		}

			$singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
			$plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");

			$c = array("", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
			$d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa");
			$d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove");
			$u = array("", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");

			$z=0;

			$valor = number_format($valor, 2, ".", ".");
			$inteiro = explode(".", $valor);
			for($i=0;$i<count($inteiro);$i++)
					for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
							$inteiro[$i] = "0".$inteiro[$i];

			$rt = "";
			$fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
			for ($i=0;$i<count($inteiro);$i++) {
					$valor = $inteiro[$i];
					$rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
					$rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
					$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";
					$r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd && $ru) ? " e " : "").$ru;
					$t = count($inteiro)-1-$i;
					$r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
					if ($valor == "000")$z++; elseif ($z > 0) $z--;
					if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t];
					if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
			}

			if(!$maiusculas)
				return trim($rt ? $rt : "zero");
			elseif($maiusculas == "2")
				return trim(strtoupper($rt) ? strtoupper($rt) : "Zero");
			else
				return trim(ucwords($rt) ? ucwords($rt) : "Zero");
	}

	public static function decimalFormat($numeric, $decimal = ',', $thousand = '.', $decimais = 2)
	{
		if(is_numeric($numeric))
		{
			$numeric = (float) $numeric;
			$numeric = (string) number_format($numeric, $decimais, $decimal, $thousand);
		}
		return $numeric;
	}

	public static function arrayToJSON($array = array())
	{
		if(is_array($array))
		{
			array_walk_recursive($array, function(&$value){
				$value = utf8_encode($value);
			});
		}
		return json_encode($array);
	}

	public static function formatDate($date, $formatDate = 'd/m/Y h:m:s', $newFormatDate = 'Y-m-d h:m:s')
	{
		$objDate = DateTime::createFromFormat($formatDate, $date);
		return $objDate->format($newFormatDate);
	}

	public static function contarDiasComerciaisEntreDatas(DateTime $dataInicio, DateTime $dataFim)
	{

		if($dataInicio->format('d') == '31')
			$dataInicio->modify('+1 day');
		if($dataFim->format('d') == '31')
			$dataFim->modify('+1 day');

		$intervalo = $dataFim->diff($dataInicio);

		$mesesCorridos = ((date('mt', strtotime($dataFim->format('Y-m-d'))) == $dataFim->format('md') &&  $dataInicio->format('md') === '0130') || (date('mt', strtotime($dataInicio->format('Y-m-d'))) == $dataInicio->format('md') && $dataFim->format('md') === '0330')) ? 1 : $intervalo->m + ($intervalo->y * 12);
		$diaInicial    = date('mt', strtotime($dataInicio->format('Y-m-d'))) == $dataInicio->format('md') ? 30 : $dataInicio->format('d');
		$diaFinal      = date('mt', strtotime($dataFim->format('Y-m-d'))) == $dataFim->format('md') ? 30 : $dataFim->format('d');

		$diasNoMes = ($mesesCorridos * 30);
		if($diaInicial < $diaFinal)
			$diasNoMes += abs($diaInicial - $diaFinal);
		elseif($diaInicial > $diaFinal)
			$diasNoMes += (30 - abs($diaInicial - $diaFinal));

		return $diasNoMes;		
	}

	public static function calcularDiasProporcionais($contrato, $dataVencimento, $verificarDataAtual = false)
	{

		$db = DB::getConection();

		$arrayContrato = $db->query("SELECT planos.formadepagamento, contratos.data FROM contratos INNER JOIN planos ON (contratos.plano = planos.id) WHERE contratos.id = {$contrato}")->fetch(PDO::FETCH_ASSOC);
		$formaDePagamento  = $arrayContrato["formadepagamento"];

		$time = ($_SESSION["_sistema"] == "_acailandia") ? 2*3600 : 3*3600;
		$registroProximaFatura  = $db->query("SELECT z.timestamp_vencimento, z.numero_prestacao FROM (SELECT rank() OVER (PARTITION BY contrato ORDER BY timestamp_vencimento ASC) AS numero_prestacao, id, contrato, avulso, tipo, (CASE WHEN vencimento_original IS NULL THEN timestamp_vencimento ELSE EXTRACT('epoch' FROM vencimento_original)+{$time} END) AS timestamp_vencimento FROM boletos WHERE tipo = '0') AS z WHERE z.contrato = {$contrato} AND z.avulso = false AND z.tipo = '0' AND z.timestamp_vencimento > " . strtotime($dataVencimento) . " ORDER BY z.timestamp_vencimento ASC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
		$registroAnteriorFatura = $db->query("SELECT z.timestamp_vencimento, z.numero_prestacao FROM (SELECT rank() OVER (PARTITION BY contrato ORDER BY timestamp_vencimento ASC) AS numero_prestacao, id, contrato, avulso, tipo, (CASE WHEN vencimento_original IS NULL THEN timestamp_vencimento ELSE EXTRACT('epoch' FROM vencimento_original)+{$time} END) AS timestamp_vencimento FROM boletos WHERE tipo = '0') AS z WHERE z.contrato = {$contrato} AND z.avulso = false AND z.tipo = '0' AND z.timestamp_vencimento < " . strtotime($dataVencimento) . " ORDER BY z.timestamp_vencimento DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);

		if($formaDePagamento != 0) // pós-pago
		{
			$intDataInicio = $db->query("SELECT timestamp FROM acoes WHERE acao = 212 AND objeto = {$contrato} ORDER BY timestamp ASC LIMIT 1")->fetch(PDO::FETCH_ASSOC)["timestamp"];
			if($intDataInicio == "")
			{
				$previsao      = $db->query("SELECT previsao FROM ordemdeservico WHERE (servico = 5 OR servico = 4) AND contrato = {$contrato} ORDER BY id ASC LIMIT 1")->fetch(PDO::FETCH_ASSOC)['previsao'];
				$intDataInicio = !empty($previsao) ? strtotime($previsao) : strtotime((new DateTime($dataVencimento))->modify('-1 month')->format('Y-m-d'));
			}

			$dataInicio = new DateTime(date("Y-m-d", $registroAnteriorFatura['timestamp_vencimento'] ?:  $intDataInicio));
			$dataFim    = new DateTime($dataVencimento);

		}
		else
		{

			$dataInicio     = new DateTime($dataVencimento);
			$dataInstalacao = new DateTime($db->query("SELECT previsao FROM ordemdeservico WHERE (servico = 5 OR servico = 4) AND contrato = {$contrato} ORDER BY id ASC LIMIT 1")->fetch(PDO::FETCH_ASSOC)['previsao'] ?: $arrayContrato['data']);
			$diasParaInstalacao = self::contarDiasComerciaisEntreDatas($dataInstalacao, $dataInicio);

			if($dataInicio->format('Y-m-d') == $dataInstalacao->format('Y-m-d'))
				$numeroDestaPrestacao = 1;
			elseif(self::contarDiasComerciaisEntreDatas($dataInstalacao, $dataInicio) < 60)
				$numeroDestaPrestacao = 2;

			$intDataFim = $numeroDestaPrestacao == 2 && $diasParaInstalacao < 30 ? ($registroAnteriorFatura["timestamp_vencimento"] ?: strtotime($dataInstalacao->format('Y-m-d'))) : $registroProximaFatura["timestamp_vencimento"];
			if($intDataFim == "")
				$intDataFim = strtotime((new DateTime($dataVencimento))->modify('+1 month')->format('Y-m-d'));

			$dataFim = new DateTime(date("Y-m-d", $intDataFim));
			if($dataFim->format('Y-m-d') < $dataInicio->format('Y-m-d'))
			{
				$aux = $dataInicio;
				$dataInicio = $dataFim;
				$dataFim = $aux;
			}

		}

		$arrayValorDiario  = self::calcularValorDiarioContratoNoPeriodo($contrato, $dataInicio, $dataFim, $verificarDataAtual);

		$arrayValor        = $arrayValorDiario['array-dias-ativos'];
		$arrayDesconto     = $arrayValorDiario['array-dias-inativos'];

		$diasNoMes = self::contarDiasComerciaisEntreDatas($dataInicio, $dataFim);
		// Primeira fatura pré-pago
		if($formaDePagamento == 0 && isset($numeroDestaPrestacao) && $numeroDestaPrestacao == 1 && $diasNoMes < 30)
		{
			$diferencaDias = 30 - $diasNoMes;
			while($diferencaDias-- != 0)
				array_push($arrayValor, $arrayValor[count($arrayValor)-1]);
		}

		return ["valor" => array_sum($arrayValor)+array_sum($arrayDesconto), "desconto" => array_sum($arrayDesconto), "dias-inativo" => count($arrayDesconto), "dias-ativo" => count($arrayValor)];

	}

	public static function calcularValorDiarioContratoNoPeriodo($contrato, DateTime $dataInicio, DateTime $dataFim, $verificarDataAtual = false)
	{
		$db = DB::getConection();

		$arrayValor    = [];
		$arrayDesconto = [];

		$previsao   = $db->query("SELECT previsao FROM ordemdeservico WHERE (servico = 5 OR servico = 4) AND contrato = {$contrato} ORDER BY id ASC LIMIT 1")->fetch(PDO::FETCH_ASSOC)['previsao'];
		if(SystemHelper::validateDate($previsao) === false)
			$previsao = $db->query("SELECT data FROM contratos WHERE id = {$contrato}")->fetch(PDO::FETCH_ASSOC)['data'];

		$rangeDatas = new DatePeriod($dataInicio, new DateInterval('P1D'), $dataFim);
		foreach($rangeDatas AS $chave => $data)
		{
			if($data->format('d') == '31')
				continue;

			$tipo = (int) $db->query("SELECT tipo FROM histdesativacao WHERE contrato = {$contrato} AND data <= " . strtotime($data->format("Y-m-d")) . " ORDER BY Data DESC, Id DESC")->fetch(PDO::FETCH_ASSOC)["tipo"];
			if((SystemHelper::validateDate($previsao) === true && $previsao <= $data->format("Y-m-d") && $tipo === 2) || ($verificarDataAtual === true && $data->format("Y-m-d") > date("Y-m-d")))
			{
				$arrayValor[] = $db->query("SELECT planos.valor FROM historico_contratos INNER JOIN planos ON (historico_contratos.plano = planos.id) WHERE historico_contratos.id = {$contrato} AND to_char(historico_contratos.dataocorrencia, 'YYYY-MM-DD') " . ($previsao === $data->format("Y-m-d") ? '<=' : '<') . " '{$data->format("Y-m-d")}' ORDER BY historico_contratos.dataocorrencia DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC)["valor"]/30;
				$flag = true;
			}
			else
			{
				$arrayDesconto[] = $db->query("SELECT planos.valor FROM historico_contratos INNER JOIN planos ON (historico_contratos.plano = planos.id) WHERE historico_contratos.id = {$contrato} AND historico_contratos.dataocorrencia <= '{$data->format("Y-m-d")}' ORDER BY historico_contratos.dataocorrencia DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC)["valor"]/30;
				$flag = false;
			}

			if(date('mt', strtotime($dataInicio->format('Y-m-d'))) != $dataInicio->format('md') && date('mt', strtotime($data->format('Y-m-d'))) == $data->format('md'))
			{
				for($i = 0; $i < 30 - $data->format('d'); $i++)
				{
					if($flag)
						array_push($arrayValor, $arrayValor[count($arrayValor)-1]);
					else
						array_push($arrayDesconto, $arrayDesconto[count($arrayDesconto)-1]);
				}
			}
		}

		if(date('mt', strtotime($dataFim->format('Y-m-d'))) == $dataFim->format('md'))
		{
			for($i = 0; $i < 30 - $dataFim->format('d'); $i++)
			{
				if($flag)
					array_push($arrayValor, $arrayValor[count($arrayValor)-1]);
				else
					array_push($arrayDesconto, $arrayDesconto[count($arrayDesconto)-1]);
			}
		}

		return ['array-dias-ativos' => $arrayValor, 'array-dias-inativos' => $arrayDesconto];
	}

	public static function maskValue($valor, $mascara)
	{
		$valor_formatado = "";
		$index = 0;
		for($i=0; $i<strlen($mascara); $i++)
			$valor_formatado .= ($mascara[$i] == "#") ? $valor[$index++] : $mascara[$i];
		return $valor_formatado;
	}

	public static function onlyNumber($value)
	{
		return preg_replace("/[^0-9]/", "", $value); 
	}

	public static function httprequest($endereco, $post, $parametros = [], $ssl = false, $chavePublica = '', $chavePrivada = '', $porta = 443)
	{

		$sessao_curl = curl_init();

		//  CURLOPT_CONNECTTIMEOUT
		//  o tempo em segundos de espera para obter uma conexão
		curl_setopt($sessao_curl, CURLOPT_CONNECTTIMEOUT, 10);

		curl_setopt($sessao_curl, CURLOPT_URL, $endereco);
		curl_setopt($sessao_curl, CURLOPT_PORT, $porta);

		curl_setopt($sessao_curl, CURLOPT_VERBOSE, true);
		// curl_setopt($sessao_curl, CURLOPT_HEADER, true);

		curl_setopt($sessao_curl, CURLOPT_FAILONERROR, true);

		if($ssl != false)
		{

			curl_setopt($sessao_curl, CURLOPT_SSLVERSION, 3);

			//  CURLOPPT_SSL_VERIFYHOST
			//  verifica se a identidade do servidor bate com aquela informada no certificado
			curl_setopt($sessao_curl, CURLOPT_SSL_VERIFYHOST, 2);

			//  CURLOPT_SSL_VERIFYPEER
			//  verifica a validade do certificado
			curl_setopt($sessao_curl, CURLOPT_SSL_VERIFYPEER, false);

			curl_setopt($sessao_curl, CURLOPT_SSLCERT, $chavePublica);
			curl_setopt($sessao_curl, CURLOPT_SSLKEY, $chavePrivada);

		}

		//  CURLOPT_TIMEOUT
		//  o tempo máximo em segundos de espera para a execução da requisição (curl_exec)
		// curl_setopt($sessao_curl, CURLOPT_TIMEOUT, 40);

		//  CURLOPT_RETURNTRANSFER
		//  TRUE para curl_exec retornar uma string de resultado em caso de sucesso, ao
		//  invés de imprimir o resultado na tela. Retorna FALSE se há problemas na requisição
		curl_setopt($sessao_curl, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($sessao_curl, CURLOPT_POST, true);
		curl_setopt($sessao_curl, CURLOPT_POSTFIELDS, $post);

		if(count($parametros) > 0)
			curl_setopt($sessao_curl, CURLOPT_HTTPHEADER, $parametros);

		$resultado = curl_exec($sessao_curl);
		
		curl_close($sessao_curl);

		if($resultado)
			return $resultado;
		else
			return false;
	}

	public static function montarLinhaDigitavel($codigo) {
			
		// Posição 	Conteúdo
		// 1 a 3    Número do banco
		// 4        Código da Moeda - 9 para Real
		// 5        Digito verificador do Código de Barras
		// 6 a 9   Fator de Vencimento
		// 10 a 19 Valor (8 inteiros e 2 decimais)
		// 20 a 44 Campo Livre definido por cada banco (25 caracteres)

		// 1. Campo - composto pelo código do banco, código da moéda, as cinco primeiras posições
		// do campo livre e DV (modulo10) deste campo
		$p1 = substr($codigo, 0, 4);
		$p2 = substr($codigo, 19, 5);
		$p3 = self::modulo_10("$p1$p2");
		$p4 = "$p1$p2$p3";
		$p5 = substr($p4, 0, 5);
		$p6 = substr($p4, 5);
		$campo1 = "$p5.$p6";

		// 2. Campo - composto pelas posiçoes 6 a 15 do campo livre
		// e livre e DV (modulo10) deste campo
		$p1 = substr($codigo, 24, 10);
		$p2 = self::modulo_10($p1);
		$p3 = "$p1$p2";
		$p4 = substr($p3, 0, 5);
		$p5 = substr($p3, 5);
		$campo2 = "$p4.$p5";

		// 3. Campo composto pelas posicoes 16 a 25 do campo livre
		// e livre e DV (modulo10) deste campo
		$p1 = substr($codigo, 34, 10);
		$p2 = self::modulo_10($p1);
		$p3 = "$p1$p2";
		$p4 = substr($p3, 0, 5);
		$p5 = substr($p3, 5);
		$campo3 = "$p4.$p5";

		// 4. Campo - digito verificador do codigo de barras
		$campo4 = substr($codigo, 4, 1);

		// 5. Campo composto pelo fator vencimento e valor nominal do documento, sem
		// indicacao de zeros a esquerda e sem edicao (sem ponto e virgula). Quando se
		// tratar de valor zerado, a representacao deve ser 000 (tres zeros).
		$p1 = substr($codigo, 5, 4);
		$p2 = substr($codigo, 9, 10);
		$campo5 = "$p1$p2";

		return "$campo1 $campo2 $campo3 $campo4 $campo5"; 
	}

	public static function modulo_10($num) { 
		$numtotal10 = 0;
		$fator = 2;

		// Separacao dos numeros
		for ($i = strlen($num); $i > 0; $i--) {
			// pega cada numero isoladamente
			$numeros[$i] = substr($num,$i-1,1);
			// Efetua multiplicacao do numero pelo (falor 10)
			// 2002-07-07 01:33:34 Macete para adequar ao Mod10 do Itaú
			$temp = $numeros[$i] * $fator; 
			$temp0=0;
			foreach (preg_split('//',$temp,-1,PREG_SPLIT_NO_EMPTY) as $k=>$v){ $temp0+=$v; }
			$parcial10[$i] = $temp0; //$numeros[$i] * $fator;
			// monta sequencia para soma dos digitos no (modulo 10)
			$numtotal10 += $parcial10[$i];
			if ($fator == 2) {
				$fator = 1;
			} else {
				$fator = 2; // intercala fator de multiplicacao (modulo 10)
			}
		}
		
		// várias linhas removidas, vide função original
		// Calculo do modulo 10
		$resto = $numtotal10 % 10;
		$digito = 10 - $resto;
		if ($resto == 0) {
			$digito = 0;
		}
		
		return $digito;
		
	}

	public static function modulo_11($num, $base=9, $r=0)  {
		$soma = 0;
		$fator = 2;

		/* Separacao dos numeros */
		for ($i = strlen($num); $i > 0; $i--) {
		// pega cada numero isoladamente
		$numeros[$i] = substr($num,$i-1,1);
		// Efetua multiplicacao do numero pelo falor
		$parcial[$i] = $numeros[$i] * $fator;
		// Soma dos digitos
		$soma += $parcial[$i];
		if ($fator == $base) {
			// restaura fator de multiplicacao para 2 
			$fator = 1;
		}
			$fator++;
		}

		/* Calculo do modulo 11 */
		if ($r == 0) {
			$soma *= 10;
			$digito = $soma % 11;
		if ($digito == 10) {
			$digito = 0;
		}
		return $digito;
		} elseif ($r == 1){
			$resto = $soma % 11;
			return $resto;
		}
	}

	public static function calcularDigitoVerificadorNossoNumero($numero)
	{
		$resto2 = self::modulo_11($numero, 9, 1);
		$digito = 11 - $resto2;
		if($digito == 10 || $digito == 11)
			$dv = 0;
		else
			$dv = $digito;
		return $dv;
	}


	public static function calcularDigitoVerificadorBarra($numero) {
		$resto2 = self::modulo_11($numero, 9, 1);
		 if ($resto2 == 0 || $resto2 == 1 || $resto2 == 10) {
			$dv = 1;
		 } else {
			$dv = 11 - $resto2;
		 }
		 return $dv;
	}

	public static function calcularFatorVencimento($data) {
		$data = explode("/", $data);
		$ano = $data[2];
		$mes = $data[1];
		$dia = $data[0];
		return(abs((self::_dateToDays("1997","10","07")) - (self::_dateToDays($ano, $mes, $dia))));
	}

	public static function _dateToDays($year,$month,$day) {
		$century = substr($year, 0, 2);
		$year = substr($year, 2, 2);
		if ($month > 2) {
			$month -= 3;
		} else {
			$month += 9;
			if ($year) {
				$year--;
			} else {
				$year = 99;
				$century --;
			}
		}
		return ( floor((  146097 * $century)    /  4 ) +
				floor(( 1461 * $year)        /  4 ) +
				floor(( 153 * $month +  2) /  5 ) +
					$day +  1721119);
	}

	public static function formatarValorCodigoBarras($numero, $loop, $insert, $tipo = "geral")
	{
		$str = ["," => '', '.' => ''];
		if ($tipo == "geral") {
			$numero = strtr($numero, $str);
			while(strlen($numero)<$loop){
				$numero = $insert . $numero;
			}
		}
		if ($tipo == "valor") {
			/*
			retira as virgulas
			formata o numero
			preenche com zeros
			*/
			$numero = strtr($numero, $str);
			while(strlen($numero) < $loop){
				$numero = $insert . $numero;
			}
		}
		if ($tipo = "convenio") {
			while(strlen($numero)<$loop){
				$numero = $numero . $insert;
			}
		}
		return $numero;
	}

	public static function validateDate($date, $format = 'Y-m-d')
	{
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}

	public static function inserirTransacao($codigo_transacao)
	{
		$referencia = $_SERVER["HTTP_REFERER"];
		$db = DB::getConection();
		if($db->query("SELECT * FROM transacoes WHERE cod_transacoes='{$codigo_transacao}'")->rowCount() > 0)
			return false;
		return ($db->query("INSERT INTO transacoes (cod_transacoes, referencia) VALUES ('{$codigo_transacao}', '{$referencia}')") !== false);
	}

	public static function verificarTransacao($codigo_transacao){
		$db = DB::getConection();
		return ($db->query("SELECT * FROM transacoes WHERE cod_transacoes='{$codigo_transacao}' AND (status = 0 OR status IS Null)")->rowCount() > 0);
	}

	public static function desativarTransacao($codigo_transacao){
		$db = DB::getConection();
		$db->query("UPDATE transacoes SET status = 1 WHERE cod_transacoes='{$codigo_transacao}' AND (status = 0 OR status IS Null)");
	}

	public static function validarCPFCNPJ($cpfcnpj)
	{

		if(strlen($cpfcnpj) === 11)
		{
			$soma = 0;
			for($i = 0; $i < 9; $i++)
				$soma += ((10-$i)*$cpfcnpj[$i]);

			$d1 = ($soma % 11);
			$d1 = ($d1 < 2) ? 0 : 11-$d1;

			$soma = 0;
			for($i = 0; $i < 10; $i++)
				$soma += ((11-$i)*$cpfcnpj[$i]);
			
			$d2 = ($soma % 11);
			$d2 = ($d2 < 2) ? 0 : 11-$d2;

			return ($d1 == $cpfcnpj[9] && $d2 == $cpfcnpj[10]);
		}
		else if(strlen($cpfcnpj) === 14)
		{
			$soma = 0;
			
			$soma += ($cpfcnpj[0] * 5);
			$soma += ($cpfcnpj[1] * 4);
			$soma += ($cpfcnpj[2] * 3);
			$soma += ($cpfcnpj[3] * 2);
			$soma += ($cpfcnpj[4] * 9); 
			$soma += ($cpfcnpj[5] * 8);
			$soma += ($cpfcnpj[6] * 7);
			$soma += ($cpfcnpj[7] * 6);
			$soma += ($cpfcnpj[8] * 5);
			$soma += ($cpfcnpj[9] * 4);
			$soma += ($cpfcnpj[10] * 3);
			$soma += ($cpfcnpj[11] * 2); 

			$d1 = $soma % 11; 
			$d1 = $d1 < 2 ? 0 : 11 - $d1; 

			$soma = 0;
			$soma += ($cpfcnpj[0] * 6); 
			$soma += ($cpfcnpj[1] * 5);
			$soma += ($cpfcnpj[2] * 4);
			$soma += ($cpfcnpj[3] * 3);
			$soma += ($cpfcnpj[4] * 2);
			$soma += ($cpfcnpj[5] * 9);
			$soma += ($cpfcnpj[6] * 8);
			$soma += ($cpfcnpj[7] * 7);
			$soma += ($cpfcnpj[8] * 6);
			$soma += ($cpfcnpj[9] * 5);
			$soma += ($cpfcnpj[10] * 4);
			$soma += ($cpfcnpj[11] * 3);
			$soma += ($cpfcnpj[12] * 2); 
			
			$d2 = $soma % 11; 
			$d2 = $d2 < 2 ? 0 : 11 - $d2; 

			return ($cpfcnpj[12] == $d1 && $cpfcnpj[13] == $d2);

		}
		else
			return false;
	}


	public static function formatarTempo($tempo)
	{

			$tempo = $tempo;
			$dias = floor($tempo/86400);
			$mes = floor($dias/30);
			$restoDias= $dias % 30;
			$horas = floor(($tempo-($dias*86400))/3600);
			$minutos = floor(($tempo-($dias*86400)-($horas*3600))/60);
			$segundos = floor(($tempo-($dias*86400)-($horas*3600)-($minutos*60)));

			if($mes >= 2 && $restoDias > 0)
				return $mes . " meses " .$restoDias . " dias " . sprintf("%02s", $horas) . ":" . sprintf("%02s", $minutos) . ":" . sprintf("%02s", $segundos) . "h";    
			elseif($mes == 1 && $restoDias > 0)
			   return $mes . " mês " .$restoDias . " dias " . sprintf("%02s", $horas) . ":" . sprintf("%02s", $minutos) . ":" . sprintf("%02s", $segundos) . "h";    
			elseif($dias == 30 && $restoDias == 0)
				return $mes . " mês " . sprintf("%02s", $horas) . ":" . sprintf("%02s", $minutos) . ":" . sprintf("%02s", $segundos) . "h";    
			elseif($dias > 1 && $dias < 30)
				return $dias . " dias " . sprintf("%02s", $horas) . ":" . sprintf("%02s", $minutos) . ":" . sprintf("%02s", $segundos) . "h";    
			else
				return sprintf("%02s", $horas) . ":" . sprintf("%02s", $minutos) . ":" . sprintf("%02s", $segundos) . "h";    

	}


}
