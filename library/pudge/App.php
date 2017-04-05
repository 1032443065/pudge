<?php
/**
 * Created by rozbo at 2017/4/5 下午3:32
 */

namespace pudge;

use think\App as ThinkApp;
use think\facade;

class App extends ThinkApp {
    public function __construct($appPath) {
        $this->initErrorHandle();
        $this->initContainer();
        $this->initFacade();
        parent::__construct($appPath);
    }

    public function initErrorHandle() {
        // 注册错误和异常处理机制
        \think\Error::register();
    }

    public function initContainer() {
// 注册核心类到容器
        \think\Container::getInstance()->bind([
            'app' => \think\App::class,
            'build' => \think\Build::class,
            'cache' => \think\Cache::class,
            'config' => \think\Config::class,
            'cookie' => \think\Cookie::class,
            'debug' => \think\Debug::class,
            'hook' => \think\Hook::class,
            'lang' => \think\Lang::class,
            'log' => \think\Log::class,
            'request' => \think\Request::class,
            'response' => \think\Response::class,
            'route' => \think\Route::class,
            'session' => \think\Session::class,
            'url' => \think\Url::class,
            'view' => \think\View::class,
            // 接口依赖注入
            'think\LoggerInterface' => \think\Log::class,
        ]);
    }

    public function initFacade() {
// 注册核心类的静态代理
        Facade::bind([
            facade\App::class => \think\App::class,
            facade\Build::class => \think\Build::class,
            facade\Cache::class => \think\Cache::class,
            facade\Config::class => \think\Config::class,
            facade\Cookie::class => \think\Cookie::class,
            facade\Debug::class => \think\Debug::class,
            facade\Hook::class => \think\Hook::class,
            facade\Lang::class => \think\Lang::class,
            facade\Log::class => \think\Log::class,
            facade\Request::class => \think\Request::class,
            facade\Response::class => \think\Response::class,
            facade\Route::class => \think\Route::class,
            facade\Session::class => \think\Session::class,
            facade\Url::class => \think\Url::class,
            facade\View::class => \think\View::class,
        ]);
    }
}