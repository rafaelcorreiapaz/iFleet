$('[api-formulario-veiculo]').submit(function(e){
    e.preventDefault();
    $.post('api/action/Salvar/salvarVeiculo', $(this).find('input').serializeArray(), function(data){
        console.log(data);
    });
});

$('[api-formulario-controle]').submit(function(e){
    e.preventDefault();
    $.post('api/action/Salvar/salvarControle', $(this).find('input').serializeArray(), function(data){
        console.log(data);
    });
});

$('[api-formulario-marca]').submit(function(e){
    e.preventDefault();
    $.post('api/action/Salvar/salvarMarca', $(this).find('input').serializeArray(), function(data){
        console.log(data);
    });
});

$('[api-formulario-fornecedor]').submit(function(e){
    e.preventDefault();
    $.post('api/action/Salvar/salvarFornecedor', $(this).find('input').serializeArray(), function(data){
        console.log(data);
    });
});

$('[api-formulario-modelo]').submit(function(e){
    e.preventDefault();
    $.post('api/action/Salvar/salvarModelo', $(this).find('input').serializeArray(), function(data){
        console.log(data);
    });
});

if($('[api-formulario-controle]').length)
{

    $('#adicionarControle').click(function(e){
        e.preventDefault();
        var quantidadeControle = $('[api-controle]').length;
        $('[api-controle]').each(function(){
            if($(this).val().length !== 0)
                --quantidadeControle;
        });
        if(!quantidadeControle)
        {
            var row = '<tr>';
            $('[api-controle]').each(function(){
                row += '<td><input type="hidden" name="'+$(this).attr('name')+'[]" value="'+$(this).val()+'">'+$(this).val()+'</td>';
            });
            $('#tabelaControle tbody').prepend(row);
        }
    });
}

if($('[api-formulario-marca]').length)
{
    $.get('api/view/JSON/retornarMarcaPorId?id=' + $('input[name=id]').val(), function(obj){
        obj = JSON.parse(obj);
        for(var i in obj)
        {
            $('input[name='+i+']').val(obj[i]);
        }
    });
}

if($('[api-formulario-modelo]').length)
{
    $(document).ajaxStop(function(){
        $.get('api/view/JSON/retornarModeloPorId?id=' + $('input[name=id]').val(), function(obj){
            obj = JSON.parse(obj);
            for(var i in obj)
            {
                $('input[name='+i+']').val(obj[i]);
            }
        });
    });
}
