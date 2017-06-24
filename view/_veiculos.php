<div class="ui menu">
	<div class="ui category search item">
		<div class="ui transparent icon input">
			<input class="prompt" type="text" placeholder="Search animals...">
			<i class="search link icon"></i>
		</div>
		<div class="results"></div>
	</div>

	<div class="right tiny menu">

		<a href="?pagina=formulario-veiculo" class="item">
			<i class="add circle icon"></i>Novo
		</a>
		<a class="item">
			<i class="edit icon"></i>Editar
		</a>
		<a class="item">
			<i class="erase icon"></i>Deletar
		</a>

	</div>
</div>

<table class="ui definition table">
  <thead>
    <tr>
      <th></th>
      <th>Placa</th>
      <th>Marca</th>
      <th>Modelo</th>
    </tr>
  </thead>
  <tbody api-data="api/view/Veiculos/retornarVeiculosJSON">
    <tr>
      <td class="collapsing">
				<div class="ui radio checkbox">
					<input type="radio" name="veiculo" class="hidden"><label></label>
				</div>
      </td>
      <td>(placa)</td>
      <td></td>
      <td></td>
    </tr>
  </tbody>
</table>
