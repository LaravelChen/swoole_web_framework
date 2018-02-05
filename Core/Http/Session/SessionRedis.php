<?php

namespace Core\Http\Session;


use App\Vendor\Redis\Cache;
use Conf\Config;

class SessionRedis implements \SessionHandlerInterface
{
    private $redis;
    private $isStart = false;
    private $sessionExpireTime;//redis，session的过期时间
    private static $staticInstance;

    public function __construct()
    {
        $this->redis = Cache::getInstance()->redisConnect()->connection();
        $this->sessionExpireTime = Config::getInstance()->getConf('EXPIRETIME');
    }

    public static function getInstance()
    {
        if ( !isset(self::$staticInstance)) {
            self::$staticInstance = new static();
        }
        return self::$staticInstance;
    }

    public function close()
    {
        // TODO: Implement close() method.
        return true;
    }

    public function start()
    {
        $this->isStart = true;
    }

    public function isStart()
    {
        return $this->isStart;
    }

    public function destroy($session_id)
    {
        // TODO: Implement destroy() method.
        if ($this->redis->del($session_id)) {//删除redis中的指定记录
            return true;
        }
        return false;
    }

    public function gc($maxlifetime)
    {
        // TODO: Implement gc() method.
        return true;
    }

    public function open($save_path, $name)
    {
        // TODO: Implement open() method.
        return true;
    }

    public function read($session_id)
    {
        // TODO: Implement read() method.
        $value = $this->redis->get($session_id);//获取redis中的指定记录
        if ($value) {
            return $value;
        } else {
            return '';
        }
    }

    public function write($session_id, $session_data)
    {
        // TODO: Implement write() method.
        if ($this->redis->set($session_id, $session_data)) {//以session ID为键，存储
            $this->redis->expire($session_id, $this->sessionExpireTime);//设置redis中数据的过期时间，即session的过期时间
            return true;
        }

        return false;
    }
}