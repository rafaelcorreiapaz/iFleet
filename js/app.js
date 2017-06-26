var dataLocal = {};

$('[api-formulario-veiculo]').submit(function(e){
	e.preventDefault();
	$.post('api/action/Salvar/salvarVeiculo', $(this).find('input').serializeArray(), function(data){
		console.log(data);
		if(data.success == true)
		{
			$('.ui.success.basic.modal').find('.content').html(data.message);
			$('.ui.success.basic.modal').modal('show');
			setTimeout(function(){
				location.reload();
			}, 1000);
		}
		else
		{
			$('.ui.error.basic.modal').find('.content').html(data.message);
			$('.ui.error.basic.modal').modal('show');
		}
	});
});

$('[api-formulario-controle]').submit(function(e){
	e.preventDefault();
	$.post('api/action/Salvar/salvarControle', $('[api-formulario-controle] input,[api-formulario-controle] select').serializeArray(), function(data){
		if(data.success == true)
		{
			$('.ui.success.basic.modal').find('.content').html(data.message);
			$('.ui.success.basic.modal').modal('show');
			setTimeout(function(){
				location.reload();
			}, 1000);
		}
		else
		{
			$('.ui.error.basic.modal').find('.content').html(data.message);
			$('.ui.error.basic.modal').modal('show');
		}
	});
});

$('[api-formulario-marca]').submit(function(e){
	e.preventDefault();
	$.post('api/action/Salvar/salvarMarca', $(this).find('input').serializeArray(), function(data){
		if(data.success == true)
		{
			$('.ui.success.basic.modal').find('.content').html(data.message);
			$('.ui.success.basic.modal').modal('show');
			setTimeout(function(){
				location.reload();
			}, 1000);
		}
		else
		{
			$('.ui.error.basic.modal').find('.content').html(data.message);
			$('.ui.error.basic.modal').modal('show');
		}
	});
});

$('[api-formulario-fornecedor]').submit(function(e){
	e.preventDefault();
	$.post('api/action/Salvar/salvarFornecedor', $(this).find('input').serializeArray(), function(data){
		if(data.success == true)
		{
			$('.ui.success.basic.modal').find('.content').html(data.message);
			$('.ui.success.basic.modal').modal('show');
			setTimeout(function(){
				location.reload();
			}, 1000);
		}
		else
		{
			$('.ui.error.basic.modal').find('.content').html(data.message);
			$('.ui.error.basic.modal').modal('show');
		}
	});
});

$('[api-formulario-modelo]').submit(function(e){
	e.preventDefault();
	$.post('api/action/Salvar/salvarModelo', $(this).find('input').serializeArray(), function(data){
		if(data.success == true)
		{
			$('.ui.success.basic.modal').find('.content').html(data.message);
			$('.ui.success.basic.modal').modal('show');
			setTimeout(function(){
				location.reload();
			}, 1000);
		}
		else
		{
			$('.ui.error.basic.modal').find('.content').html(data.message);
			$('.ui.error.basic.modal').modal('show');
		}
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
			row += '<td><div class="field"><input type="hidden" name="itemcontrole[]" value=""><select name="veiculo[]" api-data-local api-key="veiculos" api-selected="'+$('[api-controle][name=veiculo]').val()+'"><option value="(veiculos.id)">(veiculos.placa)</option></select></div></td>';
			row += '<td><div class="field"><input type="text" name="kilometro_atual[]" value="'+$('[api-controle][name=kilometro_atual]').val()+'"></div></td>';
			row += '<td><div class="field"><select name="categoria_controle[]" api-data-local api-key="controles" api-selected="'+$('[api-controle][name=categoria_controle]').val()+'"><option value="(controles.id)">(controles.descricao)</option></select></div></td>';
			row += '<td><div class="field"><input type="text" name="quantidade[]" value="'+$('[api-controle][name=quantidade]').val()+'"></div></td>';
			row += '<td><div class="field"><input type="text" name="valor[]" value="'+$('[api-controle][name=valor]').val()+'"></div></td>';
			row += '</tr>';

			$('#tabelaControle tbody').prepend(row);

			$('[api-data-local]:not([api-checked])').each(function(){
				var el = $(this);
				var chave = el.attr('api-key');
				var selected = el.attr('api-selected') || '';

				if(dataLocal[chave] !== undefined)
					replaceMethod(el, dataLocal[chave], selected, chave, 1);
			});

		}
	});

	$.get('api/view/JSON/retornarControlePorId?id=' + $('input[name=id]').val(), function(obj){
		for(var i in obj)
		{
			$('input[name='+i+']').val(obj[i]);
		}
	});

}

if($('[api-formulario-marca]').length)
{
	$.get('api/view/JSON/retornarMarcaPorId?id=' + $('input[name=id]').val(), function(obj){
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
			for(var i in obj)
			{
				$('input[name='+i+']').val(obj[i]);
			}
		});
	});
}

if($('[api-formulario-fornecedor]').length)
{
	$.get('api/view/JSON/retornarFornecedorPorId?id=' + $('input[name=id]').val(), function(obj){
		console.log(obj);
		for(var i in obj)
		{
			$('input[name='+i+']').val(obj[i]);
		}
	});
}

if($('[api-formulario-veiculo]').length)
{
	setTimeout(function(){
		$.get('api/view/JSON/retornarVeiculoPorId?id=' + $('input[name=id]').val(), function(obj){
			for(var i in obj)
			{
				$('[name='+i+']').val(obj[i]);
			}
		});
	}, 500);
	// $(document).ajaxComplete(function(){
	// });
}

var replaceMethod = function(el, obj, selected, key, flag){
	var regExp = /\(([^)]+)\)/g;
	var html = el.html().trim();
	var matches = html.match(/\(([^()]+)\)/g);
	el.html('');
	for(var i in obj)
	{
		var subs = html;
		if(typeof(obj[i]) === 'object')
		{
			for(var k in matches)
			{
				keySubs = (matches[k].match(/\((.*?)\)/)[1]);
				keyHash = keySubs.split(".");
				keyObj = keyHash[1] || keyHash[0];

				if(keyHash[1] != undefined && keyHash[0] == key)
				{
					if(obj[i][keyObj] != undefined)
						subs = subs.replace(matches[k], obj[i][keyObj]);
				}
				else if(keyHash[1] == undefined)
				{
					if(obj[i][keyObj] != undefined)
						subs = subs.replace(matches[k], obj[i][keyObj]);
				}
			}
		}
		el.append(subs);
	}
	el.attr('api-checked', true);
	setTimeout(function(){
		el.val(selected);
	}, 500);
}

$('[api-data]:not([api-checked])').each(function(){
	var el = $(this);
	var chave = el.attr('api-key');
	var selected = el.attr('api-selected') || '';

	if(dataLocal[chave] !== undefined)
		replaceMethod(el, dataLocal[chave]);
	else
	{
		if(el.attr('api-data') != '')
		{
			$.get(el.attr('api-data'), function(obj){
				if(chave !== undefined)
					dataLocal[chave] = obj;
				replaceMethod(el, obj, selected, chave);
			});
		}
	}		
});

$(document).ajaxStop(function(){
	$('.ui.radio.checkbox').checkbox();
	$('.selection.dropdown').dropdown();

	$('[api-data-local]:not([api-checked])').each(function(){
		var el = $(this);
		var chave = el.attr('api-key');
		var selected = el.attr('api-selected') || '';

		if(dataLocal[chave] !== undefined)
			replaceMethod(el, dataLocal[chave], selected, chave, 1);
	});

});