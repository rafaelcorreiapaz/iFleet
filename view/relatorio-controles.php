<h4 class="ui horizontal divider header">
<i class="bar chart icon"></i>
Formulário Controle
</h4>
<form action="api/view/PDF/retornarRelatorioControle" target="blank" class="ui equal width form">
	<div class="fields">
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
			<label>Categoria Controle</label>
			<div class="ui fluid selection dropdown">
				<input type="hidden" api-controle name="categoria_controle">
				<i class="dropdown icon"></i>
				<div class="default text">Categoria Controle</div>
				<div class="menu" api-data="api/view/JSON/retornarCategoriasControle" api-key="controles">
					<div class="item" data-value="(id)">(descricao)</div>
				</div>
			</div>
		</div>
		<div class="field">
			<label>Período Inicial</label>
			<input type="date" name="periodo_inicial" placeholder="Período Inicial">
		</div>
		<div class="field">
			<label>Período Final</label>
			<input type="date" name="periodo_final" placeholder="Período Final">
		</div>
	</div>
	<button class="ui olive fluid button" type="submit">Salvar</button>
</form>