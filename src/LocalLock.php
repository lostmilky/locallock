<?php
namespace Lostmilky;

class LocalLock
{
    public static $ids = [];

    private static function getSemId($key)
    {
        if(!isset(self::$ids[$key]) ) {
            self::$ids[$key] = sem_get(ftok(__FILE__, $key) );
        }
        return self::$ids[$key];
    }

    // @ proj Project identifier. This must be a one character string. 
    public static function checkKey($proj)
    {
        if(1 != strlen($proj) ) {
            throw new \Exception('This must be a one character string', 403);
        }
        
        $encode = mb_detect_encoding($proj, array("ASCII","UTF-8","GB2312","GBK","BIG5"));
        if($encode !== "ASCII"){
            throw new \Exception('This must be a one character string', 403);
        }
        return true;
    }

    public static function lock($key)
    {
        self::checkKey($key);
        $id = self::getSemId($key);
        sem_acquire($id);
    }

    public static function unlock($key)
    {
        $id = self::getSemId($key);
        sem_release($id);
    }
}