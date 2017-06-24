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
	<div class="ui container">
		<br>
		<div class="ui secondary menu">
			<div class="header item">iFleet - Sistema de Controle de Frota</div>
			<div class="right menu">
				<div class="ui item">Admin</div>
				<div class="ui item">|</div>
				<a class="ui item">Logout</a>
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
							<a href="?pagina=_controles" class="item<?=($_GET["pagina"] == "_controles" ? " active" : "")?>">Controles</a>
							<a href="?pagina=_fornecedores" class="item<?=($_GET["pagina"] == "_fornecedores" ? " active" : "")?>">Fornecedores</a>
							<a href="?pagina=_marcas" class="item<?=($_GET["pagina"] == "_marcas" ? " active" : "")?>">Marcas</a>
							<a href="?pagina=_modelos" class="item<?=($_GET["pagina"] == "_modelos" ? " active" : "")?>">Modelos</a>
							<a href="?pagina=_veiculos" class="item<?=($_GET["pagina"] == "_veiculos" ? " active" : "")?>">Veículos</a>
						</div>
					</div>
					<div class="item">
						<div class="header"><i class="bar chart icon"></i> Relatórios</div>
						<div class="menu">
							<a href="?pagina=" class="item">Abastecimentos</a>
							<a href="?pagina=" class="item">Manutenção</a>
							<a href="?pagina=" class="item">Multas</a>
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
	<script>
		var regExp = /\(([^)]+)\)/g;
		$('[api-data]').each(function(){
			var el = $(this);
			ajax = $.get(el.attr('api-data'), function(obj){

				var html = el.html().trim();
				var matches = html.match(/\(([^()]+)\)/g);
				el.html('');

				obj = JSON.parse(obj);
				for(var i in obj)
				{
					var subs = html;
					for(var k in matches)
					{
						key = matches[k].match(/\((.*?)\)/)[1];
						subs = subs.replace(matches[k], obj[i][key]);
					}
					el.append(subs);
				}
			});
		});

		$(document).ajaxStop(function(){
			$('.ui.radio.checkbox').checkbox();
			$('.selection.dropdown').dropdown();
		});

	</script>

</body>

</html>