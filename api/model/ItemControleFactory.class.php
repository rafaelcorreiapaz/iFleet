<?php

namespace model;

use model\controle\Abastecimento;
use model\controle\Manutencao;
use model\controle\Multa;
use model\controle\Revisao;

abstract class ItemControleFactory
{

    public static function criarControle($codigoControle)
    {
        if($codigoControle === 0)
            return new Abastecimento();
        elseif($codigoControle === 1)
            return new Manutencao();
        elseif($codigoControle === 2)
            return new Revisao();
        elseif($codigoControle === 3)
            return new Multa();
    }

}