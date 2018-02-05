<?php

namespace App\Vendor\Pheanstalk;
class Pheanstalk
{
    public static function getInstance()
    {
        static $pheanstalk = null;
        if ($pheanstalk==null){
            $pheanstalk=new \Pheanstalk\Pheanstalk('127.0.0.1');
        }
        return $pheanstalk;
    }
}