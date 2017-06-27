<?php

use model\ControleModel;
use model\ItemControleModel;
use model\dao\Controle;

use model\FornecedorModel;
use model\dao\Fornecedor;

use model\MarcaModel;
use model\dao\Marca;

use model\VeiculoModel;
use model\dao\Veiculo;

use model\ModeloModel;
use model\dao\Modelo;

header('Content-type: application/json; charset=iso-8859-1');

class Salvar
{

    public function salvarControle()
    {
        $return = [];

        try
        {

            $fornecedor = new FornecedorModel();
            $fornecedor->setId($_POST['fornecedor']);

            $controle = new ControleModel();
            $controle->setId($_POST['id']);
            $controle->setData($_POST['data']);
            $controle->setFornecedor($fornecedor);

            if(is_array($_POST['veiculo']))
            {
                foreach($_POST['veiculo'] as $chave => $valor)
                {
                    $ItemControle = new ItemControleModel();
                    $ItemControle->setId($_POST['itemcontrole'][$chave]);
                    $ItemControle->setVeiculo($_POST['veiculo'][$chave]);
                    $ItemControle->setKilometroAtual($_POST['kilometro_atual'][$chave]);
                    $ItemControle->setCategoriaControle($_POST['categoria_controle'][$chave]);
                    $ItemControle->setQuantidade($_POST['quantidade'][$chave]);
                    $ItemControle->setValor($_POST['valor'][$chave]);

                    $controle->addItemControle($ItemControle);
                    unset($ItemControle);
                }
            }

            $controle->validar();

            $dao = new Controle();
            if($dao->salvar($controle) === false)
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

            $fornecedor = new FornecedorModel();
            $fornecedor->setId($_POST['id']);
            $fornecedor->setNome($_POST['nome']);

            $objCpfCnpj = DocumentoCadastroFactory::getObjeto($_POST['cpfcnpj']);
            $fornecedor->setCpfCnpj($objCpfCnpj);

            $fornecedor->validar();

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
            $marca->validar();

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

    public function salvarModelo()
    {
        $return = [];
        try
        {

            $marca = new MarcaModel();
            $marca->setId($_POST['marca']);

            $modelo = new ModeloModel();
            $modelo->setId($_POST['id']);
            $modelo->setDescricao($_POST['descricao']);
            $modelo->setMarca($marca);

            $modelo->validar();

            $dao = new Modelo();
            if($dao->salvar($modelo) === false)
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

            $modelo = new ModeloModel();
            $modelo->setId($_POST['modelo']);

            $veiculo = new VeiculoModel();
            $veiculo->setId($_POST['id']);
            $veiculo->setPlaca($_POST['placa']);
            $veiculo->setKilometroInicial($_POST['kilometro_inicial']);
            $veiculo->setKilometroRevisao($_POST['kilometro_revisao']);
            $veiculo->setPeriodoRevisao($_POST['periodo_revisao']);

            $veiculo->setModelo($modelo);

            $veiculo->validar();

            $dao = new Veiculo();
            if($dao->salvar($veiculo) === false)
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