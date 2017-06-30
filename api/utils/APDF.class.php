<?php

require_once 'FPDF/fpdf.php';

abstract class APDF extends FPDF
{

	private $description;
	private $widths;
	private $aligns;

	public function __construct($description = '', $orientation = 'P', $unit = 'mm', $format = 'A4')
	{
		parent::__construct($orientation, $unit, $format);
		$this->description = $description;
	}

	public final function montarPDF()
	{
		$this->aliasNbPages();
		$this->addPage();
		$this->corpo();
		$this->output();
	}

	public final function header()
	{
		$this->image("imagens/ifma_novo.jpg", 10, 6, 20);
		$this->ln(2);

		$this->setFont('Arial', 'BU', 12);
		$this->cell(25);
		$this->cell(75, 0, "INSTITUTO FEDERAL DO MARANHÃO", 0, 0, 'L');

		$this->ln();
		$this->cell(25);
		$this->setFont('Arial', '', 7);
		$this->cell(75, 10, "RUA SIMPLÍCIO MOREIRA, 1.485B - CENTRO - FONE: (99) 3529-3131", 0, 0, 'L');

		$this->ln();
		$this->cell(25);
		$this->cell(75, -2, "www.ifma.edu.br - sac@ifma.edu.br - " . date("d/m/Y H:i:s"), 0, 0, 'L');
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

	public final function footer()
	{
		$this->SetY(-15);
		$this->SetFont("Times", "I", 8);
		$this->Cell(0, 10, "PÁGINA " . $this->PageNo(). " DE {nb}", 0, 0, "R");
	}

	public function setWidths($w)
	{
		$this->widths = $w;
	}

	public function setAligns($a)
	{
		$this->aligns = $a;
	}

	function row($data, $color = false)
	{
		//Calculate the height of the row
		$nb = 0;
		for ($i = 0; $i < count($data); $i++)
			$nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
		$h = 4 * $nb;
		//Issue a page break first if needed
		$this->checkPageBreak($h);
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
			$this->MultiCell($w, 4, $data[$i], 0, $a, $color);
			//Put the position to the right of the cell
			$this->SetXY($x + $w, $y);
		}
		//Go to the next line
		$this->Ln($h);
	}

	private function checkPageBreak($h)
	{
		if ($this->GetY() + $h > $this->PageBreakTrigger)
			$this->AddPage($this->CurOrientation);
	}

	private function NbLines($w, $txt)
	{
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

}
