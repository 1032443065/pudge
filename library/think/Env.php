<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2017 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

namespace think;

class Env
{
    /**
     * 获取环境变量值
     * @param string    $name 环境变量名（支持二级 .号分割）
     * @param string    $default  默认值
     * @return mixed
     */
    public static function get($name, $default = null)
    {
        $name=explode('.',$name);
        $result = getenv('PHP_' . strtoupper($name[0]));
        if($result===false){
            return $default;
        }
        $result=json_decode($result,true);
        if(count($name)>1){
            return isset($result[$name[1]])?$result[$name[1]]:$default;
        }
       return $result;
    }
}
