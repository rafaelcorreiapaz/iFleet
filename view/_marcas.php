<div class="ui menu">

	<div class="right menu">

		<a href="?pagina=formulario-marca" class="item">
			<i class="add circle icon"></i>Novo
		</a>
		<a href='javascript: if(parseInt($("input[name=marca]:checked").val()) > 0) window.location.href = "?pagina=formulario-marca&id="+$("input[name=marca]:checked").val();' class="item">
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
