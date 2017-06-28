<h4 class="ui horizontal divider header">
<i class="browser icon"></i>
Formulário Fornecedor
</h4>
<form class="ui form" api-formulario-fornecedor><input type="hidden" name="id" value="<?=isset($_GET['id']) ? $_GET['id'] : ''?>">
<div class="field">
	<label>Nome</label>
	<input type="text" name="nome" placeholder="Nome" required>
</div>
<div class="field">
	<label>CPF/CNPJ</label>
	<input type="text" name="cpfcnpj" placeholder="CPF/CNPJ" pattern="[0-9]{11}|[0-9]{14}" required>
</div>
<button class="ui olive fluid button" type="submit">Salvar</button>
</form>