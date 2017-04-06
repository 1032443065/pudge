<?php
/**
 * Created by rozbo at 2017/4/6 下午12:52
 */

namespace tests\pudge\facade;

use pudge\facade\Crypt;
use PHPUnit\Framework\TestCase;

class CryptTest extends TestCase {
    public function test() {
        $orig='我是一个好人';
        $tmp=Crypt::encrypt($orig);
        $this->assertEquals($orig,Crypt::decrypt($tmp));
    }
}
