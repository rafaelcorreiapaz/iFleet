<h4 class="ui horizontal divider header">
	<i class="tag icon"></i>
	Formulário Fornecedor
</h4>
<form class="ui form"><input type="hidden" name="id" value="<?=isset($_GET['id']) ? $_GET['id'] : ''?>">
	<div class="field">
		<label>Nome</label>
		<input type="text" name="nome" placeholder="Nome" value="">
	</div>
	<div class="field">
		<label>CPF/CNPJ</label>
		<input type="text" name="cpfcnpj" placeholder="CPF/CNPJ" value="">
	</div>
	<button class="ui olive fluid button" type="submit">Salvar</button>
</form>