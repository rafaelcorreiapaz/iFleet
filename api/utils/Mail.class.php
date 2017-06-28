<?php

include_once 'PHPMailer/PHPMailerAutoload.php';

class Mail
{
	
	private $mail;

	public function __construct()
	{
		$this->mail = new PHPMailer();

		$this->mail->IsSMTP(); // Define que a mensagem será SMTP

		$this->mail->SMTPOptions = array(
		    'ssl' => array(
		        'verify_peer' => false,
		        'verify_peer_name' => false,
		        'allow_self_signed' => true
		    )
		);

		$this->mail->Host = "email.jupiter.com.br"; # Endereço do servidor SMTP
		// $this->mail->SMTPAuth = true; # Usar autenticação SMTP - Sim
		// $this->mail->Password = 'AsQz!@()'; # Senha do usuário de e-mail

		$this->mail->IsHTML(true); # Define que o e-mail será enviado como HTML
		$this->mail->CharSet = "UTF-8"; # Charset da mensagem (opcional)
	}

	public function setarRemetente($remetente, $nome = '')
	{
		$this->mail->Username = $remetente; # Usuário de e-mail
		$this->mail->From = $remetente; # Usuário de e-mail
		$this->mail->FromName = $nome; # Usuário de e-mail
	}

	public function enviarEmail($email, $texto, $assunto = '')
	{
		$this->mail->AddAddress($email);
		$this->mail->Subject = $assunto; # Assunto da mensagem
		$this->mail->Body = $mensagem;
	}

}