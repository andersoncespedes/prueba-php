<?php
require __DIR__ . "/bootstrap.php";
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );
if ((isset($uri[4]) && $uri[4] != 'user') || !isset($uri[4])) {
    header("HTTP/1.1 404 Not Found");
    exit();
}
require PROJECT_ROOT_PATH . "\src\Controller\ProductController.php";
$objFeedController = new ProductoController();
$strMethodName = $uri[5];
echo $objFeedController->{$strMethodName}();

?>