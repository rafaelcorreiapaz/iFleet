<h4 class="ui horizontal divider header">
	<i class="tag icon"></i>
	Formul�rio Marca
</h4>
<form class="ui form" api-formulario-marca><input type="hidden" name="id" value="<?=isset($_GET['id']) ? $_GET['id'] : ''?>">
	<div class="field">
		<label>Descricao</label>
		<input type="text" name="descricao" placeholder="Descri��o" value="">
	</div>
	<button class="ui olive fluid button" type="submit">Salvar</button>
</form>