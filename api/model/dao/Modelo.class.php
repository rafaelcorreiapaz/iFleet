<?php

namespace model\dao;

use model\DAO;
use model\Model;
use model\ModeloModel;

class Modelo implements DAO
{

    private $db;

    public function __construct()
    {
        $this->db = \DB::getConnection();
    }

    public function load($id)
    {
        return $this->db->query("SELECT * FROM modelos WHERE id = {$id}")->fetch(\PDO::FETCH_ASSOC);
    }

	public function queryAll()
    {
        return $this->db->query("SELECT * FROM modelos")->fetchAll(\PDO::FETCH_ASSOC);
    }

	public function queryAllOrderBy($orderColumn)
    {
        return $this->db->query("SELECT * FROM modelos ORDER BY {$orderColumn}")->fetchAll(\PDO::FETCH_ASSOC);
    }

	public function delete($id)
    {
        return $this->db->query("DELETE FROM modelos WHERE id = {$id}")->fetch(\PDO::FETCH_ASSOC);
    }

	public function salvar(Model $obj)
    {
        $id         = $obj->getId();
        $descricao  = $obj->getDescricao();
        $marca      = $obj->getMarca()->getId();
        if(empty($id))
            return $this->db->query("INSERT INTO marcas SET nome = '{$nome}', descricao = '{$descricao}', marca = '{$marca}'");
        else
            return $this->db->query("UPDATE marcas SET nome = '{$nome}', descricao = '{$descricao}', marca = '{$marca}' WHERE id = {$id}");
    }

}