<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2017/1/23
 * Time: 上午12:06
 */

namespace Conf;


use App\Middleware\VerifyCsrfToken;
use Core\AbstractInterface\AbstractEvent;
use Core\AutoLoader;
use Core\Component\Di;
use Core\Component\Logger;
use Core\Component\SysConst;
use Core\Component\Version\Control;
use Core\Http\Request;
use Core\Http\Response;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Str;

class Event extends AbstractEvent
{
    function frameInitialize()
    {
        // TODO: Implement frameInitialize() method.
        $loader = AutoLoader::getInstance();
        $loader->requireFile('vendor/autoload.php');
        $loader->requireFile('Conf/Helpers.php');

        //设置时区
        date_default_timezone_set('Asia/Shanghai');
    }

    function frameInitialized()
    {
        // TODO: Implement frameInitialized() method.
        //初始化数据库
        $dbConf = Config::getInstance()->getConf('DATABASE');
        $capsule = new Capsule;
        //连接数据库
        $capsule->addConnection($dbConf);
        //设置全局静态可访问
        $capsule->setAsGlobal();
        // 启动Eloquent
        $capsule->bootEloquent();
    }


    function beforeWorkerStart(\swoole_server $server)
    {
        // TODO: Implement beforeWorkerStart() method.
    }

    function onStart(\swoole_server $server)
    {
        // TODO: Implement onStart() method.
    }

    function onShutdown(\swoole_server $server)
    {
        // TODO: Implement onShutdown() method.
    }

    function onWorkerStart(\swoole_server $server, $workerId)
    {
        // TODO: Implement onWorkerStart() method.
    }

    function onWorkerStop(\swoole_server $server, $workerId)
    {
        // TODO: Implement onWorkerStop() method.
    }

    function onRequest(Request $request, Response $response)
    {
        // TODO: Implement onRequest() method.
        VerifyCsrfToken::getInstance($request, $response);  //csrf的验证
    }

    function onDispatcher(Request $request, Response $response, $targetControllerClass, $targetAction)
    {
        // TODO: Implement onDispatcher() method.
    }

    function onResponse(Request $request, Response $response)
    {
        // TODO: Implement afterResponse() method.
    }

    function onTask(\swoole_server $server, $taskId, $workerId, $taskObj)
    {
        // TODO: Implement onTask() method.
    }

    function onFinish(\swoole_server $server, $taskId, $taskObj)
    {
        // TODO: Implement onFinish() method.
    }

    function onWorkerError(\swoole_server $server, $worker_id, $worker_pid, $exit_code)
    {
        // TODO: Implement onWorkerError() method.
    }
}
