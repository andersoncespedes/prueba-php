import { apiService, apiServiceCreate } from "../services/productService.js"
apiService();
export const productGet = () => angular.module('myApp')
.controller('ProductController', function($scope, ApiService) {
    ApiService.getProducts().then(function(response) {
        $scope.products = response.data;
    });
});
export const productPost = () => angular.module('myApp')
.controller('ProductController', function($scope, ApiService) {
    $scope.productData = {};
    $scope.saveProduct= function() {
        apiServiceCreate.saveProduct($scope.userData).then(function(response) {
            console.log(response.data);
        }).catch(function(error) {
            console.error(error);
        });
    };
});