<?php

use model\ItemControleFactory;

class Controle
{

    public function salvarControle()
    {
        var_dump(ItemControleFactory::criarControle(0));
        // echo SystemHelper::arrayToJSON($_POST);    
    }

}