angular.module("iFleet").factory("modelosAPI", function ($http) {
	var _getModelos = function () {
		return $http.get("api/view/Modelos");
	};

	var _getModelo = function (id) {
		return $http.get("api/view/Modelos/" + id);
	};

	var _saveModelo = function (contato) {
		return $http.post("api/view/Modelos", contato);
	};

	return {
		getModelos: _getModelos,
		getModelo: _getModelo,
		saveModelo: _saveModelo
	};
});