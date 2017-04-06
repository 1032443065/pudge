<?php
/**
 * Created by rozbo at 2017/4/6 下午2:25
 */

namespace pudge;


class Service {
    protected $app;
    function __construct(App $app) {
        $this->app=$app;
    }
}