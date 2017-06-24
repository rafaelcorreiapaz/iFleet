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
        .when('/formularioveiculo/:id', {
            templateUrl: 'view/formulario-veiculo.html',
            controller: 'veiculoFormularioController',
            resolve: {
                veiculo: function(veiculosAPI, $route){
                    return veiculosAPI.getVeiculo($route.current.params.id);
                },
                marcas: function(marcasAPI){
                    return marcasAPI.getMarcas();
                },
                modelos: function(modelosAPI){
                    return modelosAPI.getModelos();
                },
            }
        })
        .when('/formularioveiculo', {
            templateUrl: 'view/formulario-veiculo.html',
            controller: 'veiculoFormularioController',
            resolve: {
                marcas: function(marcasAPI){
                    return marcasAPI.getMarcas();
                },
                modelos: function(modelosAPI){
                    return modelosAPI.getModelos();
                },
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
        .when('/formulariomarca/:id', {
            templateUrl: 'view/formulario-marca.html',
            controller: 'marcaFormularioController',
            resolve: {
                marca: function(marcasAPI, $route){
                    return marcasAPI.getMarca($route.current.params.id);
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
        .when('/formulariomodelo/:id', {
            templateUrl: 'view/formulario-modelo.html',
            controller: 'modeloFormularioController',
            resolve: {
                modelo: function(modelosAPI, $route){
                    return modelosAPI.getModelo($route.current.params.id);
                },
                marcas: function(marcasAPI){
                    return marcasAPI.getMarcas();
                }
            }
        })
        .when('/cadastrocontroles', {
            templateUrl: 'view/cadastro-controles.html',
            controller: 'controlesListaController',
            resolve: {
                controles: function(controlesAPI){
                    return controlesAPI.getControles();
                }
            }
        })
        .when('/formulariocontrole/:id', {
            templateUrl: 'view/formulario-controle.html',
            controller: 'controleFormularioController',
            resolve: {
                controle: function(controlesAPI, $route){
                    return controlesAPI.getControle($route.current.params.id);
                }
            }
        })
        .when('/cadastrofornecedores', {
            templateUrl: 'view/cadastro-fornecedores.html',
            controller: 'fornecedoresListaController',
            resolve: {
                fornecedores: function(fornecedoresAPI){
                    return fornecedoresAPI.getFornecedores();
                }
            }
        })
        .when('/formulariofornecedor/:id', {
            templateUrl: 'view/formulario-fornecedor.html',
            controller: 'fornecedorFormularioController',
            resolve: {
                fornecedor: function(fornecedoresAPI, $route){
                    return fornecedoresAPI.getFornecedor($route.current.params.id);
                }
            }
        })
        .when('/formulariofornecedor', {
            templateUrl: 'view/formulario-fornecedor.html',
            controller: 'fornecedorFormularioController'
        })

});

angular.module('iFleet').controller('veiculosListaController', function($scope, veiculos, marcas, modelos){
    $scope.veiculos = veiculos.data;
    $scope.marcas = marcas.data;
    $scope.modelos = modelos.data;
});

angular.module('iFleet').controller('veiculoFormularioController', function($scope, veiculo, marcas, modelos){
    $scope.veiculo = veiculo.data;
    $scope.marcas = marcas.data;
    $scope.modelos = modelos.data;
});

angular.module('iFleet').controller('marcasListaController', function($scope, marcas){
    $scope.marcas = marcas.data;
});

angular.module('iFleet').controller('marcaFormularioController', function($scope, marca){
    $scope.marca = marca.data;
});

angular.module('iFleet').controller('modelosListaController', function($scope, marcas, modelos){
    $scope.modelos = modelos.data;
    $scope.marcas = marcas.data;
});

angular.module('iFleet').controller('modeloFormularioController', function($scope, modelo, marcas){
    $scope.modelo = modelo.data;
    $scope.marcas = marcas.data;
});

angular.module('iFleet').controller('controlesListaController', function($scope, controles){
    $scope.controles = controles.data;
});

angular.module('iFleet').controller('controleFormularioController', function($scope, controle){
    $scope.controle = controle.data;
});

angular.module('iFleet').controller('fornecedoresListaController', function($scope, fornecedores){
    $scope.fornecedores = fornecedores.data;
});

angular.module('iFleet').controller('fornecedorFormularioController', function($scope, fornecedor){
    $scope.fornecedor = fornecedor.data;
});
