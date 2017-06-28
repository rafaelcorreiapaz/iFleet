<?
if(isset($_GET['logout']))
{
	session_start();
	$_SESSION = [];
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="iso-8859-1">
		<title>IFleet > Sistema de Controle de Frotas</title>
		<link rel="stylesheet" type="text/css" href="semantic/semantic.min.css">
		<link rel="stylesheet" type="text/css" href="css/545,45417,545487.css">
		<style>

			.column
			{
				max-width: 450px;
			}

		</style>
	</head>
	<body>

		<div class="ui middle aligned center aligned grid">
			<div class="column">
				<h2 class="ui blue image header">
				<div class="content">
					Logar em sua conta
				</div>
				</h2>
				<form class="ui large form" id="formularioLoginUsuario" method="post" action="#">
					<div class="ui stacked segment">
						<div class="field">
							<div class="ui left icon input">
								<i class="user icon"></i>
								<input type="text" name="usuario" placeholder="Usuário" autofocus="" required>
							</div>
						</div>
						<div class="field">
							<div class="ui left icon input">
								<i class="lock icon"></i>
								<input type="password" name="senha" placeholder="Senha" required>
							</div>
						</div>
						<button class="ui fluid large blue submit button">Login</button>
					</div>
				</form>
				<div class="ui error message hidden"></div>
			</div>
		</div>


		<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
		<script src="semantic/semantic.min.js"></script>
		<script>
			$('#formularioLoginUsuario').submit(function(e){
				e.preventDefault();
				var formulario = $(this);
				$.post("api/action/Login/logar", $(this).find("input").serializeArray(), function(response){
					if(response.success == false)
						$(".ui.error.message").removeClass("hidden").html(response.message);
					else
						window.location.href = "painel.php";
				});
			});
		</script>

		
	</body>
</html>