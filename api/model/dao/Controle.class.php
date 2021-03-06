<?php

namespace model\dao;

use model\DAO;
use model\Model;
use model\ControleModel;
use model\dao\ItemControle;

class Controle implements DAO
{

    private $db;

    public function __construct()
    {
        $this->db = \DB::getConnection();
    }

    public function load($id)
    {
        return $this->db->query("SELECT controles.*, fornecedores.nome FROM controles INNER JOIN fornecedores ON (controles.fornecedor = fornecedores.id) WHERE controles.id = {$id}")->fetch(\PDO::FETCH_ASSOC);
    }

    public function getId()
    {
        return $this->db->query('SELECT LAST_INSERT_ID()')->fetchColumn();
    }

	public function queryAll()
    {
        return $this->db->query("SELECT controles.*, fornecedores.nome FROM controles INNER JOIN fornecedores ON (controles.fornecedor = fornecedores.id)")->fetchAll(\PDO::FETCH_ASSOC);
    }

	public function queryAllOrderBy($orderColumn)
    {
        return $this->db->query("SELECT controles.*, fornecedores.nome FROM controles INNER JOIN fornecedores ON (controles.fornecedor = fornecedores.id) ORDER BY {$orderColumn}")->fetchAll(\PDO::FETCH_ASSOC);
    }

	public function delete($id)
    {
        return $this->db->query("DELETE FROM controles WHERE id = {$id}")->fetch(\PDO::FETCH_ASSOC);
    }

	public function salvar(Model $obj)
    {

        $idControle    = $obj->getId();
        $data          = $obj->getData();
        $fornecedor    = $obj->getFornecedor()->getId();

        if(empty($idControle))
            return $this->db->query("INSERT INTO controles SET data = '{$data}', fornecedor = '{$fornecedor}'");
        else
            return $this->db->query("UPDATE controles SET data = '{$data}', fornecedor = '{$fornecedor}' WHERE id = {$idControle}");

    }


}