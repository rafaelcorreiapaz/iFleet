<center>
	<div class="ui compact tiny menu">
		<a href="?pagina=formulario-fornecedor" class="item">
			<i class="add circle icon"></i>Novo
		</a>
		<a href='javascript: if(parseInt($("input[name=fornecedor]:checked").val()) > 0) window.location.href = "?pagina=formulario-fornecedor&id="+$("input[name=fornecedor]:checked").val();' class="item">
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
			<th>Fornecedor</th>
			<th>CPF/CNPJ</th>
		</tr>
	</thead>
	<tbody api-data="api/view/JSON/retornarFornecedores">
		<tr>
			<td class="collapsing">
				<div class="ui radio checkbox">
					<input type="radio" name="fornecedor" value="(id)" class="hidden"><label></label>
				</div>
			</td>
			<td>(nome)</td>
			<td>(cpfcnpj)</td>
		</tr>
	</tbody>
</table>