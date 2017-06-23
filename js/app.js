angular.module('iFleet', ['ngRoute']);

angular.module('iFleet').config(function($routeProvider){
    $routeProvider
        .when('/', {
            templateUrl: 'view/home.html'
        })
        .when('/cadastroveiculos', {
            controller: 'veiculosListaController',
            templateUrl: 'view/cadastro-veiculos.html',
            resolve: {
                veiculos: function(veiculosAPI){
                    return veiculosAPI.getVeiculos();
                },
                marcas: function(marcasAPI){
                    return marcasAPI.getMarcas();
                },
                modelos: function(modelosAPI){
                    return modelosAPI.getModelos();
                },
            }
        })
        .when('/cadastromarcas', {
            templateUrl: 'view/cadastro-marcas.html'
        })
        .when('/cadastromodelos', {
            templateUrl: 'view/cadastro-modelos.html'
        })
        .when('/cadastrocontroles', {
            templateUrl: 'view/cadastro-controles.html'
        })
});

angular.module('iFleet').controller('veiculosListaController', function($scope, veiculos, marcas, modelos){
    $scope.veiculos = veiculos.data;
    $scope.marcas = marcas.data;
    $scope.modelos = modelos.data;
});