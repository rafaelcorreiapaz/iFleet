angular.module('iFleet', ['ngRoute']);

angular.module('iFleet').config(function($routeProvider){
    $routeProvider
        .when('/', {
            templateUrl: 'view/home.html'
        })
        .when('/cadastroveiculos', {
            templateUrl: 'view/cadastro-veiculos.html',
            controller: 'veiculosListaController',
            resolve: {
                veiculos: function(veiculosAPI){
                    return veiculosAPI.getVeiculos();
                },
                marcas: function(marcasAPI){
                    return marcasAPI.getMarcas();
                },
                modelos: function(modelosAPI){
                    return modelosAPI.getModelos();
                }
            }
        })
        .when('/cadastromarcas', {
            templateUrl: 'view/cadastro-marcas.html',
            controller: 'marcasListaController',
            resolve: {
                marcas: function(marcasAPI){
                    return marcasAPI.getMarcas();
                }
            }
        })
        .when('/cadastromodelos', {
            templateUrl: 'view/cadastro-modelos.html',
            controller: 'modelosListaController',
            resolve: {
                marcas: function(marcasAPI){
                    return marcasAPI.getMarcas();
                },
                modelos: function(modelosAPI){
                    return modelosAPI.getModelos();
                }
            }
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

angular.module('iFleet').controller('marcasListaController', function($scope, marcas){
    $scope.marcas = marcas.data;
});

angular.module('iFleet').controller('modelosListaController', function($scope, marcas, modelos){
    $scope.modelos = modelos.data;
    $scope.marcas = marcas.data;
});