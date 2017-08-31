<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2015 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------

namespace pudge;

use pudge\tool\Str;
use pudge\queue\Connector;
use think\facade\Config;
/**
 * Class Queue
 * @package think\queue
 *
 * @method static push($job, $data = '', $queue = null)
 * @method static later($delay, $job, $data = '', $queue = null)
 * @method static pop($queue = null)
 * @method static marshal()
 */
class Queue
{
    /** @var Connector */
    protected static $connector;

    public static function register() {
        \think\Console::addDefaultCommands([
            "pudge\\queue\\command\\Work",
            "pudge\\queue\\command\\Restart",
            "pudge\\queue\\command\\Listen",
            "pudge\\queue\\command\\Subscribe"
        ]);
        if (!function_exists('queue')) {
            /**
             * 添加到队列
             * @param        $job
             * @param string $data
             * @param int    $delay
             * @param null   $queue
             */
            function queue($job, $data = '', $delay = 0, $queue = null)
            {
                if ($delay > 0) {
                    \think\Queue::later($delay, $job, $data, $queue);
                } else {
                    \think\Queue::push($job, $data, $queue);
                }
            }
        }
    }


    private static function buildConnector()
    {
        $options = Config::pull('queue');
        $type    = !empty($options['connector']) ? $options['connector'] : 'Sync';

        if (!isset(self::$connector)) {

            $class = false !== strpos($type, '\\') ? $type : '\\pudge\\queue\\connector\\' . Str::studly($type);

            self::$connector = new $class($options);
        }
        return self::$connector;
    }

    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([self::buildConnector(), $name], $arguments);
    }
}
