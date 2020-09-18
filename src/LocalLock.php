<?php
namespace Lostmilky\Locallock;

class LocalLock
{
    public $ids;   //

    /**
     * LocalLock constructor.
     */
    public function __construct()
    {
        $this->ids = [];
    }

    /**
     * Desc: Get a positive semaphore identifier
     * @param $proj
     * @return mixed
     * @throws \Exception
     * @author lostmilky zzyydd520@163.com
     * Date: 2020/9/17 14:55
     */
    public function getSemId($proj)
    {
        if(!isset($this->ids[$proj]) ) {
            $this->checkKey($proj);
            $this->ids[$proj] = sem_get(ftok(__FILE__, $proj) );
        }
        return $this->ids[$proj];
    }

    /**
     * Desc: Check parameter key
     * @param $proj
     * @return bool
     * @throws \Exception
     * @author lostmilky zzyydd520@163.com
     * Date: 2020/9/17 14:55
     */
    public function checkKey($proj)
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
     * Desc: Add local lock
     * @param $proj
     * @throws \Exception
     * @author lostmilky zzyydd520@163.com
     * Date: 2020/9/17 14:56
     */
    public function lock($proj)
    {
        $id = $this->getSemId($proj);
        sem_acquire($id);
    }

    /**
     * Desc: Release local lock
     * @param $proj
     * @throws \Exception
     * @author lostmilky zzyydd520@163.com
     * Date: 2020/9/17 14:56
     */
    public function unlock($proj)
    {
        $id = $this->getSemId($proj);
        sem_release($id);
    }
}
