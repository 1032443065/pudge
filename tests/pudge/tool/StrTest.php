<?php
/**
 * Created by rozbo at 2017/4/6 下午4:38
 */

namespace tests\pudge\tool;

use pudge\tool\Str;
use PHPUnit\Framework\TestCase;

class StrTest extends TestCase {
    public function testLength() {
        $this->assertEquals('3',Str::length('我爱你'));
    }

    public function testEndWith() {
        $this->assertTrue(Str::endsWith('我爱你',"爱你"));
    }

    public function testStartWith() {
        $this->assertTrue(Str::startsWith('我爱你',"我爱"));
    }
}
