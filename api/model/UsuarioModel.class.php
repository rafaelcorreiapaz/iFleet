<?php

namespace model;

use model\dao\Usuario;

class UsuarioModel extends Model
{
	private $dao;
	private $id;
	private $nome;
	private $usuario;
	private $senha;
	private $load = false;

	public function __construct($id = '')
	{
		$this->dao = new Usuario();
		if(!empty($id))
		{
			$this->setId($id);
			$this->popular();
		}
	}

	private function setId($id)
	{
		$this->id = $id;
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

	public function setUsuario($usuario)
	{
		$this->usuario = $usuario;
		if($this->load == false)
			$this->popular();
	}

	public function getUsuario()
	{
		return $this->usuario;
	}

	public function setSenha($senha)
	{
		$this->senha = $senha;
	}

	public function getSenha()
	{
		return $this->senha;
	}

	public function verificarUsuarioESenha($usuario, $senha)
	{
		return (!empty($this->getUsuario()) && !empty($this->getSenha()) && $this->getUsuario() == $usuario && $this->getSenha() == $senha);
	}

	public function validar()
	{
		if(empty($this->getNome()))
			throw new \Exception('Nome inválido');
		if(strlen($this->getSenha()) < 6)
			throw new \Exception('Senha inválida');
		if(strlen($this->getUsuario()) < 4)
			throw new \Exception('Usuário inválido' . $this->getUsuario());
	}

	protected function popular()
	{
		if($this->load == false)
		{
			$this->load = true;
			if(!empty($this->getId()))
			{
				$registro = $this->dao->load($this->getId());
				$this->setNome($registro['nome']);
				$this->setUsuario($registro['usuario']);
				$this->setSenha($registro['senha']);
			}
			else if(!empty($this->getUsuario()) && empty($this->getId()))
			{
				$registro = $this->dao->loadUsuario($this->getUsuario());
				$this->setId($registro['id']);
				$this->setNome($registro['nome']);
				$this->setSenha($registro['senha']);
			}
		}
	}

	public function salvar()
	{
		$this->validar();
		return $this->dao->salvar($this);
	}

}