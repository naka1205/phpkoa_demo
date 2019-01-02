<?php
namespace Controllers;
use Naka507\Koa\Context;
use Models\User;
class Api
{

    public static function user(Context $ctx, $next,$vars){
        $id = isset($vars[0]) ? intval($vars[0]) : 1;
        $data = ( yield User::get($id) );

        $ctx->status = 200;
        $ctx->body = $data;
    }    


}