// Iniciando a aplição
var seracademicoApp = angular.module('seracademico', []).config(function ($interpolateProvider) {
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});