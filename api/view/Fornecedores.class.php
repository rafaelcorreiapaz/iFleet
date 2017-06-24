<?php

class Fornecedores
{

    public function retornarFornecedoresJSON()
    {
        $db = DB::getConnection();
        $arrayFornecedores = $db->query("SELECT * FROM fornecedores")->fetchAll(PDO::FETCH_ASSOC);
        echo SystemHelper::arrayToJSON($arrayFornecedores);
    }

    public function retornarFornecedorJSON()
    {
        $db = DB::getConnection();
        $arrayFornecedor = $db->query("SELECT * FROM fornecedores WHERE id = {$_GET["id"]}")->fetch(PDO::FETCH_ASSOC);
        echo SystemHelper::arrayToJSON($arrayFornecedor);
    }

}