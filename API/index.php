<?php
// getting the routing
require __DIR__ . "/bootstrap.php";
// getting the method
$method = $_SERVER['REQUEST_METHOD'];
// if the metod is equal to OPTIONS then stop
if($method == "OPTIONS") {
    die();
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );
// if exists the the fourth uri then continue else return a 404
if (!isset($uri[4])) {
    header("HTTP/1.1 404 Not Found");
    exit();
}
// importing the controllers
require PROJECT_ROOT_PATH . "\src\Controller\ProductController.php";
require PROJECT_ROOT_PATH . "\src\Controller\CategoryController.php";
// instancing the controllers
$objFeedProductController = new ProductoController();
$objFeedCategoryController = new CategoryController();
// getting the last uri
$strMethodName = $uri[5];
// if the fourth uri is category then use that controller
if($uri[4] == "category"){
    echo $objFeedCategoryController->{$strMethodName}();
}
// else if the it must be product
else if($uri[4] == "product"){
    echo $objFeedProductController->{$strMethodName}();
}
// else doesn't exist
else{
    header("HTTP/1.1 404 Not Found");
    exit();
}





?>