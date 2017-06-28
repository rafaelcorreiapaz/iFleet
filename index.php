<!DOCTYPE html>
<?php
	include_once "api/SystemLibrary.php";
?>
<html>
	<head>
		<meta charset="iso-8859-1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>iFleet - Sistema de Controle de Frotas</title>
		<link rel="stylesheet" type="text/css" href="semantic/semantic.min.css">
		<link rel="stylesheet" type="text/css" href="css/545,45417,545487.css">
	</head>
	<body>
		<div class="ui success basic modal">
			<div class="ui icon header"><i class="checkmark icon"></i></div>
			<div class="content" style="text-align: center"></div>
		</div>
		<div class="ui error basic modal">
			<div class="ui icon header"><i class="remove circle icon"></i></div>
			<div class="content" style="text-align: center"></div>
		</div>
		</div>
		<div class="ui container">
			<br>
			<div class="ui secondary menu">
				<div class="header item">iFleet - Sistema de Controle de Frota</div>
				<div class="right menu">
					<a class="ui item">Bem-vindo, <?=date('d/m/Y')?></a>
				</div>
			</div>
			<div class="ui divider"></div>
			<br>
			<div class="ui grid">
				<div class="four wide column">
					<div class="ui olive vertical pointing fluid menu">
						<div class="item">
							<div class="header"><i class="browser icon"></i> Cadastros</div>
							<div class="menu">
								<a href="?pagina=_controles" class="item<?=($_GET["pagina"] == "_controles" || $_GET["pagina"] == "formulario-controle" ? " active" : "")?>">Controles</a>
								<a href="?pagina=_fornecedores" class="item<?=($_GET["pagina"] == "_fornecedores" || $_GET["pagina"] == "formulario-fornecedor" ? " active" : "")?>">Fornecedores</a>
								<a href="?pagina=_marcas" class="item<?=($_GET["pagina"] == "_marcas" || $_GET["pagina"] == "formulario-marca" ? " active" : "")?>">Marcas</a>
								<a href="?pagina=_modelos" class="item<?=($_GET["pagina"] == "_modelos" || $_GET["pagina"] == "formulario-modelo" ? " active" : "")?>">Modelos</a>
								<a href="?pagina=_veiculos" class="item<?=($_GET["pagina"] == "_veiculos" || $_GET["pagina"] == "formulario-veiculo" ? " active" : "")?>">Ve�culos</a>
							</div>
						</div>
						<div class="item">
							<div class="header"><i class="bar chart icon"></i> Relat�rios</div>
							<div class="menu">
								<a href="?pagina=relatorio-controles" class="item<?=($_GET["pagina"] == "relatorio-controles" ? " active" : "")?>">Controles</a>
							</div>
						</div>
					</div>
				</div>
				<div class="twelve wide column">
					<?php
						$arquivo  = "view/{$_GET["pagina"]}.php";
						if(file_exists($arquivo))
							include_once $arquivo;
					?>
				</div>
			</div>
		</div>
		<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
		<script src="semantic/semantic.min.js"></script>
		<script src="js/app.js"></script>
	</body>
</html>