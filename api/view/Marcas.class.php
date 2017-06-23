<?php

class Marcas
{

    public function retornarMarcasJSON()
    {
        $db = DB::getConnection();
        $arrayMarcas = $db->query("SELECT * FROM marcas")->fetchAll(PDO::FETCH_ASSOC);
        echo SystemHelper::arrayToJSON($arrayMarcas);
    }

}