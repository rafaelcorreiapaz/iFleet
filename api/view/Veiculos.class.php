<?php

class Veiculos
{

    public function retornarVeiculosJSON()
    {
        $db = DB::getConnection();
        $arrayVeiculos = $db->query("SELECT * FROM veiculos")->fetchAll(PDO::FETCH_ASSOC);
        echo SystemHelper::arrayToJSON($arrayVeiculos);
    }

    public function retornarVeiculoJSON()
    {
        $db = DB::getConnection();
        $arrayVeiculo = $db->query("SELECT * FROM veiculos WHERE id = {$_GET["id"]}")->fetch(PDO::FETCH_ASSOC);
        echo SystemHelper::arrayToJSON($arrayVeiculo);
    }

}