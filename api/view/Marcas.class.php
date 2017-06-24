<?php

class Marcas
{

    public function retornarMarcasJSON()
    {
        $db = DB::getConnection();
        $arrayMarcas = $db->query("SELECT * FROM marcas")->fetchAll(PDO::FETCH_ASSOC);
        echo SystemHelper::arrayToJSON($arrayMarcas);
    }

    public function retornarMarcaJSON()
    {
        $db = DB::getConnection();
        $arrayMarca = $db->query("SELECT * FROM marcas WHERE id = {$_GET["id"]}")->fetch(PDO::FETCH_ASSOC);
        echo SystemHelper::arrayToJSON($arrayMarca);
    }


}