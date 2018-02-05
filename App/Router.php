<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2017/6/30
 * Time: 下午11:55
 */

namespace App;


use Core\AbstractInterface\AbstractRouter;
use FastRoute\RouteCollector;

class Router extends AbstractRouter
{

    function register(RouteCollector $routeCollector)
    {
        //首页
        $routeCollector->addRoute("GET", "/", 'UserCenter/UserCenterController/Index'); //创建用户

        //测试速度
        $routeCollector->addRoute("GET", "/test_fast", 'UserCenter/UserCenterController/TestFast'); //测试速度

        //用户
        $routeCollector->addRoute("GET", "/user_index", 'UserCenter/UserCenterController/UserIndex'); //创建用户
        $routeCollector->addRoute("GET", "/get_users", 'UserCenter/UserCenterController/UserLists'); //显示用户列表
        $routeCollector->addRoute("POST", "/create_user", 'UserCenter/UserCenterController/CreateUser'); //创建用户

        //设置redis
        $routeCollector->addRoute("GET", "/set_redis", 'UserCenter/UserCenterController/SetRedis'); //创建用户
        //上传图片
        $routeCollector->addRoute("GET", "/set_avatar", 'UserCenter/UserCenterController/SetAvatar'); //显示界面
        $routeCollector->addRoute('POST', '/get_avatar', 'UserCenter/UserCenterController/GetAvatar');//获取图片

        //设置二维码
        $routeCollector->addRoute('GET', '/set_qrCode', 'UserCenter/UserCenterController/SetQrCode');//设置二维码

        //使用Beanstalkd进行消息队列处理
        $routeCollector->addRoute('GET', '/set_beanstalkd', 'UserCenter/UserCenterController/SetBeanstalkd');//插入数据到队列
        $routeCollector->addRoute('GET', '/get_beanstalkd', 'UserCenter/UserCenterController/GetBeanstalkd');//获取数据从队列

        //使用redis实现秒杀
        $routeCollector->addRoute('GET', '/set_goods', 'UserCenter/UserCenterController/PutGoods');//设置商品到redis中
        $routeCollector->addRoute('GET', '/get_goods', 'UserCenter/UserCenterController/BuyGoods');//获取商品从redis
    }
}