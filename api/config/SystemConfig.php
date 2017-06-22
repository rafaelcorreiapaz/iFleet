<?php

	$db = DB::getConection();

	// Configuração de cada schema
	$sqlDados = "SELECT pessoas.nome, pessoas.nomefantasia, pessoas.cnpjcpf, pessoas.inscricaoestadual, pessoas.passaporterg, pessoas.orgaoemissor, pessoas.datanascimento, pessoas.pai, pessoas.mae, pessoas.profissao, pessoas.estadocivil, pessoas.nacionalidade, enderecos.logradouro, enderecos.numero, enderecos.complemento, enderecos.cep, bairros.nome AS bairro, localidades.nome AS localidade, ufs.sigla AS estado, array_to_json(array(SELECT CONCAT(tipo::text, ',', contato::text) FROM contatos WHERE contatos.pessoa = pessoas.id ORDER BY tipo)) AS contatos FROM pessoas INNER JOIN enderecos ON (pessoas.endereco = enderecos.id) INNER JOIN bairros ON (bairros.id = enderecos.bairro) INNER JOIN localidades ON (localidades.id = bairros.localidade) INNER JOIN ufs ON (localidades.estado = ufs.codigo) WHERE cnpjcpf = '%s'";
	$SystemConfig["scm"] = $db->query(sprintf($sqlDados, "01625636000191"))->fetch(PDO::FETCH_ASSOC);

	$SystemConfig["_imperatriz"]["entidade"] = "Júpiter Imperatriz";
	$SystemConfig["_imperatriz"]["localidade"] = "Imperatriz-MA";
	$SystemConfig["_imperatriz"]["timezone"] = "America/Belem";
	$SystemConfig["_imperatriz"]["sva"]      = $db->query(sprintf($sqlDados, "09095302000165"))->fetch(PDO::FETCH_ASSOC);
	$SystemConfig["_imperatriz"]["codigo"]   = "2";
	$SystemConfig["_imperatriz"]["bancoPadrao"] = 104;

	$SystemConfig["_acailandia"]["entidade"] = "Júpiter Açailândia";
	$SystemConfig["_acailandia"]["localidade"] = "Açailândia-MA";
	$SystemConfig["_acailandia"]["timezone"] = "Etc/GMT-2";
	$SystemConfig["_acailandia"]["sva"]      = $db->query(sprintf($sqlDados, "05833778000103"))->fetch(PDO::FETCH_ASSOC);
	$SystemConfig["_acailandia"]["codigo"]   = "3";
	$SystemConfig["_acailandia"]["bancoPadrao"] = 1;

	$SystemConfig["_grajau"]["entidade"] = "Júpiter Grajaú";
	$SystemConfig["_grajau"]["localidade"] = "Grajaú-MA";
	$SystemConfig["_grajau"]["timezone"] = "America/Belem";
	$SystemConfig["_grajau"]["sva"]      = $SystemConfig["_imperatriz"]["sva"];
	$SystemConfig["_grajau"]["codigo"]   = "4";
	$SystemConfig["_grajau"]["bancoPadrao"] = 1;

	$SystemConfig["_maraba"]["entidade"] = "Júpiter Marabá";
	$SystemConfig["_maraba"]["localidade"] = "Marabá-PA";
	$SystemConfig["_maraba"]["timezone"] = "America/Belem";
	$SystemConfig["_maraba"]["sva"]      = $SystemConfig["_imperatriz"]["sva"];
	$SystemConfig["_maraba"]["codigo"]   = "5";
	$SystemConfig["_maraba"]["bancoPadrao"] = 1;

	$SystemConfig["treinamento"]["entidade"] = "Júpiter Treinamento";
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

	$SystemConfig["_parauapebas"]["entidade"] = "Júpiter Parauapebas";
	$SystemConfig["_parauapebas"]["localidade"] = "Imperatriz-MA";
	$SystemConfig["_parauapebas"]["timezone"] = "America/Belem";
	$SystemConfig["_parauapebas"]["sva"]      = $SystemConfig["_imperatriz"]["sva"];
	$SystemConfig["_parauapebas"]["codigo"]   = "8";
	$SystemConfig["_parauapebas"]["bancoPadrao"] = 1;

	// Variáveis
	$SystemConfig["comoVoceConheceu"]         = ["TV", "Rádio", "Jornal/Revista", "Banner Web", "Redes sociais na web", "Conhecidos/colegas/amigos", "Outdoor/faixas/cartazes"];
	$SystemConfig["estadoCivil"]              = ["Solteiro(a)", "Casado(a)", "Divorciado(a)", "Viúvo(a)"];
	$SystemConfig["formaDePagamento"]         = ["Pós-pago", "Pré-pago"];
	$SystemConfig["tipoOrdemDeServico"]       = [1 => "Sem conexão", 2 => "Conexão lenta", 3 => "Visada", 4 => "Configuração", 5 => "Instalação", 6 => "Pede usuário e senha", 7 => "Problema no e-mail", 8 => "Cancelamento", 9 => "Ativação", 10 => "Mudança de Equipamento", 11 => "Suspender", 12 => "Alterar Velocidade", 13 => "Adicionar Máquina", 14 => "Remover Máquina", 16 => "Orçamento", 17 => "Manutenção", 18 => "Sobreaviso", 19 => "Remoção Equipamento RC", 20 => "Rede em Manutenção", 21 => "Extensão e ativação de rede óptica", 22 => "Estrutura"];
	$SystemConfig["statusOrdemDeServico"]     = ["Em Andamento", "Pendente", "Concluído"];
	$SystemConfig["tipoDeFolhaDePagamento"]   = ['Folha de Salário', 'Folha de Adiantamento', 'Folha Complementar', 'Folha de Férias', 'Fixo', 'Provisão de Férias', 'Provisão de 13º', 'Rescisão', 'Décimo Terceiro', 'Folha de Salário Estagiário'];
	$SystemConfig["tipoConexao"]              = ["Via Rádio", "Via Cabo Lan", "Via Fibra", "Via ADSL"];
	$SystemConfig["tipoContato"]              = [-1 => "Contato", "Celular", "Residencial", "Fax", "Comercial", "Suporte", "E-mail"];
	$SystemConfig["motivoCancelamentoBoleto"] = [0 => 'Suspensão solicitação do Cliente', 1 => 'Cancelamento solicitação do Cliente', 2 => 'Suspensão por inadmplência', 3 => 'Suspensão por problema técnico', 4 => 'Cancelamento por problema técnico', 5 => 'Mudou para permuta', 6 => 'Gerado indevido', 7 => 'Cliente em óbito', 8 => 'Desconto automático por cancelamento de contrato'];
	$SystemConfig["motivoDescontoBoleto"]     = [0 => 'Desconto por dias proporcionais'];
	$SystemConfig["statusAtencimentoOS"]      = ['Pendente', 'Concluído'];
	$SystemConfig["solucaoPendenciaStatus"]   = [['', 'Equipamento com defeito','Não resolveu o problema','Não encontrou endereço','Cliente não estava em casa','Não prestou serviço','Cliente não quer atendimento','Ordem remarcada','Rede em manutenção'],['', 'Configuração no roteador','Trocou ONU','Sinal ruim','Ajustou/trocou conector','Fibra quebrada','Fonte com problema','Alinhamento do rádio','Rádio queimado','Nível de interferência','Sem visada/visada precária','Cabo lan com problema','Configuração do rádio','Firmware','Vírus', 'Instalação realizada','ONU reconfigurada']];


	$SystemConfig["caixa"]["codigo"] = "104";
	$SystemConfig["caixa"]["agencia"] = "0644";
	$SystemConfig["caixa"]["cedente"] = $db->query(sprintf($sqlDados, "01625636000191"))->fetch(PDO::FETCH_ASSOC)["nome"];
	$SystemConfig["caixa"]["codigo_cedente"] = "022705";
	$SystemConfig["caixa"]["dv_codigo_cedente"] = "6";
	$SystemConfig["caixa"]["moeda"] = "9";
	$SystemConfig["caixa"]["carteira"] = "1";
	$SystemConfig["caixa"]["especie"] = "R$";
	$SystemConfig["caixa"]["local_pagamento"] = "PAGAR PREFERENCIALMENTE NAS CASAS LOTÉRICAS ATÉ O VALOR LIMITE";
	$SystemConfig["caixa"]["logo"] = "imagens/logocaixa.jpg";

	$SystemConfig["bb"]["codigo"] = "001";
	$SystemConfig["bb"]["agencia"] = "0554";
	$SystemConfig["bb"]["cedente"] = $SystemConfig["caixa"]["cedente"];
	$SystemConfig["bb"]["codigo_cedente"] = "10456";
	$SystemConfig["bb"]["dv_codigo_cedente"] = "6";
	$SystemConfig["bb"]["moeda"] = "9";
	$SystemConfig["bb"]["carteira"] = "17";
	$SystemConfig["bb"]["especie"] = "R$";
	$SystemConfig["bb"]["local_pagamento"] = "PAGÁVEL EM QUALQUER BANCO ATÉ O VENCIMENTO";
	$SystemConfig["bb"]["convenio"] = "2978115";
	$SystemConfig["bb"]["logo"] = "imagens/bb.jpg";
