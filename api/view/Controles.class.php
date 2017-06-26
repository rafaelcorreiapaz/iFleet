<?php

use model\CategoriaControle;

class Controles
{

    public function retornarControlesJSON()
    {
        $db = DB::getConnection();
        $arrayControles = $db->query("SELECT * FROM controles")->fetchAll(PDO::FETCH_ASSOC);
        echo SystemHelper::arrayToJSON($arrayControles);
    }

    public function retornarCategoriasControleJSON()
    {
        echo SystemHelper::arrayToJSON(SystemConfig::getData('controles'));
    }

    public function retornarControleJSON()
    {
        $db = DB::getConnection();
        $arrayControle = $db->query("SELECT * FROM controles WHERE id = {$_GET["id"]}")->fetch(PDO::FETCH_ASSOC);
        echo SystemHelper::arrayToJSON($arrayControle);
    }


}