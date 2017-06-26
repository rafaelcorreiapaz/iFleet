<center>
    <div class="ui compact tiny menu">
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
</center>

<table class="ui olive single line table">
  <thead>
    <tr>
      <th></th>
      <th>Marca</th>
    </tr>
  </thead>
  <tbody api-data="api/view/JSON/retornarMarcas">
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
