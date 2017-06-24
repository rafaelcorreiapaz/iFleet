angular.module("iFleet").factory("fornecedoresAPI", function($http){
	var _getFornecedores = function(){
		return $http.get("api/view/Fornecedores/retornarFornecedoresJSON");
	};

	var _getFornecedor = function(id){
		return $http.get("api/view/Fornecedores/retornarFornecedorJSON?id=" + id);
	};

	var _saveFornecedor = function(fornecedor){
		return $http.post("api/view/Fornecedores", fornecedor);
	};

	return {
		getFornecedores: _getFornecedores,
		getFornecedor: _getFornecedor,
		saveFornecedor: _saveFornecedor
	};
});