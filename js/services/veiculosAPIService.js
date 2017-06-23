angular.module("iFleet").factory("veiculosAPI", function($http){
	var _getVeiculos = function(){
		return $http.get("api/view/Veiculos/retornarVeiculosJSON");
	};

	var _getVeiculo = function(id){
		return $http.get("api/view/Veiculos/" + id);
	};

	var _saveVeiculo = function(veiculo){
		return $http.post("api/view/Veiculos", veiculo);
	};

	return {
		getVeiculos: _getVeiculos,
		getVeiculo: _getVeiculo,
		saveVeiculo: _saveVeiculo
	};
});