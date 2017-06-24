<div class="ui menu">
	<div class="ui category search item">
		<div class="ui transparent icon input">
			<input class="prompt" type="text" placeholder="Search animals...">
			<i class="search link icon"></i>
		</div>
		<div class="results"></div>
	</div>

	<div class="right small menu">

		<a href="?pagina=formulario-fornecedor" class="item">
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
      <th>Fornecedor</th>
      <th>CPF/CNPJ</th>
    </tr>
  </thead>
  <tbody api-data="api/view/Fornecedores/retornarFornecedoresJSON">
    <tr>
      <td class="collapsing">
				<div class="ui radio checkbox">
					<input type="radio" name="fornecedor" tabindex="0" class="hidden"><label></label>
				</div>
      </td>
      <td>(nome)</td>
      <td>(cpfcnpj)</td>
    </tr>
  </tbody>
</table>
