<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

use corbomite\events\interfaces\EventInterface;
use corbomite\events\interfaces\EventListenerInterface;

class EventListenerClassTwo implements EventListenerInterface
{
    public function call(EventInterface $event)
    {
        var_dump('EventListenerClassTwo');
    }
}
