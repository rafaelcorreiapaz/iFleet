<center>
    <div class="ui compact tiny menu">
        <a href="?pagina=formulario-modelo" class="item">
            <i class="add circle icon"></i>Novo
        </a>
        <a href='javascript: if(parseInt($("input[name=modelo]:checked").val()) > 0) window.location.href = "?pagina=formulario-modelo&id="+$("input[name=modelo]:checked").val();' class="item">
            <i class="edit icon"></i>Editar
        </a>
    </div>
</center>
<table class="ui olive single line table">
    <thead>
        <tr>
            <th></th>
            <th>Modelo</th>
            <th>Marca</th>
        </tr>
    </thead>
    <tbody api-data="api/view/JSON/retornarModelos">
        <tr>
            <td class="collapsing">
                <div class="ui radio checkbox">
                    <input type="radio" name="modelo" value="(id)" class="hidden"><label></label>
                </div>
            </td>
            <td>(descricao)</td>
            <td>(descricao_marca)</td>
        </tr>
    </tbody>
</table>