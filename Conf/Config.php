<?php

/**
 * Created by PhpStorm.
 * User: YF
 * Date: 16/8/25
 * Time: 上午12:05
 */

namespace Conf;

use Core\Component\Spl\SplArray;

class Config
{
    private static $instance;
    protected $conf;

    function __construct()
    {
        $conf = $this->sysConf() + $this->userConf();
        $this->conf = new SplArray($conf);
    }

    static function getInstance()
    {
        if ( !isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    function getConf($keyPath)
    {
        return $this->conf->get($keyPath);
    }

    /*
            * 在server启动以后，无法动态的去添加，修改配置信息（进程数据独立）
    */
    function setConf($keyPath, $data)
    {
        $this->conf->set($keyPath, $data);
    }

    private function sysConf()
    {
        return [
            "SERVER" => [
                "LISTEN" => "0.0.0.0",
                "SERVER_NAME" => "",
                "PORT" => 9501,
                "RUN_MODE" => SWOOLE_PROCESS,//不建议更改此项
                "SERVER_TYPE" => \Core\Swoole\Config::SERVER_TYPE_WEB,//
                'SOCKET_TYPE' => SWOOLE_TCP,//当SERVER_TYPE为SERVER_TYPE_SERVER模式时有效
                "CONFIG" => [
                    'task_worker_num' => 8, //异步任务进程
                    "task_max_request" => 10,
                    'max_request' => 5000,//强烈建议设置此配置项
                    'worker_num' => 8,
                ],
            ],
            "DEBUG" => [
                "LOG" => true,
                "DISPLAY_ERROR" => true,
                "ENABLE" => true,
            ],
            "CONTROLLER_POOL" => true,//web或web socket模式有效
            "ForwardingDomain" => "http://easy-swoole.dev:7777/Resource",//静态资源的域名(此处为nginx分配的域名)
            "SESSION_DRIVER" => "redis",
            "EXPIRETIME" => 3600,
        ];
    }

    private function userConf()
    {
        return [
            'DATABASE' => [
                'driver' => 'mysql',
                'host' => '127.0.0.1',
                'prot' => '3306',
                'database' => 'swoole_framework',
                'username' => 'root',
                'password' => 'root',
                'charset' => 'utf8',
                'collation' => 'utf8_general_ci',
                'prefix' => '',
            ],
            'REDIS' => [
                'cluster' => false,
                'default' => [
                    'host' => '127.0.0.1',
                    'port' => 6379,
                    'database' => 0,
                ],
            ],
        ];
    }
}