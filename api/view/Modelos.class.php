<?php

class Modelos
{

    public function retornarModelosJSON()
    {
        $db = DB::getConnection();
        $arrayModelos = $db->query("SELECT * FROM modelos")->fetchAll(PDO::FETCH_ASSOC);
        echo SystemHelper::arrayToJSON($arrayModelos);
    }

}