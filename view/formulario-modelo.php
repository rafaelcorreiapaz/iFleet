<h4 class="ui horizontal divider header">
	<i class="tag icon"></i>
	Formul�rio Modelo
</h4>
<form class="ui form">
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
			<div class="menu" api-data="api/view/Marcas/retornarMarcasJSON">
				<div class="item" data-value="(id)">(descricao)</div>
			</div>
		</div>
	</div>
	<button class="ui fluid button" type="submit">Salvar</button>
</form>