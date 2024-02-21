var app = angular.module('myApp', [])
.constant('API_URL', 'http://localhost/prueba-tecnica/API/index.php/')
.controller('ProductController', ['$scope', 'ProductService', function($scope, ProductService) {
    // Get all products
    ProductService.getProducts().then(function(response) {
        $scope.products = response.data;
    });
    // Get One Product
    $scope.getOne = function (code){
        ProductService.getOneProduct(code).then(function(response) {
            $scope.productDataUp = {
                Name: response.data.Name,
                Price: response.data.Price,
                Category: response.data.Category
            };
        }).catch(function(error) {
            console.error(error);
        });
    }
    // Save Product
    $scope.productData = {};
    $scope.saveProduct = function() {
        ProductService.saveProduct( $scope.productData).then(function(response) {
            console.log(response.data);
        }).catch(function(error) {
            console.error(error);
        });
    };
}])
.service('ProductService', ['$http', 'API_URL', function($http, API_URL) {
    this.getProducts = function() {
        return $http.get(`${API_URL}product/show`);
    };
    this.getOneProduct = function(code) {
        return $http.get(`${API_URL}product/showOne?code=${code}`);
    };
    this.saveProduct = function(data){
        return $http.post(`${API_URL}product/create`,data);
    }
}]);
