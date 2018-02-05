<?php

namespace App\Controller\UserCenter;

use App\Controller\ViewController;
use App\Model\UserCenter\User;
use App\Traits\AbstractControllerTraits;
use App\Vendor\Image\ImageManager;
use App\Vendor\Pheanstalk\Pheanstalk;
use App\Vendor\Redis\Cache;
use Core\Component\Logger;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;

class UserCenterController extends ViewController
{
    use AbstractControllerTraits;

    /*
     * 显示首页
     */
    public function GETIndex()
    {
        $this->View('app');
    }

    /**
     *获取用户信息(可选择分页)
     */
    public function GETUserLists()
    {
        $users = User::latest()->page(2);
        $this->View('userCenter.index', ['users' => $users]);
    }

    /**
     *显示添加用户界面
     */
    public function GETUserIndex()
    {
        $this->View('userCenter.create');
    }

    /**
     * 添加用户
     * @return array|\Exception|\Throwable
     */
    public function POSTCreateUser()
    {
        $params = $this->request()->getRequestParam();
        $rule = [
            'phone' => 'required|regex:"^\d{11}$"',
            'name' => 'required|min:1|max:15',
        ];
        $valid = $this->com_validate($params, $rule);
        if ( !$valid['is_valid']) {
            Logger::getInstance()->console($valid['errors']);
            return $this->response()->write($valid['errors']);
            return $this->View('userCenter.create', ['errors' => $valid['errors']]);
        }
        try {
            $args = [
                'phone' => $params['phone'],
                'name' => $params['name'],
            ];
            User::create($args);
            return $this->response()->redirect('get_users');
        } catch (\Exception $e) {
            Logger::getInstance()->console('添加用户错误:' . $e);
            return $this->response()->write('抱歉！添加用户失败');
        } catch (\Throwable $e) {
            Logger::getInstance()->console('添加用户异常:' . $e);
            return $this->response()->write('抱歉！添加用户异常');
        };
    }


    /**
     * 设置redis
     * @return bool
     */
    public function GETSetRedis()
    {
        $default = Cache::getInstance()->redisConnect()->connection();
        $default->set('name', 'LaravelChen');
        $message = $default->get('name');
        return $this->response()->write($message);
    }

    /**
     *显示上传图片界面
     */
    public function GETSetAvatar()
    {
        $this->View('userCenter.upload');
    }

    /*
     * 上传图片(获取)
     */
    public function POSTGetAvatar()
    {
        $file = $this->request()->getUploadedFile('image');
        $dest = ROOT . '/Resource/images/' . $file->getClientFilename();
        $file->moveTo($dest);
        $image = ImageManager::getInstance()->make($dest);
        $image->blur(10);
        $image->save($dest);
        $this->response()->write('设置完成');
    }

    /*
     * 设置二维码
     */
    public function GETSetQrCode()
    {
        $qrCode = new QrCode();
        $qrCode->setText('This is Swoole FrameWork!')
            ->setSize(300)
            ->setMargin(10)
            ->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH)
            ->setWriterByName('png')
            ->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0])
            ->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0]);
        $qrcode_url = $qrCode->writeDataUri();
        $this->View('userCenter.qrCode', ['qroce_url' => $qrcode_url]);
    }

    /*
     * 使用队列
     */
    public function GETSetBeanstalkd()
    {
        static $i = 0;
        $pheanstalk = Pheanstalk::getInstance();
        $pheanstalk->useTube('message');
        $pheanstalk->put($i++);
        $this->response()->write($i);
    }

    /*
     * 获取队列的job信息
     */
    public function GETGetBeanstalkd()
    {
        $pheanstalk = Pheanstalk::getInstance();
        $job = $pheanstalk->watch('message')->ignore('default')->reserve();
        Logger::getInstance()->console($job->getData());
        $pheanstalk->delete($job);
        $this->response()->write($job);
    }

    /**************实现秒杀*****************/

    /*
     * 将商品放在缓存中(默认10个)
     */
    public function GETPutGoods()
    {
        $num = 10;
        $redis = Cache::getInstance()->redisConnect()->connection();
        for ($i = 0; $i < $num; ++$i)
            $redis->rpush('goods:1', $i + 1);
        return $this->response()->write($redis->llen('goods:1'));
    }

    /*
     * 将商品的数量存入redis中
     */
    public function GETBuyGoods()
    {
        $redis = Cache::getInstance()->redisConnect()->connection();
        $count = $redis->lpop('goods:1');
        if ( !$count) {
            return Logger::getInstance()->console('商品已经抢购完了!');
        }
        return Logger::getInstance()->console("恭喜你抢购到商品:$count!");
    }

    /**
     *测试速度
     */
    public function GETTestFast()
    {
        $this->response()->write( $this->request()->getServerParams());
    }
}