<div class="ui menu">
	<div class="ui category search item">
		<div class="ui transparent icon input">
			<input class="prompt" type="text" placeholder="Search animals...">
			<i class="search link icon"></i>
		</div>
		<div class="results"></div>
	</div>

	<div class="right menu">

		<a href="?pagina=formulario-marca" class="item">
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
      <th>Marca</th>
    </tr>
  </thead>
  <tbody api-data="api/view/Marcas/retornarMarcasJSON">
    <tr>
      <td class="collapsing">
				<div class="ui radio checkbox">
					<input type="radio" name="marca" value="(id)" class="hidden"><label></label>
				</div>
      </td>
      <td>(descricao)</td>
    </tr>
  </tbody>
</table>
