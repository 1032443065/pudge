<?php
/**
 * Created by rozbo at 2017/4/6 上午11:02
 */

namespace pudge\facade;

use think\Facade;
class Crypt extends Facade{
    protected static function getFacadeClass(){
        return 'crypt';
    }
}