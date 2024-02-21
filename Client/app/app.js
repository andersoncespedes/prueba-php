angular
  .module("myApp", [])
  // defining constant API_URL to use it in all the project
  .constant("API_URL", "http://localhost/prueba-tecnica/API/index.php/")
  //Controller
  .controller("ProductController", [
    "$scope",
    "ProductService",
    "$window",
    function ($scope, ProductService, $window) {
      //declaration of variables
      $scope.productDataUp = {};
      $scope.productData = {};
      // Get all products
      ProductService.getProducts().then(function (response) {
        // Configuration of the datable
        $('#table thead th').eq(3).attr('width', '30%');
        // Initicialize datatble with the data of the products
        $(document).ready(function() {
            $('#table').DataTable({
                paging: false,
                scrollCollapse: true,
                scrollY: '500px'
            });
        });
        // create the scope products where it puts the data of the response
        $scope.products = response.data;
      });
      // declaration of a function in scope that put data on inputs
      $scope.getOne = function (code) {
        // call to the fetch of the api getOneProduct
        ProductService.getOneProduct(code)
        // called, the data will be setted in $scope.productDataUp
          .then(function (response) {
            $scope.productDataUp = {
              Name: response.data.Name,
              Code: response.data.Code,
              Price: response.data.Price,
              Category: response.data.Category,
            };
          })
          .catch(function (error) {
            // if theres an exception then show in the console
            console.error(error);

          });
      };
      // creating a function into $scope that could save a new product
      $scope.saveProduct = function () {
        // call the fetch service to save a product
        ProductService.saveProduct($scope.productData)
          .then(function (response) {
            // called, the data will show in the console and then it gonna reload the page
            console.log(response.data);
            $window.location.reload();
          })
          .catch(function (error) {
            // if theres an exception then show in the console
            console.error(error);
            
          });
      };
      // creating a function into $scope that could update a product
      $scope.updateProduct = function () {
        // call the fetch service to update a product with the parameters scope.productDataUp that is the new data and $scope.productDataUp.Code that is the code
        ProductService.updateProduct(
          $scope.productDataUp,
          $scope.productDataUp.Code
        )
          .then(function (response) {
            // called, the data will show in the console and then it gonna reload the page
            console.log(response.data);
            $window.location.reload();
          })
          .catch(function (error) {
            // if theres an exception then show in the console
            console.error(error);
          });
      };
        // creating a function into $scope that could DELETE a product
      $scope.deleteProduct = function (code) {
        // implement a code to confirm if the user really wants to delete this product
        let confirm = $window.confirm(
          "Are you sure you want to delete this Product"
        );
        // if the corfimation is true then procced
        if (confirm) {
            // call to the fetch service to delete with the code to search the product
          ProductService.deleteProduct(code)
            .then(function (response) {
            // called, the data will show in the console and then it gonna reload the page
              console.log(response.data);
                $window.location.reload();
            })
            .catch(function (error) {
             // if theres an exception then show in the console
              console.error(error);
            });
        }
      };
    },
  ])
  // Services category
  .service("ProductService", [
    "$http",
    "API_URL",
    function ($http, API_URL) {
        // creation of a fetch method to get all of products
      this.getProducts = function () {
        // return the response of the api
        return $http.get(`${API_URL}product/show`);
      };
        // creation of a fetch method to get one product with the code of the product
      this.getOneProduct = function (code) {
        // return the response of the api
        return $http.get(`${API_URL}product/showOne?code=${code}`);
      };
        // creation of a fetch method to save one product with the data that corresponds to the entity
      this.saveProduct = function (data) {
        // return the response of the api
        return $http.post(`${API_URL}product/create`, data);
      };
      // creation of a fetch method to update product with the data that corresponds to the entity and the code to search the product
      this.updateProduct = function (data, code) {
        // return the response of the api
        return $http.put(`${API_URL}product/update?code=${code}`, data);
      };
      // creation of a fetch method to delete a  product with the code to search the product
      this.deleteProduct = function (code) {
        // return the response of the api
        return $http.delete(`${API_URL}product/delete?code=${code}`);
      };
    },
  ]);
  // section of the CategoryController
  angular
  .module("myApp")
  // Initializ Controller
  .controller("CategryController", ["$scope","CategoryService", function ($scope, CategoryService){
      // declaration of a function in scope that put data on inputs
    CategoryService.getCategories()
            .then(function (response) {
                // called, the data will be setted in $scope.options
                $scope.options = response.data;
                // by default the first in the list will be the last submit 
                $scope.productData.Category =  response.data[0].Name;
            })
            .catch(function(error){
                // if theres an exception then show in the console
                console.log(err);
            })
  }])
// Services category
  .service("CategoryService", ["$http", "API_URL", function ($http, API_URL){
    // creation of a fetch method to get all of categories
    this.getCategories = function () {
        // return the response of the api
        return $http.get(`${API_URL}category/show`);
      };
  }])