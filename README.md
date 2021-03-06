# locallock


### 特点

- 一个基于信号量实现的单机锁，由于是信号量是内核控制，具有很高的效率。

- 锁被占用后，对方释放，这边进程自动唤起，不需要特意去实现冲突后的逻辑。


### 运行环境
- Linux
- PHP 7.1.3+

### laravel 安装
```
composer require lostmilky/locallock
```

> laravel 需要修改 app/config/app.php
> 
> providers 里增加 Lostmilky\Locallock\LocalLockProvider::class



### Demo
```
<?php
use Lostmilky\Locallock\LocalLock; 


try{
    $lock = new LocalLock();
    $key = 'a';  // 这里只能是单个的 ASCII 字符串
    $lock->lock($key);    // 加锁
    doSomeThing();  
    
    $lock->unlock($key);  // 释放锁
} catch (\Exception $e) {
    $lock->unlock($key);  // 出异常，释放锁
}

```

### LICENSE

 MIT
