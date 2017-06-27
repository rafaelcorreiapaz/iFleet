<?php

class MailAdapter
{
	
	private $mail;

	public function __construct()
	{
		$this->mail = new Mail();
		$this->mail->setarRemetente('contato@jupiter.com.br', 'Sistema iFleet');
	}

	public function enviarEmail($email, $texto, $assunto = '')
	{
		$this->mail->enviarEmail($email, $texto, $assunto);
	}



}

