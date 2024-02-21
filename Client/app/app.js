angular
  .module("myApp", [])
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
     // datatable
        $(document).ready(function() {
            $('#table').DataTable();
        });
        $scope.products = response.data;
      });
      // Get One Product
      $scope.getOne = function (code) {
        ProductService.getOneProduct(code)
          .then(function (response) {
            $scope.productDataUp = {
              Name: response.data.Name,
              Code: response.data.Code,
              Price: response.data.Price,
              Category: response.data.Category,
            };
          })
          .catch(function (error) {
            console.error(error);

          });
      };
      // Save Product
      $scope.saveProduct = function () {
        ProductService.saveProduct($scope.productData)
          .then(function (response) {
            console.log(response.data);
            $window.location.reload();
          })
          .catch(function (error) {
            console.error(error);
            
          });
      };
      //Update Product
      $scope.updateProduct = function () {
        ProductService.updateProduct(
          $scope.productDataUp,
          $scope.productDataUp.Code
        )
          .then(function (response) {
            console.log(response.data);
            $window.location.reload();
          })
          .catch(function (error) {
            console.error(error);
          });
      };
      // delete product
      $scope.deleteProduct = function (code) {
        let confirm = $window.confirm(
          "Are you sure you want to delete this Product"
        );
        if (confirm) {
          ProductService.deleteProduct(code)
            .then(function (response) {
              console.log(response.data);
                $window.location.reload();
            })
            .catch(function (error) {
              console.error(error);
            });
        }
      };
    },
  ])
  // Services
  .service("ProductService", [
    "$http",
    "API_URL",
    function ($http, API_URL) {
      this.getProducts = function () {
        return $http.get(`${API_URL}product/show`);
      };
      this.getOneProduct = function (code) {
        return $http.get(`${API_URL}product/showOne?code=${code}`);
      };
      this.saveProduct = function (data) {
        return $http.post(`${API_URL}product/create`, data);
      };
      this.updateProduct = function (data, code) {
        return $http.put(`${API_URL}product/update?code=${code}`, data);
      };
      this.deleteProduct = function (code) {
        return $http.delete(`${API_URL}product/delete?code=${code}`);
      };
    },
  ]);

  angular
  .module("myApp")
  .controller("CategryController", ["$scope","CategoryService", function ($scope, CategoryService){
    CategoryService.getCategories()
            .then(function (response) {
                $scope.options = response.data;
                $scope.selectedOption = 'Comida';
            })
            .catch(function(error){
                console.log(err);
            })
  }]).service("CategoryService", ["$http", "API_URL", function ($http, API_URL){
    this.getCategories = function () {
        return $http.get(`${API_URL}category/show`);
      };
  }])