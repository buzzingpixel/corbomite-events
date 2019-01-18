<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\events;

use LogicException;
use corbomite\di\Di;
use corbomite\events\interfaces\EventInterface;
use corbomite\events\interfaces\EventListenerInterface;
use corbomite\events\interfaces\EventDispatcherInterface;

class EventDispatcher implements EventDispatcherInterface
{
    private $di;

    public function __construct(Di $di)
    {
        $this->di = $di;
        /** @noinspection PhpUnhandledExceptionInspection */
        $di->getFromDefinition(EventCollector::class)->collect();
    }

    public function dispatch(
        string $provider,
        string $name,
        EventInterface $event
    ) {
        /** @noinspection PhpUnhandledExceptionInspection */
        $reg = $this->di->getFromDefinition(EventListenerRegistration::class);

        $events = $reg->getListenersForEvent($provider, $name);

        foreach ($events as $listener) {
            if ($event->stopPropagation()) {
                break;
            }

            $this->dispatchEvent($event, $listener);
        }
    }

    private function dispatchEvent(EventInterface $event, string $listener)
    {
        $listenerConstructedClass = null;

        /** @noinspection PhpUnhandledExceptionInspection */
        if ($this->di->hasDefinition($listener)) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $listenerConstructedClass = $this->di->makeFromDefinition(
                $listener
            );
        }

        if (! $listenerConstructedClass) {
            $listenerConstructedClass = new $listener();
        }

        $implementsInterface = $listenerConstructedClass instanceof EventListenerInterface;

        if (! $implementsInterface) {
            throw new LogicException(
                'Listener must implement EventListenerInterface'
            );
        }

        /** @var EventListenerInterface $listenerConstructedClass */

        $listenerConstructedClass->call($event);
    }
}
