<?php

use model\dao\Marca;
use model\dao\Modelo;
use model\dao\Fornecedor;
use model\dao\ItemControle;
use model\dao\Veiculo;
use model\dao\Controle;

abstract class Data
{

    protected function retornarMarcaPorId()
    {
        $obj = new Marca();
        return $obj->load($_GET['id']);
    }

    protected function retornarModeloPorId()
    {
        $obj = new Modelo();
        return $obj->load($_GET['id']);
    }

    protected function retornarFornecedorPorId()
    {
        $obj = new Fornecedor();
        return $obj->load($_GET['id']);
    }

    protected function retornarVeiculoPorId()
    {
        $obj = new Veiculo();
        return $obj->load($_GET['id']);
    }

    protected function retornarControlePorId()
    {
        $obj = new Controle();
        return $obj->load($_GET['id']);
    }

    protected function retornarControles()
    {
        $obj = new Controle();
        return $obj->queryAll();
    }

    protected function retornarFornecedores()
    {
        $obj = new Fornecedor();
        return $obj->queryAll();
    }

    protected function retornarMarcas()
    {
        $obj = new Marca();
        return $obj->queryAll();
    }

    protected function retornarModelos()
    {
        $obj = new Modelo();
        return $obj->queryAll();
    }

    protected function retornarVeiculos()
    {
        $obj = new Veiculo();
        return $obj->queryAll();
    }

    protected function retornarItensControlePorControle()
    {
        $_GET['controle'] = (int) $_GET['controle'];
        $obj = new ItemControle();
        return $obj->queryAllByControle($_GET['controle']);
    }

    protected function retornarCategoriasControle()
    {
        return SystemConfig::getData('controles');
    }


}