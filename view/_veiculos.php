<center>
	<div class="ui compact tiny menu">
		<a href="?pagina=formulario-veiculo" class="item">
			<i class="add circle icon"></i>Novo
		</a>
		<a href='javascript: if(parseInt($("input[name=veiculo]:checked").val()) > 0) window.location.href = "?pagina=formulario-veiculo&id="+$("input[name=veiculo]:checked").val();' class="item">
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
			<th width="20%">Placa</th>
			<th>Modelo</th>
			<th>KM Inicial</th>
			<th>KM Revisao</th>
			<th>Período Revisao</th>
		</tr>
	</thead>
	<tbody api-data="api/view/JSON/retornarVeiculos">
		<tr>
			<td class="collapsing">
				<div class="ui radio checkbox">
					<input type="radio" name="veiculo" value="(id)" class="hidden"><label></label>
				</div>
			</td>
			<td>(placa)</td>
			<td>(descricao_modelo)</td>
			<td>(kilometro_inicial)</td>
			<td>(kilometro_revisao)</td>
			<td>(periodo_revisao)</td>
		</tr>
	</tbody>
</table>