<?php

declare(strict_types=1);

namespace corbomite\events\interfaces;

interface EventListenerRegistrationInterface
{
    /**
     * Registers a listener
     *
     * @param string $provider  Usually a class or interface name but can be any unique string
     * @param string $eventName Name of event
     * @param string $class     Class to call. Must implement \corbomite\events\interfaces\EventListenerInterface
     *
     * @return mixed
     */
    public function register(
        string $provider,
        string $eventName,
        string $class
    );

    /**
     * @return iterable[string] The class name of the listener
     */
    public function getListenersForEvent(
        string $provider,
        string $eventName
    ) : iterable;
}
