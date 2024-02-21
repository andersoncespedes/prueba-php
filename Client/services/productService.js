import { API_URL } from "./config.js";
angular.module("myApp", []);

export let apiService = () =>  angular.module('myApp')
.service('ApiService', function($http) {
    this.getProducts = function() {
        return $http.get(`${API_URL}product/show`);
    };
});

export let apiServiceCreate = () =>  angular.module('myApp')
.service('ApiServiceCreate', function($http) {
    this.saveProduct = function(datos) {
        return $http.post(`${API_URL}product/create`, datos);
    };
});
