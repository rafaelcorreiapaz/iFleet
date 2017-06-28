<h4 class="ui horizontal divider header">
	<i class="browser icon"></i>
	Formul�rio Usu�rio
</h4>
<form class="ui form" api-formulario-usuario><input type="hidden" name="id" value="<?=isset($_GET['id']) ? $_GET['id'] : ''?>">
	<div class="field">
		<label>Nome</label>
		<input type="text" name="nome" placeholder="Nome" value="" required>
	</div>
	<div class="field">
		<label>Usu�rio</label>
		<input type="text" name="usuario" placeholder="Usu�rio" value="" pattern="[a-z]{6,32}" required>
	</div>
	<div class="field">
		<label>Senha </label>
		<input type="password" name="senha" placeholder="Senha (somente n�meros)" value="" pattern="[0-9a-z]{6,32}" required>
	</div>
	<button class="ui olive fluid button" type="submit">Salvar</button>
</form>