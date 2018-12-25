<?php
require __DIR__ . '/vendor/autoload.php';

define('DS', DIRECTORY_SEPARATOR);

use Naka507\Koa\Application;
use Naka507\Koa\Context;
use Naka507\Koa\Error;
use Naka507\Koa\Timeout;
use Naka507\Koa\NotFound;
use Naka507\Koa\Router;
use Naka507\Koa\StaticFiles; 

$app = new Application();
$app->υse(new Error());
$app->υse(new Timeout(5));
$app->υse(new NotFound()); 
$app->υse(new StaticFiles(__DIR__ . DS .  "static" )); 

$router = new Router();

$router->get('/index', function(Context $ctx, $next) {
    $ctx->status = 200;
    yield $ctx->render(__DIR__ . "/template/index.html");
});


//文件上传
$router->post('/files', function(Context $ctx, $next) {
    $upload_path = __DIR__ . DS .  "uploads" . DS;
    if ( !is_dir($upload_path) ) {
        mkdir ($upload_path , 0777, true);
    }
    $files = [];
    var_dump($ctx->request->files);
    foreach ( $ctx->request->files as $key => $value) {
        if ( !$value['file_name'] || !$value['file_data'] ) {
            continue;
        }
        $file_path = $upload_path . $value['file_name'];
        file_put_contents($file_path, $value['file_data']);
        $value['file_path'] = $file_path;
        $files[] = $value;
    }

    $ctx->status = 200;
    $ctx->body = json_encode($files);
});

$app->υse($router->routes());

$app->listen(3000);