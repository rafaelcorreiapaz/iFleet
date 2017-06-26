<?php

namespace model\dao;

use model\DAO;
use model\Model;
use model\MarcaModel;

class Marca implements DAO
{

    private $db;

    public function __construct()
    {
        $this->db = \DB::getConnection();
    }

    public function load($id)
    {
        return $this->db->query("SELECT * FROM marcas WHERE id = {$id}")->fetch(\PDO::FETCH_ASSOC);
    }

	public function queryAll()
    {
        return $this->db->query("SELECT * FROM marcas")->fetchAll(\PDO::FETCH_ASSOC);
    }

	public function queryAllOrderBy($orderColumn)
    {
        return $this->db->query("SELECT * FROM marcas ORDER BY {$orderColumn}")->fetchAll(\PDO::FETCH_ASSOC);
    }

	public function delete($id)
    {
        return $this->db->query("DELETE FROM marcas WHERE id = {$id}")->fetch(\PDO::FETCH_ASSOC);
    }

	public function salvar(Model $obj)
    {
        $id      = $obj->getId();
        $descricao    = $obj->getDescricao();
        if(empty($id))
            return $this->db->query("INSERT INTO marcas SET descricao = '{$descricao}'");
        else
            return $this->db->query("UPDATE marcas SET descricao = '{$descricao}' WHERE id = {$id}");
    }


}