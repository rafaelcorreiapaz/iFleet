<?php

class SMS
{

	private function $url   = "https://endpoint.jupiter.com.br/";
	private function $token = "7b9e4ac60eb7c66e06592cee6dbd0c57";

	public function enviarSMS($texto)
	{
	    $data = http_build_query($params);
	    $ch =   curl_init();
	    curl_setopt($ch, CURLOPT_URL, $this->url);
	    curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, ['token' => $this->token, 'message' => $texto]);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    $return = curl_exec($ch);
	    curl_close($ch);
	    // Converte os dados de JSON para ARRAY<
	    $dados = json_decode($return, true);
	    return $dados;
	}

}