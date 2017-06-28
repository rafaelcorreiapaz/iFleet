<?php

namespace model\dao;

use model\DAO;
use model\Model;
use model\UsuarioModel;

class Usuario implements DAO
{

    private $db;

    public function __construct()
    {
        $this->db = \DB::getConnection();
    }

    public function load($id)
    {
        return $this->db->query("SELECT * FROM usuarios WHERE id = {$id}")->fetch(\PDO::FETCH_ASSOC);
    }

    public function loadUsuario($usuario)
    {
        return $this->db->query("SELECT * FROM usuarios WHERE usuario = '{$usuario}'")->fetch(\PDO::FETCH_ASSOC);
    }

	public function queryAll()
    {
        return $this->db->query("SELECT * FROM usuarios")->fetchAll(\PDO::FETCH_ASSOC);
    }

	public function queryAllOrderBy($orderColumn)
    {
        return $this->db->query("SELECT * FROM usuarios ORDER BY {$orderColumn}")->fetchAll(\PDO::FETCH_ASSOC);
    }

	public function delete($id)
    {
        return $this->db->query("DELETE FROM usuarios WHERE id = {$id}")->fetch(\PDO::FETCH_ASSOC);
    }

	public function salvar(Model $obj)
    {
        $id      = $obj->getId();
        $nome    = $obj->getNome();
        $usuario = $obj->getUsuario();
        $senha   = $obj->getSenha();

        if(empty($id))
            return $this->db->query("INSERT INTO usuarios SET nome = '{$nome}', usuario = '{$usuario}', senha = '{$senha}'");
        else
            return $this->db->query("UPDATE usuarios SET nome = '{$nome}', usuario = '{$usuario}', senha = '{$senha}' WHERE id = {$id}");
    }


}