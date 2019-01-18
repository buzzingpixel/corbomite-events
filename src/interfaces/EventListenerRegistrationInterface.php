<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\events\interfaces;

interface EventListenerRegistrationInterface
{
    /**
     * Registers a listener
     * @param string $provider Usually a class or interface name but can be any unique string
     * @param string $eventName Name of event
     * @param string $class Class to call. Must implement \corbomite\events\interfaces\EventListenerInterface
     */
    public function register(
        string $provider,
        string $eventName,
        string $class
    );

    /**
     * @param string $provider
     * @param string $eventName
     * @return iterable[string] The class name of the listener
     */
    public function getListenersForEvent(
        string $provider,
        string $eventName
    ): iterable;
}
