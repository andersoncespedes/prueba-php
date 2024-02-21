<?php
// routing the resources of the api
define("PROJECT_ROOT_PATH", __DIR__ );

//Config
require_once PROJECT_ROOT_PATH . "\src\Config\Env.php";
require_once PROJECT_ROOT_PATH . "\src\Config\Cors.php";
require_once PROJECT_ROOT_PATH . "\src\Config\Connection.php";

//BaseController
require_once PROJECT_ROOT_PATH . "\src\Controller\BaseController.php";

//Models
require_once PROJECT_ROOT_PATH . "\src\Model\ProductModel.php";
require_once PROJECT_ROOT_PATH . "\src\Model\CategoryModel.php";

?>