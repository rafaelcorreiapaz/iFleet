<h4 class="ui horizontal divider header">
<i class="tag icon"></i> Formulario Controle
</h4>
<form class="ui form" api-formulario-controle><input type="hidden" name="id" value="<?=isset($_GET['id']) ? $_GET['id'] : ''?>">
<div class="field">
	<label>Data</label>
	<input type="date" name="data" placeholder="Data" value="">
</div>
<div class="field">
	<label>Fornecedor</label>
	<div class="ui selection dropdown">
		<input type="hidden" name="fornecedor">
		<i class="dropdown icon"></i>
		<div class="default text">Fornecedor</div>
		<div class="menu" api-data="api/view/JSON/retornarFornecedores">
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
			<div class="menu" api-data="api/view/JSON/retornarVeiculos" api-key="veiculos">
				<div class="item" data-value="(id)">(placa)</div>
			</div>
		</div>
	</div>
	<div class="field">
		<label>KM Atual</label>
		<input type="text" api-controle name="kilometro_atual" placeholder="KM Atual">
	</div>
	<div class="field">
		<label>Cat. Controle</label>
		<div class="ui fluid selection dropdown">
			<input type="hidden" api-controle name="categoria_controle">
			<i class="dropdown icon"></i>
			<div class="default text">Cat. Controle</div>
			<div class="menu" api-data="api/view/JSON/retornarCategoriasControle" api-key="controles">
				<div class="item" data-value="(id)">(descricao)</div>
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
<table id="tabelaControle" class="ui editable single line table">
	<thead>
		<tr>
			<th width="25%">Veículo</th>
			<th>KM Atual</th>
			<th width="25%">Cat Controle</th>
			<th>Quantidade</th>
			<th width="15%">Valor</th>
		</tr>
	</thead>
	<tbody class="ui mini form" api-data="api/view/JSON/retornarItensControlePorControle?controle=<?=isset($_GET['id']) ? $_GET['id'] : ''?>">
		<tr>
			<td>
				<div class="field">
					<input type="hidden" name="itemcontrole[]" value="(id)">
					<select name="veiculo[]" api-data-local api-key="veiculos" api-selected="(veiculo)">
						<option value="(veiculos.id)">(veiculos.placa)</option>
					</select>
				</div>
			</td>
			<td>
				<div class="field"><input type="text" name="kilometro_atual[]" value="(kilometro_atual)"></div>
			</td>
			<td>
				<div class="field">
					<select name="categoria_controle[]" api-data-local api-key="controles" api-selected="(categoria_controle)">
						<option value="(controles.id)">(controles.descricao)</option>
					</select>
				</div>
			</td>
			<td>
				<div class="field"><input type="text" name="quantidade[]" value="(quantidade)"></div>
			</td>
			<td>
				<div class="field"><input type="text" name="valor[]" value="(valor)"></div>
			</td>
		</tr>
	</tbody>
	<tfoot class="full-width">
	<tr>
		<th colspan="4"></th>
		<th>
			<i class="user icon"></i> Add User
		</th>
	</tr>
	</tfoot>
</table>
<button class="ui olive fluid button" type="submit">Salvar</button>
</form>