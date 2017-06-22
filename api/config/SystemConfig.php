<?php

	$db = DB::getConection();

	// Configura��o de cada schema
	$sqlDados = "SELECT pessoas.nome, pessoas.nomefantasia, pessoas.cnpjcpf, pessoas.inscricaoestadual, pessoas.passaporterg, pessoas.orgaoemissor, pessoas.datanascimento, pessoas.pai, pessoas.mae, pessoas.profissao, pessoas.estadocivil, pessoas.nacionalidade, enderecos.logradouro, enderecos.numero, enderecos.complemento, enderecos.cep, bairros.nome AS bairro, localidades.nome AS localidade, ufs.sigla AS estado, array_to_json(array(SELECT CONCAT(tipo::text, ',', contato::text) FROM contatos WHERE contatos.pessoa = pessoas.id ORDER BY tipo)) AS contatos FROM pessoas INNER JOIN enderecos ON (pessoas.endereco = enderecos.id) INNER JOIN bairros ON (bairros.id = enderecos.bairro) INNER JOIN localidades ON (localidades.id = bairros.localidade) INNER JOIN ufs ON (localidades.estado = ufs.codigo) WHERE cnpjcpf = '%s'";
	$SystemConfig["scm"] = $db->query(sprintf($sqlDados, "01625636000191"))->fetch(PDO::FETCH_ASSOC);

	$SystemConfig["_imperatriz"]["entidade"] = "J�piter Imperatriz";
	$SystemConfig["_imperatriz"]["localidade"] = "Imperatriz-MA";
	$SystemConfig["_imperatriz"]["timezone"] = "America/Belem";
	$SystemConfig["_imperatriz"]["sva"]      = $db->query(sprintf($sqlDados, "09095302000165"))->fetch(PDO::FETCH_ASSOC);
	$SystemConfig["_imperatriz"]["codigo"]   = "2";
	$SystemConfig["_imperatriz"]["bancoPadrao"] = 104;

	$SystemConfig["_acailandia"]["entidade"] = "J�piter A�ail�ndia";
	$SystemConfig["_acailandia"]["localidade"] = "A�ail�ndia-MA";
	$SystemConfig["_acailandia"]["timezone"] = "Etc/GMT-2";
	$SystemConfig["_acailandia"]["sva"]      = $db->query(sprintf($sqlDados, "05833778000103"))->fetch(PDO::FETCH_ASSOC);
	$SystemConfig["_acailandia"]["codigo"]   = "3";
	$SystemConfig["_acailandia"]["bancoPadrao"] = 1;

	$SystemConfig["_grajau"]["entidade"] = "J�piter Graja�";
	$SystemConfig["_grajau"]["localidade"] = "Graja�-MA";
	$SystemConfig["_grajau"]["timezone"] = "America/Belem";
	$SystemConfig["_grajau"]["sva"]      = $SystemConfig["_imperatriz"]["sva"];
	$SystemConfig["_grajau"]["codigo"]   = "4";
	$SystemConfig["_grajau"]["bancoPadrao"] = 1;

	$SystemConfig["_maraba"]["entidade"] = "J�piter Marab�";
	$SystemConfig["_maraba"]["localidade"] = "Marab�-PA";
	$SystemConfig["_maraba"]["timezone"] = "America/Belem";
	$SystemConfig["_maraba"]["sva"]      = $SystemConfig["_imperatriz"]["sva"];
	$SystemConfig["_maraba"]["codigo"]   = "5";
	$SystemConfig["_maraba"]["bancoPadrao"] = 1;

	$SystemConfig["treinamento"]["entidade"] = "J�piter Treinamento";
	$SystemConfig["treinamento"]["localidade"] = "Imperatriz-MA";
	$SystemConfig["treinamento"]["timezone"] = "America/Belem";
	$SystemConfig["treinamento"]["sva"]      = $SystemConfig["_imperatriz"]["sva"];
	$SystemConfig["treinamento"]["codigo"]   = "6";
	$SystemConfig["treinamento"]["bancoPadrao"] = 1;

	$SystemConfig["projetoboer"]["entidade"] = "Projeto Boer";
	$SystemConfig["projetoboer"]["localidade"] = "Imperatriz-MA";
	$SystemConfig["projetoboer"]["timezone"] = "America/Belem";
	$SystemConfig["projetoboer"]["sva"]      = $SystemConfig["_imperatriz"]["sva"];
	$SystemConfig["projetoboer"]["codigo"]   = "7";
	$SystemConfig["projetoboer"]["bancoPadrao"] = 1;

	$SystemConfig["_parauapebas"]["entidade"] = "J�piter Parauapebas";
	$SystemConfig["_parauapebas"]["localidade"] = "Imperatriz-MA";
	$SystemConfig["_parauapebas"]["timezone"] = "America/Belem";
	$SystemConfig["_parauapebas"]["sva"]      = $SystemConfig["_imperatriz"]["sva"];
	$SystemConfig["_parauapebas"]["codigo"]   = "8";
	$SystemConfig["_parauapebas"]["bancoPadrao"] = 1;

	// Vari�veis
	$SystemConfig["comoVoceConheceu"]         = ["TV", "R�dio", "Jornal/Revista", "Banner Web", "Redes sociais na web", "Conhecidos/colegas/amigos", "Outdoor/faixas/cartazes"];
	$SystemConfig["estadoCivil"]              = ["Solteiro(a)", "Casado(a)", "Divorciado(a)", "Vi�vo(a)"];
	$SystemConfig["formaDePagamento"]         = ["P�s-pago", "Pr�-pago"];
	$SystemConfig["tipoOrdemDeServico"]       = [1 => "Sem conex�o", 2 => "Conex�o lenta", 3 => "Visada", 4 => "Configura��o", 5 => "Instala��o", 6 => "Pede usu�rio e senha", 7 => "Problema no e-mail", 8 => "Cancelamento", 9 => "Ativa��o", 10 => "Mudan�a de Equipamento", 11 => "Suspender", 12 => "Alterar Velocidade", 13 => "Adicionar M�quina", 14 => "Remover M�quina", 16 => "Or�amento", 17 => "Manuten��o", 18 => "Sobreaviso", 19 => "Remo��o Equipamento RC", 20 => "Rede em Manuten��o", 21 => "Extens�o e ativa��o de rede �ptica", 22 => "Estrutura"];
	$SystemConfig["statusOrdemDeServico"]     = ["Em Andamento", "Pendente", "Conclu�do"];
	$SystemConfig["tipoDeFolhaDePagamento"]   = ['Folha de Sal�rio', 'Folha de Adiantamento', 'Folha Complementar', 'Folha de F�rias', 'Fixo', 'Provis�o de F�rias', 'Provis�o de 13�', 'Rescis�o', 'D�cimo Terceiro', 'Folha de Sal�rio Estagi�rio'];
	$SystemConfig["tipoConexao"]              = ["Via R�dio", "Via Cabo Lan", "Via Fibra", "Via ADSL"];
	$SystemConfig["tipoContato"]              = [-1 => "Contato", "Celular", "Residencial", "Fax", "Comercial", "Suporte", "E-mail"];
	$SystemConfig["motivoCancelamentoBoleto"] = [0 => 'Suspens�o solicita��o do Cliente', 1 => 'Cancelamento solicita��o do Cliente', 2 => 'Suspens�o por inadmpl�ncia', 3 => 'Suspens�o por problema t�cnico', 4 => 'Cancelamento por problema t�cnico', 5 => 'Mudou para permuta', 6 => 'Gerado indevido', 7 => 'Cliente em �bito', 8 => 'Desconto autom�tico por cancelamento de contrato'];
	$SystemConfig["motivoDescontoBoleto"]     = [0 => 'Desconto por dias proporcionais'];
	$SystemConfig["statusAtencimentoOS"]      = ['Pendente', 'Conclu�do'];
	$SystemConfig["solucaoPendenciaStatus"]   = [['', 'Equipamento com defeito','N�o resolveu o problema','N�o encontrou endere�o','Cliente n�o estava em casa','N�o prestou servi�o','Cliente n�o quer atendimento','Ordem remarcada','Rede em manuten��o'],['', 'Configura��o no roteador','Trocou ONU','Sinal ruim','Ajustou/trocou conector','Fibra quebrada','Fonte com problema','Alinhamento do r�dio','R�dio queimado','N�vel de interfer�ncia','Sem visada/visada prec�ria','Cabo lan com problema','Configura��o do r�dio','Firmware','V�rus', 'Instala��o realizada','ONU reconfigurada']];


	$SystemConfig["caixa"]["codigo"] = "104";
	$SystemConfig["caixa"]["agencia"] = "0644";
	$SystemConfig["caixa"]["cedente"] = $db->query(sprintf($sqlDados, "01625636000191"))->fetch(PDO::FETCH_ASSOC)["nome"];
	$SystemConfig["caixa"]["codigo_cedente"] = "022705";
	$SystemConfig["caixa"]["dv_codigo_cedente"] = "6";
	$SystemConfig["caixa"]["moeda"] = "9";
	$SystemConfig["caixa"]["carteira"] = "1";
	$SystemConfig["caixa"]["especie"] = "R$";
	$SystemConfig["caixa"]["local_pagamento"] = "PAGAR PREFERENCIALMENTE NAS CASAS LOT�RICAS AT� O VALOR LIMITE";
	$SystemConfig["caixa"]["logo"] = "imagens/logocaixa.jpg";

	$SystemConfig["bb"]["codigo"] = "001";
	$SystemConfig["bb"]["agencia"] = "0554";
	$SystemConfig["bb"]["cedente"] = $SystemConfig["caixa"]["cedente"];
	$SystemConfig["bb"]["codigo_cedente"] = "10456";
	$SystemConfig["bb"]["dv_codigo_cedente"] = "6";
	$SystemConfig["bb"]["moeda"] = "9";
	$SystemConfig["bb"]["carteira"] = "17";
	$SystemConfig["bb"]["especie"] = "R$";
	$SystemConfig["bb"]["local_pagamento"] = "PAG�VEL EM QUALQUER BANCO AT� O VENCIMENTO";
	$SystemConfig["bb"]["convenio"] = "2978115";
	$SystemConfig["bb"]["logo"] = "imagens/bb.jpg";
