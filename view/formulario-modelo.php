<h4 class="ui horizontal divider header">
	<i class="browser icon"></i>
	Formul�rio Modelo
</h4>
<form class="ui form" api-formulario-modelo><input type="hidden" name="id" value="<?=isset($_GET['id']) ? $_GET['id'] : ''?>">
	<div class="field">
		<label>Descri��o</label>
		<input type="text" name="descricao" placeholder="Descri��o" value="">
	</div>
	<div class="field">
		<label>Marca</label>
		<div class="ui selection dropdown">
			<input type="hidden" name="marca">
			<i class="dropdown icon"></i>
			<div class="default text">Marca</div>
			<div class="menu" api-data="api/view/JSON/retornarMarcas">
				<div class="item" data-value="(id)">(descricao)</div>
			</div>
		</div>
	</div>
	<button class="ui olive fluid button" type="submit">Salvar</button>
</form>