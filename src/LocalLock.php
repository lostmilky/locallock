<?php
namespace Lostmilky\LocalLock;

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

    public static function checkKey($key)
    {
        if(1 != strlen($key) ) {
            throw new \Exception('key must a ASCII character', 403);
        }
        
        $encode = mb_detect_encoding($keytitle, array("ASCII","UTF-8","GB2312","GBK","BIG5"));
        if($encode !== "ASCII"){
            throw new \Exception('key must a ASCII character', 403);
        }
        return true;
    }

    public static function lock($key)
    {
        $id = self::getSemId($key);
        sem_acquire($id);
    }

    public static function unlock($key)
    {
        $id = self::getSemId($key);
        sem_release($id);
    }
}