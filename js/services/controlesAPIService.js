angular.module("iFleet").factory("controlesAPI", function ($http) {
	var _getControles = function () {
		return $http.get("api/view/Controles/retornarControlesJSON");
	};

	var _getControle = function (id) {
		return $http.get("api/view/Controles/retornarControleJSON?id=" + id);
	};

	var _saveControle = function (contato) {
		return $http.post("api/view/Controles", contato);
	};

	return {
		getControles: _getControles,
		getControle: _getControle,
		saveControle: _saveControle
	};
});