PHPKoa Demo
=================
这是  [PHPKoa](https://github.com/naka1205/phpkoa) 的一个简单示例！可以独立运行在`WINDOWS`或`LINUX`已安装PHP环境的服务器上！这得益于 [PHPSocket](https://github.com/naka1205/phpsocket)，它是基于[Workerman](https://github.com/walkor/Workerman) 改写的简化版。简单的几十行代码即可搭建一个非常强悍`HTTP SERVER`。

下载
=======
```
git clone https://github.com/naka1205/phpkoa_demo.git
```
安装
=======
```
composer install
```
使用
=======
```
php app.php
```
浏览器访问 http://127.0.0.1:3000/index

使用 第三方ORM
```
composer require topthink/think-orm
```
创建 MYSQL 数据表
```mysql
CREATE TABLE `too_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `account` varchar(64) NOT NULL DEFAULT '' COMMENT '账号',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '登录密码',
  `nickname` varchar(32) NOT NULL DEFAULT '' COMMENT '用户昵称',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```
自定义数据模型
```php
<?php
namespace Models;
use think\Model;
class User extends Model
{
}
```
自定义 JSON响应 中间件
中间件会根据是否存在数据 响应不同的数据 并进行JSON格式化
```php
<?php
namespace Middlewares;
use Naka507\Koa\Middleware;
use Naka507\Koa\Context;
class BodyJson implements Middleware
{
    public function __construct(){
    }
    public function __invoke(Context $ctx, $next){
        yield $next;
        $pos = strpos($ctx->accept,'json');
        if ( $pos !== false ) {
            $ctx->type = 'application/json';
            $result = [ "code" => 0,  "msg" => '操作失败'];
            $data = $ctx->body;
            if ( $data ) {
                $result['code'] = 200;
                $result['msg'] = '操作成功';
                $result['data'] = $data;
            }
            $ctx->body = json_encode( $result );
        }

    }
}
```
动态模板 使用JQ 进行AJAX 请求
```html
<body>
    <h1>/api/user/{id}</h1>
    <p id="user"></p>
</body>
<script type="text/javascript">
var id = {id};
$.ajax({
    type: "GET",
    url: "/api/user/" + id,
    dataType: "json",
    success: function(res){
        if( res.code == 200 ){
            $("#user").html(JSON.stringify(res.data))
        }else{
            $("#user").html(res.msg)
        }
        
    }
});
</script>
```
```
php server.php
```
根据GET参数 获取 User 表中数据
http://127.0.0.1:5000/test/user/1