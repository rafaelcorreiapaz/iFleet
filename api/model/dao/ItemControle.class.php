<?php

namespace model\dao;

use model\DAO;
use model\Model;

class ItemControle implements DAO
{

    private $db;

    public function __construct()
    {
        $this->db = \DB::getConnection();
    }

    public function load($id)
    {
        return $this->db->query("SELECT itenscontrole.* FROM itenscontrole INNER JOIN controles ON (itenscontrole.controle = controles.id) WHERE itenscontrole.id = {$id}")->fetch(\PDO::FETCH_ASSOC);
    }

    public function queryAll()
    {
        return $this->db->query("SELECT itenscontrole.* FROM itenscontrole INNER JOIN controles ON (itenscontrole.controle = controles.id)")->fetchAll(\PDO::FETCH_ASSOC);
    }

	public function queryAllByControle($id)
    {
        return $this->db->query("SELECT itenscontrole.* FROM itenscontrole INNER JOIN controles ON (itenscontrole.controle = controles.id) WHERE itenscontrole.controle = {$id}")->fetchAll(\PDO::FETCH_ASSOC);
    }

	public function queryAllOrderBy($orderColumn, $arrayCriterio = [])
    {
        return $this->db->query("SELECT itenscontrole.* FROM itenscontrole INNER JOIN controles ON (itenscontrole.controle = controles.id) ". (count($arrayCriterio) > 0 ? ' WHERE ' . implode(' AND ', $arrayCriterio) : '') ." ORDER BY {$orderColumn}")->fetchAll(\PDO::FETCH_ASSOC);
    }

	public function delete($id)
    {
        return $this->db->query("DELETE FROM controles WHERE id = {$id}")->fetch(\PDO::FETCH_ASSOC);
    }

	public function salvar(Model $obj)
    {
        $id                 = $obj->getId();
        $veiculo            = $obj->getVeiculo()->getId();
        $kilometro_atual    = $obj->getKilometroAtual();
        $categoria_controle = $obj->getCategoriaControle();
        $controle           = $obj->getControle()->getId();
        $quantidade         = $obj->getQuantidade();
        $valor              = $obj->getValor();

        if(empty($id))
			return $this->db->query("INSERT INTO itenscontrole SET veiculo = '{$veiculo}', categoria_controle = '{$categoria_controle}', kilometro_atual = '{$kilometro_atual}', controle = '{$controle}', quantidade = '{$quantidade}', valor = '{$valor}'");
        else
            return $this->db->query("UPDATE itenscontrole SET veiculo = '{$veiculo}', categoria_controle = '{$categoria_controle}', kilometro_atual = '{$kilometro_atual}', controle = '{$controle}', quantidade = '{$quantidade}', valor = '{$valor}' WHERE id = {$id}");
    }

}