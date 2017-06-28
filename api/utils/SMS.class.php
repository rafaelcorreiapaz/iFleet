<?php

class SMS
{

	private $url   = "https://endpoint.jupiter.com/";
	private $token = "7b9e4ac60eb7c66e06592cee6dbd0c57";

	public function enviarSMS($phone, $texto)
	{
	    $ch =   curl_init();
	    curl_setopt($ch, CURLOPT_URL, $this->url);
	    curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['token' => $this->token, 'phone' => $phone, 'message' => $texto]));
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    $return = curl_exec($ch);
	    curl_close($ch);
	    // Converte os dados de JSON para ARRAY<
	    $dados = json_decode($return, true);
	    return $dados;
	}

}