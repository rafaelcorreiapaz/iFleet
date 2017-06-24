<?php

class Modelos
{

    public function retornarModelosJSON()
    {
        $db = DB::getConnection();
        $arrayModelos = $db->query("SELECT * FROM modelos")->fetchAll(PDO::FETCH_ASSOC);
        echo SystemHelper::arrayToJSON($arrayModelos);
    }

    public function retornarModeloJSON()
    {
        $db = DB::getConnection();
        $arrayModelo = $db->query("SELECT * FROM modelos WHERE id = {$_GET["id"]}")->fetch(PDO::FETCH_ASSOC);
        echo SystemHelper::arrayToJSON($arrayModelo);
    }


}