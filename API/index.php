<?php
require __DIR__ . "/bootstrap.php";
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD'];
if($method == "OPTIONS") {
    die();
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );
if (!isset($uri[4])) {
    header("HTTP/1.1 404 Not Found");
    exit();
}
require PROJECT_ROOT_PATH . "\src\Controller\ProductController.php";
require PROJECT_ROOT_PATH . "\src\Controller\CategoryController.php";

$objFeedProductController = new ProductoController();
$objFeedCategoryController = new CategoryController();
$strMethodName = $uri[5];
if($uri[4] == "category"){
    echo $objFeedCategoryController->{$strMethodName}();
}else if($uri[4] == "product"){
    echo $objFeedProductController->{$strMethodName}();
}else{
    header("HTTP/1.1 404 Not Found");
    exit();
}





?>