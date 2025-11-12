<?php
require_once './libs/router/router.php';
require_once './controller/category-api-controller.php';
require_once './controller/product-api-controller.php';


$router = new Router();

$router->addRoute('products', 'GET', 'ProductApiController', 'getAll');
$router->addRoute('products/:id', 'GET', 'ProductApiController', 'getById');   
$router->addRoute('products', 'POST', 'ProductApiController', 'create');       
$router->addRoute('products/:id', 'PUT', 'ProductApiController', 'update');    
$router->addRoute('products/:id', 'DELETE', 'ProductApiController', 'delete');


$router->setDefaultRoute('ProductApiController', 'notFound');

$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);