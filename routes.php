<?php
use Naka507\Koa\Router;

$router = new Router();

$router->mount('/test', function() use ($router) {

    $router->get('/user/(\d+)', ['Controllers\Test', 'user']);

});

$router->mount('/api', function() use ($router) {

    $router->get('/user/(\d+)', ['Controllers\Api', 'user']);

});

return $router;
