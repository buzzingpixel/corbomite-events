#!/usr/bin/env php
<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

use corbomite\di\Di;
use corbomite\events\EventDispatcher;
use corbomite\events\EventListenerRegistration;

define('ENTRY_POINT', 'app');
define('APP_BASE_PATH', __DIR__);
define('APP_VENDOR_PATH', APP_BASE_PATH . '/vendor');

require APP_VENDOR_PATH . '/autoload.php';

require 'dev/EventClass.php';
require 'dev/EventListenerClassOne.php';
require 'dev/EventListenerClassTwo.php';

$reg = Di::get(EventListenerRegistration::class);

$reg->register('someProvider', 'someEvent', EventListenerClassOne::class);
$reg->register('someProvider', 'someEvent', EventListenerClassTwo::class);

$dispatcher = Di::get(EventDispatcher::class);

$event = new EventClass();

$dispatcher->dispatch('someProvider', 'someEvent', $event);
