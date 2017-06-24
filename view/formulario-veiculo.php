<h4 class="ui horizontal divider header">
	<i class="tag icon"></i>
	Formulário Veículo
</h4>
<form class="ui form">
	<div class="field">
		<label>Placa</label>
		<input type="text" name="placa" placeholder="Placa" value="">
	</div>
	<div class="field">
		<label>KM Inicial</label>
		<input type="text" name="kilometro_inicial" placeholder="KM Inicial" value="">
	</div>
	<div class="field">
		<label>Modelo</label>
		<div class="ui selection dropdown">
			<input type="hidden" name="modelo">
			<i class="dropdown icon"></i>
			<div class="default text">Modelo</div>
			<div class="menu" api-data="api/view/Modelos/retornarModelosJSON">
				<div class="item" data-value="(id)">(descricao)</div>
			</div>
		</div>
	</div>
	<button class="ui fluid button" type="submit">Salvar</button>
</form>