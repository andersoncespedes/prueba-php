var app = angular.module('myApp', [])
.constant('API_URL', 'http://localhost/prueba-tecnica/API/index.php/')
.controller('ProductController', ['$scope', 'ProductService', function($scope, ProductService) {
    ProductService.getUsers().then(function(response) {
        $scope.products = response.data;
    });
}])
.service('ProductService', ['$http', 'API_URL', function($http, API_URL) {
    this.getUsers = function() {
        return $http.get(`${API_URL}product/show`);
    };
}]);
