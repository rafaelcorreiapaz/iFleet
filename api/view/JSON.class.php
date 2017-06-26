<?php

use model\dao\Marca;
use model\dao\Modelo;

class JSON
{
    public function retornarMarcaPorId()
    {
        $obj = new Marca();
        echo SystemHelper::arrayToJSON($obj->load($_GET['id']));
    }

    public function retornarModeloPorId()
    {
        $obj = new Modelo();
        echo SystemHelper::arrayToJSON($obj->load($_GET['id']));
    }

}