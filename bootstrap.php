<?php

use Monolog\ErrorHandler;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

$errorHandler = ErrorHandler::register((
new Logger('system_log',
    [
        (new StreamHandler('var/log/system.log', Logger::ERROR))->setFormatter(new LineFormatter()),
    ])),
    false
);
$errorHandler->registerErrorHandler([], false, E_ALL);
