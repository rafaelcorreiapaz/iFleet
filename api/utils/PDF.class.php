<?php

require_once 'FPDF/fpdf.php';

class PDF extends FPDF
{

	private $titulo;
	public $showHeader = true;

	public function __construct($titulo = '', $orientation = 'P', $unit = 'mm', $format = 'A4')
	{
		if($titulo !== false)
			$this->titulo = $titulo;
		parent::FPDF($orientation, $unit, $format);
	}

	public function mudarTitulo($titulo = false)
	{
		if($titulo !== false)
			$this->titulo = $titulo;
	}

	public function header()
	{
		if($this->showHeader === true)
		{
			$this->image("imagens/logo_relatorio.jpg", 10, 6, 20);
			$this->ln(2);

			$this->setFont('Arial', 'BU', 12);
			$this->cell(25);
			$this->cell(75, 0, "JÚPITER TELECOMUNICAÇÕES E INFORMÁTICA LTDA", 0, 0, 'L');

			$this->ln();
			$this->cell(25);
			$this->setFont('Arial', '', 7);
			$this->cell(75, 10, "RUA SIMPLÍCIO MOREIRA, 1.485B - CENTRO - FONE: (99) 3529-3131", 0, 0, 'L');

			$this->ln();
			$this->cell(25);
			$this->cell(75, -2, SystemConfig::getData($_SESSION['_sistema'])['entidade'] . " - www.jupiter.com.br - sac@jupiter.com.br - " . date("d/m/Y H:i:s"), 0, 0, 'L');
			// $this->cell(75, -2, SystemConfig::getData($_SESSION['_sistema'])['entidade'] . " - www.jupiter.com.br - sac@jupiter.com.br - " . date("d/m/Y H:i:s"), 0, 0, 'L');

			if($this->titulo != '')
			{
				$this->setY(6);
				$this->setX(160);
				$this->setFont('Arial', 'B', 10);
				$this->drawTextBox($this->titulo, 40, 20, 'C', 'M');
			}

			$this->ln($this->titulo != '' ? 15 : 10);
		}

	}

	public function footer()
	{
		$this->SetY(-15);
		$this->setFont("Arial", "I", 6);
		$this->cell(0, 10, "PÁGINA {$this->PageNo()} DE {nb}", 0, 0, "R");
	}

	public function setarLarguras(array $w)
	{
		//Set the array of column widths
		$this->widths = $w;
	}

	public function setarAlinhamentos(array $a)
	{
		//Set the array of column alignments
		$this->aligns = $a;
	}

	public function pageWidth()
	{
		$width = $this->w;
		$leftMargin = $this->lMargin;
		$rightMargin = $this->rMargin;
		return $width - $rightMargin - $leftMargin;
	}

	public function montarGrid(array $lista, array $titulos, array $larguras, array $alinhamentos, $colunaSoma = null)
	{
		
		$arraySoma = [];

		$totalArrayLarguras = array_sum($larguras);
		foreach($larguras as $key => $largura)
		{
			$larguras[$key] = $this->pageWidth()*$largura/$totalArrayLarguras;
		}

		$this->setarLarguras($larguras);
		$this->setFont('Arial', 'B', 7);
		$this->setarAlinhamentos(array_fill(0, count($titulos), 'C'));
		$this->setFillColor(190, 190, 190);
		$this->linha(array_values($titulos), true);
		$this->setarAlinhamentos($alinhamentos);
		$this->setFont('Arial', '', 8);
		foreach($lista AS $valor)
		{
			if($colunaSoma != null)
				$arraySoma[] = $valor['total'];
			$data = [];
			foreach($titulos AS $chave => $titulo)
			{
				$verificacao = (is_numeric($valor[$chave]) && $alinhamentos[count($data)] == 'R') ? SystemHelper::decimalFormat($valor[$chave]) : $valor[$chave];
				$data[] = ($verificacao == $valor[$chave]) ? $verificacao : $valor[$chave];
			}
			$this->linha($data);
		}
		if(count($arraySoma) > 0)
		{
			$this->cell($this->pageWidth()-$larguras[count($larguras)-1], 4, SystemHelper::retornarNumeroPorExtenso(array_sum($arraySoma)), 0, 0, "R");
			$this->cell($larguras[count($larguras)-1], 4, SystemHelper::decimalFormat(array_sum($arraySoma)), 1, 1, "R");
		}

	}

	public function montarCadastroPessoa(array $pessoa, $mostrarDocumento = true, $mostrarEnderecoCompleto = false)
	{	
		$this->setFont('Arial', 'B', 7);
		$this->cell(($mostrarDocumento === true ? 130/190*$this->pageWidth() : $this->pageWidth()), 4, "NOME", "L:1; R:1; T:1;", ($mostrarDocumento === true ? 0 : 1), "L");
		if($mostrarDocumento === true)
		{
			$this->cell(30/190*$this->pageWidth(), 4, "CPF/CNPJ", "R:1; T:1;", 0, "L");
			$this->cell(30/190*$this->pageWidth(), 4, "RG/PASSAPORTE/IE", "R:1; T:1;", 1, "L");
		}
		
		$this->setFont('Arial', '', 8);
		$this->cell(($mostrarDocumento === true ? 130/190*$this->pageWidth() : $this->pageWidth()), 4, $pessoa['nome'], "L:1; R:1; B:1;", ($mostrarDocumento === true ? 0 : 1), "L");
		if($mostrarDocumento === true)
		{
			$this->cell(30/190*$this->pageWidth(), 4, $pessoa['cnpjcpf'] != "" ? (SystemHelper::maskValue($pessoa['cnpjcpf'], strlen($pessoa['cnpjcpf']) == 11 ? '###.###.###-##' : '##.###.###/####-##')) : "", "R:1; B:1;", 0, "L");
			$this->cell(30/190*$this->pageWidth(), 4, $pessoa['passaporterg'].$pessoa['inscricaoestadual'], "R:1; B:1;", 1, "L");

			if(strlen($pessoa['cnpjcpf']) == 11)
			{
				$this->setFont('Arial', 'B', 7);
				$this->cell(70/190*$this->pageWidth(), 4, "PAI", "L:1; R:1;", 0, "L");
				$this->cell(70/190*$this->pageWidth(), 4, "MÃE", "R:1;", 0, "L");
				$this->cell(30/190*$this->pageWidth(), 4, "PROFISSÃO", "R:1;", 0, "L");
				$this->cell(20/190*$this->pageWidth(), 4, "NASC", "R:1;", 1, "L");

				$this->setFont('Arial', '', 8);
				$this->cell(70/190*$this->pageWidth(), 4, $pessoa['pai'], "L:1; R:1; B:1;", 0, "L");
				$this->cell(70/190*$this->pageWidth(), 4, $pessoa['mae'], "R:1; B:1;", 0, "L");
				$this->cell(30/190*$this->pageWidth(), 4, $pessoa['profissao'], "R:1; B:1;", 0, "L");
				$this->cell(20/190*$this->pageWidth(), 4, SystemHelper::formatDate($pessoa['datanascimento'], 'Y-m-d', 'd/m/Y'), "R:1; B:1;", 1, "L");
			}
		}

		$this->setFont('Arial', 'B', 7);
		$this->cell(90/190*$this->pageWidth(), 4, "LOGRADOURO", "L:1; R:1;", 0, "L");
		$this->cell(10/190*$this->pageWidth(), 4, "Nº", "R:1;", 0, "L");
		$this->cell(20/190*$this->pageWidth(), 4, "CEP", "R:1;", 0, "L");
		$this->cell(25/190*$this->pageWidth(), 4, "BAIRRO", "R:1;", 0, "L");
		$this->cell(35/190*$this->pageWidth(), 4, "LOCALIDADE", "R:1;", 0, "L");
		$this->cell(10/190*$this->pageWidth(), 4, "UF", "R:1;", 1, "L");

		$this->setFont('Arial', '', 8);
		$this->cell(90/190*$this->pageWidth(), 4, $pessoa['logradouro'], "L:1; R:1; B:1;", 0, "L");
		$this->cell(10/190*$this->pageWidth(), 4, $pessoa['numero'], "R:1; B:1;", 0, "L");
		$this->cell(20/190*$this->pageWidth(), 4, SystemHelper::maskValue($pessoa['cep'], '#####-###'), "R:1; B:1;", 0, "L");
		$this->cell(25/190*$this->pageWidth(), 4, $pessoa['bairro'], "R:1; B:1;", 0, "L");
		$this->cell(35/190*$this->pageWidth(), 4, $pessoa['localidade'], "R:1; B:1;", 0, "L");
		$this->cell(10/190*$this->pageWidth(), 4, $pessoa['estado'], "R:1; B:1;", 1, "L");

		if($mostrarEnderecoCompleto === true)
		{
			$this->setFont('Arial', 'B', 7);
			$this->cell(95/190*$this->pageWidth(), 4, "COMPLEMENTO", "L:1; R:1;", 0, "L");
			$this->cell(95/190*$this->pageWidth(), 4, "REFERÊNCIA", "R:1;", 1, "L");

			$this->setFont('Arial', '', 8);
			$this->cell(95/190*$this->pageWidth(), 4, $pessoa['complemento'], "L:1; R:1; B:1;", 0, "L");
			$this->cell(95/190*$this->pageWidth(), 4, $pessoa['referencia'], "R:1; B:1;", 1, "L");

		}

	}

	public function montarContatos(array $contatos, $titulo = 'CONTATOS')
	{
		$this->setFont('Arial', 'B', 7);

		$this->cell(0, 5, $titulo , 0, 1, "L");

		$linhas = ceil(count($contatos)/3);
		$total  = count($contatos);
		$this->setFont('Arial', '', 8);
		$i = 0;
		for($linha = 1; $linha <= $linhas; ++$linha)
		{
			$totalColunas = ($total - 4) <= 0 ? $total : 3;
			for($coluna = 1; $coluna <= $totalColunas; ++$coluna)
			{
				$arrayContato = explode(',', $contatos[$i]);
				if($arrayContato[0] != 5)
					$arrayContato[1] = strpos($arrayContato[1], '@') === false ? SystemHelper::maskValue($arrayContato[1], (strlen($arrayContato[1]) == 11 ? '(##) #####-####' : '(##) ####-####')) : $arrayContato[1];

				$this->cell($this->pageWidth()/$totalColunas, 4, SystemConfig::getData('tipoContato')[$arrayContato[0]] . ": " . $arrayContato[1] , 1, (($coluna == $totalColunas) ? 1 : 0), "L");
				++$i;
				--$total;
			}
		}
	}

	public function montarEnderecoInstalacao(array $enderecoInstalacao)
	{	

		$this->setFont('Arial', 'B', 7);

		$this->cell(0, 5, "ENDEREÇO PARA INSTALAÇÃO",0, 1, "L");

		$this->cell(90/190*$this->pageWidth(), 4, "LOGRADOURO", "L:1; R:1;T:1;", 0, "L");
		$this->cell(10/190*$this->pageWidth(), 4, "Nº", "R:1; T:1;", 0, "L");
		$this->cell(20/190*$this->pageWidth(), 4, "CEP", "R:1; T:1;", 0, "L");
		$this->cell(30/190*$this->pageWidth(), 4, "BAIRRO", "R:1 T:1;;", 0, "L");
		$this->cell(30/190*$this->pageWidth(), 4, "MUNICÍPIO", "R:1 T:1;", 0, "L");
		$this->cell(10/190*$this->pageWidth(), 4, "UF", "R:1; T:1;", 1, "L");

		$this->setFont('Arial', '', 8);
		$this->cell(90/190*$this->pageWidth(), 4, $enderecoInstalacao['logradouro'], "L:1; R:1; B:1; ", 0, "L");
		$this->cell(10/190*$this->pageWidth(), 4, $enderecoInstalacao['numero'], "R:1; B:1;", 0, "L");
		$this->cell(20/190*$this->pageWidth(), 4, SystemHelper::maskValue($enderecoInstalacao['cep'], '#####-###'), "R:1; B:1;", 0, "L");
		$this->cell(30/190*$this->pageWidth(), 4, $enderecoInstalacao['bairro'], "R:1; B:1;", 0, "L");
		$this->cell(30/190*$this->pageWidth(), 4, $enderecoInstalacao['municipio'], "R:1; B:1;", 0, "L");
		$this->cell(10/190*$this->pageWidth(), 4, $enderecoInstalacao['estado'], "R:1; B:1;", 1, "L");

	}

	public function montarDadosAnatel()
	{	

		$this->setFont('Arial', 'B', 7);
		$this->cell(0, 5, "CENTRAL DE ATENDIMENTO DA ANATEL", 0, 1, "L");

		$this->setFont('Arial', '', 8);
		$this->cell(95/190*$this->pageWidth(), 4, "Disque: 133", 1, 0, "L");
		$this->cell(95/190*$this->pageWidth(), 4, "Site: www.anatel.gov.br", 1, 1, "L");

	}

	public function linha($data, $color = false)
	{
		//Calculate the height of the row
		$nb = 0;
		for ($i = 0; $i < count($data); $i++)
			$nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
		$h = 4 * $nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		for ($i = 0; $i < count($data); $i++) {
			$w = $this->widths[$i];
			$a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			//Save the current position
			$x = $this->GetX();
			$y = $this->GetY();
			$this->MultiCell($w, 4, $data[$i], 0, $a, $color);
			//Draw the border
			$this->Rect($x, $y, $w, $h);
			//Print the text
			//Put the position to the right of the cell
			$this->SetXY($x + $w, $y);
		}
		//Go to the next line
		$this->Ln($h);
	}

	public function CheckPageBreak($h)
	{
		//If the height h would cause an overflow, add a new page immediately
		if ($this->GetY() + $h > $this->PageBreakTrigger)
			$this->AddPage($this->CurOrientation);
	}

	public function NbLines($w, $txt)
	{
		//Computes the number of lines a MultiCell of width w will take
		$cw = &$this->CurrentFont['cw'];
		if ($w == 0)
			$w = $this->w - $this->rMargin - $this->x;
		$wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
		$s = str_replace("\r", '', $txt);
		$nb = strlen($s);
		if ($nb > 0 and $s[$nb - 1] == "\n")
			$nb--;
		$sep = -1;
		$i = 0;
		$j = 0;
		$l = 0;
		$nl = 1;
		while ($i < $nb) {
			$c = $s[$i];
			if ($c == "\n") {
				$i++;
				$sep = -1;
				$j = $i;
				$l = 0;
				$nl++;
				continue;
			}
			if ($c == ' ')
				$sep = $i;
			$l += $cw[$c];
			if ($l > $wmax) {
				if ($sep == -1) {
					if ($i == $j)
						$i++;
				} else
					$i = $sep + 1;
				$sep = -1;
				$j = $i;
				$l = 0;
				$nl++;
			} else
				$i++;
		}
		return $nl;
	}

	function SetWidths($w)
	{
		//Set the array of column widths
		$this->widths = $w;
	}

	function SetAligns($a)
	{
		//Set the array of column alignments
		$this->aligns = $a;
	}

	function Row($data)
	{
		//Calculate the height of the row
		$nb = 0;
		for ($i = 0; $i < count($data); $i++)
			$nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
		$h = 4 * $nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		for ($i = 0; $i < count($data); $i++) {
			$w = $this->widths[$i];
			$a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			//Save the current position
			$x = $this->GetX();
			$y = $this->GetY();
			//Draw the border
			$this->Rect($x, $y, $w, $h);
			//Print the text
			$this->MultiCell($w, 4, $data[$i], 0, $a);
			//Put the position to the right of the cell
			$this->SetXY($x + $w, $y);
		}
		//Go to the next line
		$this->Ln($h);
	}

	function drawTextBox($strText, $w, $h, $align='L', $valign='T', $border=1)
	{
		$xi=$this->GetX();
		$yi=$this->GetY();
		
		$hrow=$this->FontSize;
		$textrows=$this->drawRows($w, $hrow, $strText, 0, $align, 0, 0, 0);
		$maxrows=floor($h/$this->FontSize);
		$rows=min($textrows, $maxrows);

		$dy=0;
		if (strtoupper($valign)=='M')
			$dy=($h-$rows*$this->FontSize)/2;
		if (strtoupper($valign)=='B')
			$dy=$h-$rows*$this->FontSize;

		$this->SetY($yi+$dy);
		$this->SetX($xi);

		$this->drawRows($w, $hrow, $strText, 0, $align, 0, $rows, 1);

		if ($border==1)
			$this->Rect($xi, $yi, $w, $h);
	}

	function drawRows($w, $h, $txt, $border=0, $align='J', $fill=0, $maxline=0, $prn=0)
	{
		$cw=&$this->CurrentFont['cw'];
		if($w==0)
			$w=$this->w-$this->rMargin-$this->x;
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		$s=str_replace("\r", '', $txt);
		$nb=strlen($s);
		if($nb>0 and $s[$nb-1]=="\n")
			$nb--;
		$b=0;
		if($border)
		{
			if($border==1)
			{
				$border='LTRB';
				$b='LRT';
				$b2='LR';
			}
			else
			{
				$b2='';
				if(is_int(strpos($border, 'L')))
					$b2.='L';
				if(is_int(strpos($border, 'R')))
					$b2.='R';
				$b=is_int(strpos($border, 'T')) ? $b2.'T' : $b2;
			}
		}
		$sep=-1;
		$i=0;
		$j=0;
		$l=0;
		$ns=0;
		$nl=1;
		while($i<$nb)
		{
			//Get next character
			$c=$s[$i];
			if($c=="\n")
			{
				//Explicit line break
				if($this->ws>0)
				{
					$this->ws=0;
					if ($prn==1) $this->_out('0 Tw');
				}
				if ($prn==1) {
					$this->Cell($w, $h, substr($s, $j, $i-$j), $b, 2, $align, $fill);
				}
				$i++;
				$sep=-1;
				$j=$i;
				$l=0;
				$ns=0;
				$nl++;
				if($border and $nl==2)
					$b=$b2;
				if ( $maxline && $nl > $maxline )
					return substr($s, $i);
				continue;
			}
			if($c==' ')
			{
				$sep=$i;
				$ls=$l;
				$ns++;
			}
			$l+=$cw[$c];
			if($l>$wmax)
			{
				//Automatic line break
				if($sep==-1)
				{
					if($i==$j)
						$i++;
					if($this->ws>0)
					{
						$this->ws=0;
						if ($prn==1) $this->_out('0 Tw');
					}
					if ($prn==1) {
						$this->Cell($w, $h, substr($s, $j, $i-$j), $b, 2, $align, $fill);
					}
				}
				else
				{
					if($align=='J')
					{
						$this->ws=($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
						if ($prn==1) $this->_out(sprintf('%.3f Tw', $this->ws*$this->k));
					}
					if ($prn==1){
						$this->Cell($w, $h, substr($s, $j, $sep-$j), $b, 2, $align, $fill);
					}
					$i=$sep+1;
				}
				$sep=-1;
				$j=$i;
				$l=0;
				$ns=0;
				$nl++;
				if($border and $nl==2)
					$b=$b2;
				if ( $maxline && $nl > $maxline )
					return substr($s, $i);
			}
			else
				$i++;
		}
		//Last chunk
		if($this->ws>0)
		{
			$this->ws=0;
			if ($prn==1) $this->_out('0 Tw');
		}
		if($border and is_int(strpos($border, 'B')))
			$b.='B';
		if ($prn==1) {
			$this->Cell($w, $h, substr($s, $j, $i-$j), $b, 2, $align, $fill);
		}
		$this->x=$this->lMargin;
		return $nl;
	}

	
}