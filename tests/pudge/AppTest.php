<?php
/**
 * Created by rozbo at 2017/4/5 下午2:42
 */

namespace tests\pudge;

use think\App;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase {
    public function testGetAppPath() {
        $this->assertStringStartsWith("/",app()->getAppPath());
    }
}
