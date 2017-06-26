<h4 class="ui horizontal divider header">
	<i class="tag icon"></i> Formulario Controle
</h4>
<form class="ui form" api-formulario-controle>
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
	<div class="six fields">
		<div class="field">
			<label>Veículo</label>
			<div class="ui fluid selection dropdown">
				<input type="hidden" api-controle name="veiculo">
				<i class="dropdown icon"></i>
				<div class="default text">Veículo</div>
				<div class="menu" api-data="api/view/Veiculos/retornarVeiculosJSON">
					<div class="item" data-value="(id)">(placa)</div>
				</div>
			</div>
		</div>
		<div class="field">
			<label>KM Atual</label>
			<input type="text" api-controle name="kilometro_atual" placeholder="KM Atual">
		</div>
		<div class="field">
			<label>Controle</label>
			<div class="ui fluid selection dropdown">
				<input type="hidden" api-controle name="controle">
				<i class="dropdown icon"></i>
				<div class="default text">Controle</div>
				<div class="menu" api-data="api/view/Controles/retornarCategoriasControleJSON">
					<div class="item" data-value="(id)">(valor)</div>
				</div>
			</div>
		</div>
		<div class="field">
			<label>Quantidade</label>
			<input type="text" api-controle name="quantidade" placeholder="Quantidade">
		</div>
		<div class="field">
			<label>Valor</label>
			<input type="text" api-controle name="valor" placeholder="Valor">
		</div>
		<div class="field">
			<label>&nbsp;</label>
			<button class="ui olive fluid button" id="adicionarControle">Adicionar</button>
		</div>
	</div>
	<table id="tabelaControle" class="ui single line table">
		<thead>
			<tr>
				<th>Veículo</th>
				<th>KM Atual</th>
				<th>Controle</th>
				<th>Quantidade</th>
				<th>Valor</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>

	<button class="ui olive fluid button" type="submit">Salvar</button>
</form>