<?php

namespace model\dao;

use model\DAO;
use model\Model;
use model\FornecedorModel;

class Fornecedor implements DAO
{

    private $db;

    public function __construct()
    {
        $this->db = \DB::getConnection();
    }

    public function load($id)
    {
        return $this->db->query("SELECT * FROM fornecedores WHERE id = {$id}")->fetch(\PDO::FETCH_ASSOC);
    }

	public function queryAll()
    {
        return $this->db->query("SELECT * FROM fornecedores")->fetchAll(\PDO::FETCH_ASSOC);
    }

	public function queryAllOrderBy($orderColumn)
    {
        return $this->db->query("SELECT * FROM fornecedores ORDER BY {$orderColumn}")->fetchAll(\PDO::FETCH_ASSOC);
    }

	public function delete($id)
    {
        return $this->db->query("DELETE FROM fornecedores WHERE id = {$id}")->fetch(\PDO::FETCH_ASSOC);
    }

	public function salvar(Model $obj)
    {
        $id      = $obj->getId();
        $nome    = $obj->getNome();
        $cpfcnpj = $obj->getCpfCnpj();
        if(empty($id))
            return $this->db->query("INSERT INTO fornecedores SET nome = '{$nome}', cpfcnpj = '{$cpfcnpj}'");
        else
            return $this->db->query("UPDATE fornecedores SET nome = '{$nome}', cpfcnpj = '{$cpfcnpj}' WHERE id = {$id}");
    }

}