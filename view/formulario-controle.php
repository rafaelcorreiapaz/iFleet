<h4 class="ui horizontal divider header">
	<i class="tag icon"></i> Formulario Controle
</h4>
<form class="ui form" if-data="api/view/Controle/retornarControleJSON?id=">
	<div class="field">
		<label>Data</label>
		<input type="text" name="data" placeholder="Data" value="">
	</div>
	<div class="field">
		<label>Fornecedor</label>
		<div class="ui selection dropdown">
			<input type="hidden" name="fornecedor">
			<i class="dropdown icon"></i>
			<div class="default text">Fornecedor</div>
			<div class="menu" api-data="api/view/Fornecedores/retornarFornecedoresJSON">
				<div class="item" data-value="(id)">(nome)</div>
			</div>
		</div>
	</div>
	<div class="five fields">
		<div class="field">
			<label>Controle</label>
			<input type="text" placeholder="Controle">
		</div>
		<div class="field">
			<label>Quantidade</label>
			<input type="text" placeholder="Quantidade">
		</div>
		<div class="field">
			<label>Descrição</label>
			<input type="text" placeholder="Descrição">
		</div>
		<div class="field">
			<label>Valor</label>
			<input type="text" placeholder="Valor">
		</div>
		<div class="field">
			<label>&nbsp;</label>
			<button class="ui olive fluid button" type="submit">Adicionar</button>
		</div>
	</div>
	<table class="ui single line table">
		<thead>
			<tr>
				<th>Controle</th>
				<th>Quantidade</th>
				<th>Valor</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>

	<button class="ui teal fluid button" type="submit">Salvar</button>
</form>