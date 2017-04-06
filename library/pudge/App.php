<?php
/**
 * Created by rozbo at 2017/4/5 下午3:32
 */

namespace pudge;

use think\App as ThinkApp;
use think\facade;

class App extends ThinkApp {
    public function __construct($appPath) {
        $this->container   = \think\Container::getInstance();
        $this->initErrorHandle();
        $this->initContainer();
        $this->initFacade();
        $this->initAutoLoader();
        $this->initPath($appPath);
        $this->initDefaultConfig();
        $this->initService();
        parent::__construct($appPath);
    }

    public function initPath($appPath) {
        $this->beginTime   = microtime(true);
        $this->beginMem    = memory_get_usage();
        $this->thinkPath   = dirname(dirname(__DIR__)) . '/';
        $this->appPath     = $appPath ?: realpath(dirname($_SERVER['SCRIPT_FILENAME']) . '/../application') . '/';
        $this->rootPath    = dirname(realpath($this->appPath)) . '/';
        $this->runtimePath = $this->rootPath . 'runtime/';
        $this->routePath   = $this->rootPath . 'route/';
        $this->configPath  = $this->rootPath . 'config/';
        $this->configExt   = $this->config('app.config_ext') ?: '.php';
    }
    public function initDefaultConfig() {
        $this->config->set(require $this->thinkPath. 'convention.php');
    }

    public function initAutoLoader() {
        \think\Loader::register();
        \think\Loader::addClassAlias([
            'App'      => facade\App::class,
            'Build'    => facade\Build::class,
            'Cache'    => facade\Cache::class,
            'Config'   => facade\Config::class,
            'Cookie'   => facade\Cookie::class,
            'Db'       => Db::class,
            'Debug'    => facade\Debug::class,
            'Env'      => Env::class,
            'Facade'   => Facade::class,
            'Hook'     => facade\Hook::class,
            'Lang'     => facade\Lang::class,
            'Log'      => facade\Log::class,
            'Request'  => facade\Request::class,
            'Response' => facade\Response::class,
            'Route'    => facade\Route::class,
            'Session'  => facade\Session::class,
            'Url'      => facade\Url::class,
            'View'     => facade\View::class,
        ]);
    }
    public function initErrorHandle() {
        // 注册错误和异常处理机制
        \think\Error::register();
    }

    public function initContainer() {
        //绑定容器别名
        $this->container->bind([
            'app' => \think\App::class,
            'build' => \think\Build::class,
            'cache' => \think\Cache::class,
            'config' => \think\Config::class,
            'cookie' => \think\Cookie::class,
            'debug' => \think\Debug::class,
            'hook' => \think\Hook::class,
            'lang' => \think\Lang::class,
            'request' => \think\Request::class,
            'response' => \think\Response::class,
            'validate' => \think\Validate::class,
            'session' => \think\Session::class,
            'url' => \think\Url::class,
            'route'=>\think\Route::class,
            'log' => \think\Log::class,
            'view' => \think\View::class,
            // 接口依赖注入
            'think\LoggerInterface' => \think\Log::class,
        ]);
        //绑定别名之后，注入app实例
        $this->container->instance('app',$this);
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

    public function initService() {
        $this->container->bind('crypt',function($app){
            $key=$app->make('config')->get('crypt.key');
            $cipher=$app->make('config')->get('crypt.cipher');
            return new \pudge\tool\Encrypter($key,$cipher);
        });

    }
}