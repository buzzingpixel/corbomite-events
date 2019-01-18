<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\events\interfaces;

interface EventListenerInterface
{
    /**
     * Responds to the event dispatcher call
     * @param EventInterface $event
     */
    public function call(EventInterface $event);
}
