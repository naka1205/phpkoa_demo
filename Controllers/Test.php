<?php
namespace Controllers;
use Naka507\Koa\Context;
class Test
{
    public static function user(Context $ctx, $next,$vars){
        $id = isset($vars[0]) ? intval($vars[0]) : 1;
        $ctx->status = 200;
        $ctx->state["id"] = $id;
        yield $ctx->render(TEMPLATE_PATH . "/user.html");
    }

}