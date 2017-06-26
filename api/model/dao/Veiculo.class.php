<?php

namespace model\dao;

use model\DAO;
use model\Model;
use model\VeiculoModel;

class Veiculo implements DAO
{

    private $db;

    public function __construct()
    {
        $this->db = \DB::getConnection();
    }

    public function load($id)
    {
        return $this->db->query("SELECT veiculos.*, modelos.descricao AS descricao_modelo FROM veiculos INNER JOIN modelos ON (veiculos.modelo = modelos.id) WHERE veiculos.id = {$id}")->fetch(\PDO::FETCH_ASSOC);
    }

	public function queryAll()
    {
        return $this->db->query("SELECT veiculos.*, modelos.descricao AS descricao_modelo FROM veiculos INNER JOIN modelos ON (veiculos.modelo = modelos.id)")->fetchAll(\PDO::FETCH_ASSOC);
    }

	public function queryAllOrderBy($orderColumn)
    {
        return $this->db->query("SELECT veiculos.*, modelos.descricao AS descricao_modelo FROM veiculos INNER JOIN modelos ON (veiculos.modelo = modelos.id) ORDER BY {$orderColumn}")->fetchAll(\PDO::FETCH_ASSOC);
    }

	public function delete($id)
    {
        return $this->db->query("DELETE FROM veiculos WHERE id = {$id}")->fetch(\PDO::FETCH_ASSOC);
    }

	public function salvar(Model $obj)
    {
        $id                = $obj->getId();
        $placa             = $obj->getPlaca();
        $modelo            = $obj->getModelo()->getId();
        $kilometro_inicial = $obj->getKilometroInicial();
        $kilometro_revisao = $obj->getKilometroRevisao();
        $periodo_revisao   = $obj->getPeriodoRevisao();

        if(empty($id))
            return $this->db->query("INSERT INTO veiculos SET placa = '{$placa}', modelo = '{$modelo}', kilometro_inicial = '{$kilometro_inicial}', kilometro_revisao = '{$kilometro_revisao}', periodo_revisao = '{$periodo_revisao}'");
        else
            return $this->db->query("UPDATE veiculos SET placa = '{$placa}', modelo = '{$modelo}', kilometro_inicial = '{$kilometro_inicial}', kilometro_revisao = '{$kilometro_revisao}', periodo_revisao = '{$periodo_revisao}' WHERE id = {$id}");
    }

}