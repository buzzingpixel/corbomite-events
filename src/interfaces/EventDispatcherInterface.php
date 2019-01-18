<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\events\interfaces;

interface EventDispatcherInterface
{
    /**
     * Dispatches an event
     * @param string $provider Usually a class or interface name but can be any unique string
     * @param string $name Name of event
     * @param EventInterface $event
     */
    public function dispatch(
        string $provider,
        string $name,
        EventInterface $event
    );
}
