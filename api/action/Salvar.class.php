<?php

use model\FornecedorModel;
use model\dao\Fornecedor;
use model\MarcaModel;
use model\dao\Marca;

class Salvar
{

    public function salvarFornecedor()
    {
        $return = [];

        try
        {

            $fornecedor = new FornecedorModel();
            $fornecedor->setId($_POST['id']);
            $fornecedor->setNome($_POST['nome']);
            $fornecedor->setCpfCnpj($_POST['cpfcnpj']);

            $dao = new Fornecedor();
            if($dao->salvar($fornecedor) === false)
                throw new Exception('Erro ao salvar fornecedor');

            $return['success'] = true;
            $return['message'] = 'Salvo com sucesso';

        }
        catch(Exception $e)
        {
            $return['success'] = false;
            $return['message'] = $e->getMessage();

        }

        echo SystemHelper::arrayToJSON($return);
        

    }

    public function salvarMarca()
    {

        $return = [];

        try
        {

            $marca = new MarcaModel();
            $marca->setId($_POST['id']);
            $marca->setDescricao($_POST['descricao']);

            $dao = new Marca();
            if($dao->salvar($marca) === false)
                throw new Exception('Erro ao salvar marca');


            $return['success'] = true;
            $return['message'] = 'Salvo com sucesso';

        }
        catch(Exception $e)
        {
            $return['success'] = false;
            $return['message'] = $e->getMessage();

        }

        echo SystemHelper::arrayToJSON($return);


    }


}