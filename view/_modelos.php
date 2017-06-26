<div class="ui menu">
	<div class="right menu">

		<a href="?pagina=formulario-modelo" class="item">
			<i class="add circle icon"></i>Novo
		</a>
		<a href='javascript: if(parseInt($("input[name=modelo]:checked").val()) > 0) window.location.href = "?pagina=formulario-modelo&id="+$("input[name=modelo]:checked").val();' class="item">
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
      <th>Modelo</th>
      <th>Marca</th>
    </tr>
  </thead>
  <tbody api-data="api/view/Modelos/retornarModelosJSON">
    <tr>
      <td class="collapsing">
				<div class="ui radio checkbox">
					<input type="radio" name="modelo" value="(id)" class="hidden"><label></label>
				</div>
      </td>
      <td>(descricao)</td>
      <td></td>
    </tr>
  </tbody>
</table>
