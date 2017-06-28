<center>
<div class="ui compact tiny menu">
	<a href="?pagina=formulario-usuario" class="item">
		<i class="add circle icon"></i>Novo
	</a>
	<a href='javascript: if(parseInt($("input[name=usuario]:checked").val()) > 0) window.location.href = "?pagina=formulario-usuario&id="+$("input[name=usuario]:checked").val();' class="item">
		<i class="edit icon"></i>Editar
	</a>
</div>
</center>
<table class="ui olive single line table">
	<thead>
		<tr>
			<th></th>
			<th width="20%">Nome</th>
			<th>Usuario</th>
		</tr>
	</thead>
	<tbody api-data="api/view/JSON/retornarUsuarios">
		<tr>
			<td class="collapsing">
				<div class="ui radio checkbox">
					<input type="radio" name="usuario" value="(id)" class="hidden"><label></label>
				</div>
			</td>
			<td>(nome)</td>
			<td>(usuario)</td>
		</tr>
	</tbody>
</table>