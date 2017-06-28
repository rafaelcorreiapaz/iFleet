<?php

use model\UsuarioModel;

header('Content-type: application/json; charset=iso-8859-1');

class Login
{
	public function logar()
	{

        $return = [];
        try
        {
			$usuario = new UsuarioModel();
			$usuario->setUsuario($_POST['usuario']);

			if(!$usuario->verificarUsuarioESenha($_POST['usuario'], $_POST['senha']))
				throw new Exception("Usuário ou senha inválidos");

			$_SESSION = $_POST;

            $return['success'] = true;

        }
        catch(Exception $e)
        {
            $return['success'] = false;
            $return['message'] = $e->getMessage();
        }

        echo SystemHelper::arrayToJSON($return);



	}
}