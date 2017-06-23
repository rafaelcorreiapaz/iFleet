angular.module("iFleet").factory("marcasAPI", function($http){
	var _getMarcas = function(){
		return $http.get("api/view/Marcas/retornarMarcasJSON");
	};

	var _getMarca = function(id){
		return $http.get("api/view/Marcas/" + id);
	};

	var _saveMarca = function(marca){
		return $http.post("api/view/Marcas", marca);
	};

	return {
		getMarcas: _getMarcas,
		getMarca: _getMarca,
		saveMarca: _saveMarca
	};
});