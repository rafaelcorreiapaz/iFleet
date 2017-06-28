<?php

namespace model;
use model\Model;
use model\documento\ACadastroPessoa;
use model\dao\Fornecedor;

class FornecedorModel extends Model
{

	private $dao;
	private $id;
	private $nome;
	private $cpfcnpj;

	public function __construct($id = '')
	{
		$this->dao = new Fornecedor();
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

	public function setNome($nome)
	{
		$this->nome = $nome;
	}

	public function getNome()
	{
		return $this->nome;
	}

	public function setCpfCnpj(ACadastroPessoa $cpfcnpj)
	{
		$this->cpfcnpj = $cpfcnpj;
	}

	public function getCpfCnpj()
	{
		return $this->cpfcnpj;
	}

	public function validar()
	{
		if(empty($this->nome))
			throw new \Exception('Nome inválido');
		if(!$this->cpfcnpj->validarDocumento())
			throw new \Exception('Documento inválido');            
	}

	protected function popular()
	{
		if(!empty($this->getId()))
		{
			$registro = $this->dao->load($this->getId());
			$this->setNome($registro['nome']);

			$this->setCpfCnpj(\DocumentoCadastroFactory::getObjeto($registro['cpfcnpj']));
		}
	}

	public function salvar()
	{
		$this->validar();
		return $this->dao->salvar($this);
	}

}