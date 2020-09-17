<?php
namespace Lostmilky\Locallock\Facades;

use Illuminate\Support\Facades\Facade;

class LocalLock extends Facade {

    protected static function getFacadeAccessor() {
        return 'locallock';
    }
}
