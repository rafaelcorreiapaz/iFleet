<?php

namespace model;

use model\ModeloModel;
use model\VeiculoModel;
use model\ControleModel;
use model\dao\ItemControle;

class ItemControleModel extends Model
{

	private $dao;
	private $id;
	private $veiculo;
	private $kilometro_atual;
	private $controle;
	private $categoria_controle;
	private $quantidade;
	private $valor;

	public function __construct($id = '')
	{
		$this->dao = new ItemControle();
		if(!empty($id))
		{
			$this->id = $id;
			$this->popular();
		}
	}

	public function getId()
	{
		return $this->id;
	}

	public function setVeiculo(VeiculoModel $veiculo)
	{
		$this->veiculo = $veiculo;
	}

	public function getVeiculo()
	{
		return $this->veiculo;
	}

	public function setKilometroAtual($kilometro_atual)
	{
		$this->kilometro_atual = (int) $kilometro_atual;
	}

	public function getKilometroAtual()
	{
		return $this->kilometro_atual;
	}

	public function setCategoriaControle($categoria_controle)
	{
		$this->categoria_controle = $categoria_controle;
	}

	public function getCategoriaControle()
	{
		return $this->categoria_controle;
	}

	public function setControle(ControleModel $controle)
	{
		$this->controle = $controle;
	}

	public function getControle()
	{
		return $this->controle;
	}

	public function setQuantidade($quantidade)
	{
		$this->quantidade = $quantidade;
	}

	public function getQuantidade()
	{
		return $this->quantidade;
	}

	public function setValor($valor)
	{
		$this->valor = $valor;
	}

	public function getValor()
	{
		return $this->valor;
	}

	public function getValorFormatado()
	{
		return \SystemHelper::decimalFormat($this->valor);
	}

	public function getQuantidadeFormatada()
	{
		return \SystemHelper::decimalFormat($this->quantidade);
	}

	public function validar()
	{
		if(empty($this->kilometro_atual))
			throw new \Exception('Kil�metro atual inv�lido');
		if(empty($this->valor))
			throw new \Exception('Valor inv�lido');
		if($this->getControle()->getId() == 0)
			throw new \Exception('Controle inv�lido');
	}

	protected function popular()
	{
		if(!empty($this->getId()))
		{
			$registro = $this->dao->load($this->getId());

			$this->setVeiculo(new VeiculoModel($registro['veiculo']));
			$this->setKilometroAtual($registro['kilometro_atual']);
			$this->setCategoriaControle($registro['categoria_controle']);
			$this->setQuantidade($registro['quantidade']);
			$this->setValor($registro['valor']);
		}
	}

	private function verificarPeriodoRevisao()
	{
		$veiculo = $this->getVeiculo();
		$veiculo->setControle($this->getControle());
		if(($veiculo->getKilometroRevisao() - ($this->getKilometroAtual() - $veiculo->getKilometroUltimaRevisao())) < 100 || (strtotime($this->getControle()->getData()) - strtotime($veiculo->getDataUltimaRevisao())) < strtotime('1 month'))
		{
			$comunicacao = new \ComunicacaoFacade();
			foreach(\SystemConfig::getData('contatos') as $contato)
			{
				$comunicacao->enviarMensagem($contato, 'Ve�culo de placa ' . $veiculo->getPlaca() . ' j� est� pr�ximo do per�odo de revis�o.');
			}
		}
	}

	public function salvar()
	{
		$this->validar();
		$this->verificarPeriodoRevisao();
		return $this->dao->salvar($this);
	}

}