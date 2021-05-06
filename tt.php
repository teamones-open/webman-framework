#!/usr/bin/env php
<?php

require dirname(__DIR__) . '/vendor/autoload.php';
ini_set('date.timezone', date_default_timezone_get());

$statusCode = 0;
try {
    if ($phpunitPath = getenv('TEST_PHPUNIT_PATH')) {
        require $phpunitPath;
    }
    $statusCode = PHPUnit\TextUI\Command::main(false);
} catch (\Exception $e) {
    $statusCode = $e->getCode();
};


exit($statusCode);