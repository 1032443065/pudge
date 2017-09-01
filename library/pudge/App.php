<?php
/**
 * Created by rozbo at 2017/4/5 下午3:32
 */

namespace pudge;

use think\App as ThinkApp;
use think\Facade;

class App extends ThinkApp {
    public function __construct($appPath) {
        $this->initAutoLoader();
        $this->container   = \think\Container::getInstance();
        $this->initErrorHandle();
        $this->initContainer();
        $this->initFacade();
        $this->initPath($appPath);
        $this->initDefaultConfig();
        $this->initEnv();
        $this->initService();
        parent::__construct($appPath);

    }

    private function initEnv() {
        $this->env->set([
            'think_path'   => $this->thinkPath,
            'root_path'    => $this->rootPath,
            'app_path'     => $this->appPath,
            'config_path'  => $this->configPath,
            'route_path'   => $this->routePath,
            'runtime_path' => $this->runtimePath,
            'extend_path'  => $this->rootPath . 'extend/',
            'vendor_path'  => $this->rootPath . 'vendor/',
        ]);
        // 加载环境变量配置文件
        if (is_file($this->rootPath . '.env')) {
            $this->env->load($this->rootPath . '.env');
        }
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
    }
    public function initDefaultConfig() {
        $this->config->set(require $this->thinkPath. 'convention.php');
    }

    public function initAutoLoader() {
        \think\Loader::register();
        \think\Loader::addClassAlias([
            'App'      => \think\facade\App::class,
            'Build'    => \think\facade\Build::class,
            'Cache'    => \think\facade\Cache::class,
            'Config'   => \think\facade\Config::class,
            'Cookie'   => \think\facade\Cookie::class,
            'Db'       => \think\Db::class,
            'Debug'    => \think\facade\Debug::class,
            'Env'      => \think\Env::class,
            'Facade'   => \think\Facade::class,
            'Hook'     => \think\facade\Hook::class,
            'Lang'     => \think\facade\Lang::class,
            'Log'      => \think\facade\Log::class,
            'Request'  => \think\facade\Request::class,
            'Response' => \think\facade\Response::class,
            'Route'    => \think\facade\Route::class,
            'Session'  => \think\facade\Session::class,
            'Url'      => \think\facade\Url::class,
            'View'     => \think\facade\View::class,
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
            'env' => \think\Env::class,
            'build' => \think\Build::class,
            'cache' => \think\Cache::class,
            'config' => \think\Config::class,
            'cookie' => \think\Cookie::class,
            'debug' => \think\Debug::class,
            'env'   => \think\Env::class,
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
            'curl' => \pudge\helper\Curl::class,
            // 接口依赖注入
            'think\LoggerInterface' => \think\Log::class,
        ]);
        //绑定别名之后，注入app实例
        $this->container->instance('app',$this);
    }

    public function initFacade() {
// 注册核心类的静态代理
        Facade::bind([
            \think\facade\App::class => \think\App::class,
            \think\facade\Build::class => \think\Build::class,
            \think\facade\Cache::class => \think\Cache::class,
            \think\facade\Config::class => \think\Config::class,
            \think\facade\Cookie::class => \think\Cookie::class,
            \think\facade\Debug::class => \think\Debug::class,
            \think\facade\Hook::class => \think\Hook::class,
            \think\facade\Lang::class => \think\Lang::class,
            \think\facade\Log::class => \think\Log::class,
            \think\facade\Request::class => \think\Request::class,
            \think\facade\Response::class => \think\Response::class,
            \think\facade\Route::class => \think\Route::class,
            \think\facade\Session::class => \think\Session::class,
            \think\facade\Url::class => \think\Url::class,
            \think\facade\View::class => \think\View::class,
        ]);
    }

    public function initService() {
        //加密解密类
        $this->container->bind('crypt',function($app){
            $key=$app->make('config')->get('crypt.key');
            $cipher=$app->make('config')->get('crypt.cipher');
            return new \pudge\suit\Encrypter($key,$cipher);
        });

    }
}