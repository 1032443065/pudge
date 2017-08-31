<?php
/**
 * Created by rozbo at 2017/8/31 下午1:40
 */

namespace pudge\log;


if (interface_exists('Psr\Log\LoggerInterface')) {
    interface LoggerInterface extends \Psr\Log\LoggerInterface
    {}
} else {
    interface LoggerInterface
    {}
}