<?php

class ComunicacaoFacade
{
	private $sms;
	private $mail;
	private $telegram;

	public function __construct()
	{
		$this->sms  = new SMS();
		$this->mail = new MailAdapter();
	}

	public function enviarMensagem($contato, $mensagem, $assunto = '')
	{
		if(filter_var($contato, FILTER_VALIDATE_EMAIL))
			$this->mail->enviarEmail($contato, $mensagem, $assunto);
		else if(preg_match('/^[0-9]{8,15}$/', $contato))
		{
			$this->sms->enviarSMS($contato, $mensagem);
		}
	}

}