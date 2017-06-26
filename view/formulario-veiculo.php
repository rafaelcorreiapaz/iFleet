<h4 class="ui horizontal divider header">
<i class="tag icon"></i>
Formulário Veículo
</h4>
<form class="ui form" api-formulario-veiculo><input type="hidden" name="id" value="<?=isset($_GET['id']) ? $_GET['id'] : ''?>">
	<div class="field">
		<label>Placa</label>
		<input type="text" name="placa" maxlength="7" required="" pattern="\w{3}\d{4}" placeholder="Placa" value="">
	</div>
	<div class="field">
		<label>KM Inicial</label>
		<input type="text" name="kilometro_inicial" placeholder="KM Inicial" value="">
	</div>
	<div class="field">
		<label>KM Revisão</label>
		<input type="text" name="kilometro_revisao" placeholder="KM Revisão" value="">
	</div>
	<div class="field">
		<label>Período Revisão (meses) </label>
		<input type="text" name="periodo_revisao" placeholder="Período Revisão" value="">
	</div>
	<div class="field">
		<label>Modelo</label>
		<div class="ui selection dropdown">
			<input type="hidden" riquired="required" name="modelo">
			<i class="dropdown icon"></i>
			<div class="default text">Modelo</div>
			<div class="menu" api-data="api/view/JSON/retornarModelos">
				<div class="item" data-value="(id)">(descricao)</div>
			</div>
		</div>
	</div>
	<button class="ui olive fluid button" type="submit">Salvar</button>
</form>