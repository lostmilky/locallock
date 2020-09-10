<?php
namespace Lostmilky\LocalLock;

class LocalLock
{
    public static $ids = [];

    /**
     * Desc: get a positive semaphore identifier
     * @param $proj
     * @return mixed
     * @throws \Exception
     * Date: 2020-09-10 10:49
     */
    private static function getSemId($proj)
    {
        if(!isset(self::$ids[$proj]) ) {
            self::checkKey($proj);
            self::$ids[$proj] = sem_get(ftok(__FILE__, $proj) );
        }
        return self::$ids[$proj];
    }


    /**
     * Desc: Check parameter key
     * @param $proj Project identifier. This must be a one character string.
     * @return bool
     * @throws \Exception
     * Date: 2020-09-10 10:49
     */
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

    /**
     * Desc: add local lock
     * @param $proj
     * @throws \Exception
     * Date: 2020-09-10 10:51
     */
    public static function lock($proj)
    {
        $id = self::getSemId($proj);
        sem_acquire($id);
    }

    /**
     * Desc: release local lock
     * @param $proj
     * @throws \Exception
     * Date: 2020-09-10 10:51
     */
    public static function unlock($proj)
    {
        $id = self::getSemId($proj);
        sem_release($id);
    }
}