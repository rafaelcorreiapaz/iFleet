<?php

class Veiculos
{

    public function retornarVeiculosJSON()
    {
        $db = DB::getConnection();
        $arrayVeiculos = $db->query("SELECT * FROM veiculos")->fetchAll(PDO::FETCH_ASSOC);
        echo SystemHelper::arrayToJSON($arrayVeiculos);
    }

}