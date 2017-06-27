<center>
<div class="ui compact tiny menu">
	<a href="?pagina=formulario-controle" class="item">
		<i class="add circle icon"></i>Novo
	</a>
	<a href='javascript: if(parseInt($("input[name=controle]:checked").val()) > 0) window.location.href = "?pagina=formulario-controle&id="+$("input[name=controle]:checked").val();' class="item">
		<i class="edit icon"></i>Editar
	</a>
	<a href='javascript: if(parseInt($("input[name=controle]:checked").val()) > 0) window.open("api/view/PDF/retornarControle?id="+$("input[name=controle]:checked").val());' class="item">
		<i class="file text outline icon"></i>Emitir
	</a>
</div>
</center>
<table class="ui olive single line table">
	<thead>
		<tr>
			<th></th>
			<th>Data</th>
			<th>Fornecedor</th>
		</tr>
	</thead>
	<tbody api-data="api/view/JSON/retornarControles" api-key="controles">
		<tr>
			<td class="collapsing">
				<div class="ui radio checkbox">
					<input type="radio" name="controle" value="(id)" class="hidden"><label></label>
				</div>
			</td>
			<td>(id) - (data)</td>
			<td>(nome)</td>
		</tr>
	</tbody>
</table>