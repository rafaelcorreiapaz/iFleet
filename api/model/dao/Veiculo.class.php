<?php

namespace model\dao;

use model\DAO;
use model\VeiculoModel;

class Veiculo implements DAO
{

    private $db;

    public function __construct()
    {
        $this->db = DB::getConnection();
    }

    public function load($id)
    {
        return $this->db->query("SELECT * FROM veiculos WHERE id = {$id}")->fetch(\PDO::FETCH_ASSOC);
    }

	public function queryAll()
    {
        return $this->db->query("SELECT * FROM veiculos")->fetchAll(\PDO::FETCH_ASSOC);
    }

	public function queryAllOrderBy($orderColumn)
    {
        return $this->db->query("SELECT * FROM veiculos ORDER BY {$orderColumn}")->fetchAll(\PDO::FETCH_ASSOC);
    }

	public function delete($id)
    {
        return $this->db->query("DELETE FROM veiculos WHERE id = {$id}")->fetch(\PDO::FETCH_ASSOC);
    }

	public function salvar(VeiculoModel $obj)
    {
        $id               = $obj->getId();
        $placa            = $obj->getPlaca();
        $modelo           = $obj->getModelo()->getId();
        $kilometro_inical = $obj->getKilometroInicial();

        if(empty($id))
            return $this->db->query("INSERT INTO marcas SET nome = '{$nome}', placa = '{$placa}', modelo = '{$modelo}', kilometro_inical = '{$kilometro_inical}'");
        else
            return $this->db->query("UPDATE marcas SET nome = '{$nome}', placa = '{$placa}', modelo = '{$modelo}', kilometro_inical = '{$kilometro_inical}' WHERE id = {$id}");
    }

}