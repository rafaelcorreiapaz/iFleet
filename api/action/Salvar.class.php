<?php

use model\ControleModel;
use model\ItemControleModel;
use model\FornecedorModel;
use model\MarcaModel;
use model\VeiculoModel;
use model\ModeloModel;

header('Content-type: application/json; charset=iso-8859-1');

class Salvar
{

    public function salvarControle()
    {
        $return = [];

        try
        {

            $controle = new ControleModel($_POST['id']);
            $controle->setData($_POST['data']);
            $controle->setFornecedor(new FornecedorModel($_POST['fornecedor']));

            if(is_array($_POST['veiculo']))
            {
                foreach($_POST['veiculo'] as $chave => $valor)
                {
                    $ItemControle = new ItemControleModel($_POST['itemcontrole'][$chave]);
                    $ItemControle->setVeiculo(new VeiculoModel($_POST['veiculo'][$chave]));
                    $ItemControle->setKilometroAtual($_POST['kilometro_atual'][$chave]);
                    $ItemControle->setCategoriaControle($_POST['categoria_controle'][$chave]);
                    $ItemControle->setQuantidade($_POST['quantidade'][$chave]);
                    $ItemControle->setValor($_POST['valor'][$chave]);

                    $controle->addItemControle($ItemControle);
                    unset($ItemControle);
                }
            }

            if($controle->salvar() === false)
                throw new Exception('Erro ao salvar controle');

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


    public function salvarFornecedor()
    {
        $return = [];

        try
        {

            $fornecedor = new FornecedorModel($_POST['id']);
            $fornecedor->setNome($_POST['nome']);
            $fornecedor->setCpfCnpj(DocumentoCadastroFactory::getObjeto($_POST['cpfcnpj']));
            if($fornecedor->salvar() === false)
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

            $marca = new MarcaModel($_POST['id']);
            $marca->setDescricao($_POST['descricao']);

            if($marca->salvar() === false)
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

    public function salvarModelo()
    {
        $return = [];
        try
        {

            $modelo = new ModeloModel($_POST['id']);
            $modelo->setDescricao($_POST['descricao']);
            $modelo->setMarca(new MarcaModel($_POST['marca']));

            if($modelo->salvar() === false)
                throw new Exception('Erro ao salvar modelo');

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

    public function salvarVeiculo()
    {
        $return = [];
        try
        {


            $veiculo = new VeiculoModel($_POST['id']);
            $veiculo->setPlaca($_POST['placa']);
            $veiculo->setKilometroInicial($_POST['kilometro_inicial']);
            $veiculo->setKilometroRevisao($_POST['kilometro_revisao']);
            $veiculo->setPeriodoRevisao($_POST['periodo_revisao']);
            $veiculo->setModelo(new ModeloModel($_POST['modelo']));

            if($veiculo->salvar() === false)
                throw new Exception('Erro ao salvar veículo');

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