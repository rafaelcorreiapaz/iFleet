<div class="ui menu">
	<div class="ui category search item">
		<div class="ui transparent icon input">
			<input class="prompt" type="text" placeholder="Search animals...">
			<i class="search link icon"></i>
		</div>
		<div class="results"></div>
	</div>

	<div class="right menu">

		<a href="?pagina=formulario-controle" class="item">
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
			<th>Data</th>
			<th>Fornecedor</th>
		</tr>
	</thead>
	<tbody api-data="api/view/Controles/retornarControlesJSON">
		<tr>
			<td class="collapsing">
				<div class="ui radio checkbox">
					<input type="radio" name="controle" tabindex="0" class="hidden"><label></label>
				</div>
			</td>
			<td>(data)</td>
			<td></td>
		</tr>
	</tbody>
</table>