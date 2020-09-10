<?php
// 测试脚本，建议并发开启多个脚本来看效果

require_once '../vendor/autoload.php';

use Lostmilky\LocalLock\LocalLock;

$mark = mt_rand(1000, 9999);
$key = 'a';
for ($i=0; $i < 10; $i++) {
    LocalLock::lock($key);
    echo $mark, ':', time(), PHP_EOL;
    $sec = mt_rand(1, 6);
    echo $mark, ':sleep ', $sec, PHP_EOL;
    sleep($sec);
    LocalLock::unlock($key);
}