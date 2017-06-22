<?php

require_once 'FPDF/fpdf.php';

class Relatorio extends FPDF
{

	private $descricao;
	private $widths;
	private $aligns;

	public function header()
	{
		// $this->image("../resources/images/nfe.jpg", 17, 8, 20);

		$this->SetFont('Times', 'BU', 15);
		$this->Cell(35);
		$this->Cell(75, 0, "SISTEMA DE NOTA FISCAL ELETRÔNICA", 0, 0, 'L');

		$this->Ln();
		$this->Cell(35);
		$this->SetFont('Times', '', 8);
		$this->Cell(75, 10, "JÚPITER TELECOMUNICAÇÕES E INFORMÁTICA LTDA", 0, 0, 'L');

		$this->Ln();
		$this->Cell(35);
		$this->SetFont('Times', '', 8);
		$this->Cell(75, -2, "RUA SIMPLÍCIO MOREIRA, 1.485B - CENTRO - FONE: (99) 3529-3131", 0, 0, 'L');

		$this->Ln();
		$this->Cell(35);
		$this->SetFont('Times', '', 8);
		$this->Cell(75, 10, "www.jupiter.com.br - sac@jupiter.com.br", 0, 0, 'L');

		$this->Ln();
		$this->Cell(35);
		$this->SetFont('Times', '', 8);
		$this->Cell(75, -2, strtoupper($this->descricao) . " - " . date("d/m/Y H:i:s"), 0, 0, 'L');

		$this->ln(10);
	}

	public function footer()
	{
		$this->SetY(-15);
		$this->SetFont("Times", "I", 8);
		$this->Cell(0, 10, "PÁGINA " . $this->PageNo(). " DE {nb}", 0, 0, "R");
	}

	public function setDescricao($descricao)
	{
		$this->descricao = $descricao;
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
