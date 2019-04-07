<?php

declare(strict_types=1);

namespace corbomite\events;

use corbomite\events\interfaces\EventDispatcherInterface;
use corbomite\events\interfaces\EventInterface;
use corbomite\events\interfaces\EventListenerInterface;
use corbomite\events\interfaces\EventListenerRegistrationInterface;
use LogicException;
use Psr\Container\ContainerInterface;

class EventDispatcher implements EventDispatcherInterface
{
    /** @var ContainerInterface */
    private $di;

    public function __construct(ContainerInterface $di)
    {
        $this->di = $di;
        /** @noinspection PhpUnhandledExceptionInspection */
        $di->get(EventCollector::class)->collect();
    }

    public function dispatch(EventInterface $event) : void
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $reg = $this->di->get(EventListenerRegistrationInterface::class);

        $events = $reg->getListenersForEvent($event->provider(), $event->name());

        foreach ($events as $listener) {
            if ($event->stopPropagation()) {
                break;
            }

            $this->dispatchEvent($event, $listener);
        }
    }

    private function dispatchEvent(EventInterface $event, string $listener) : void
    {
        $listenerConstructedClass = null;

        /** @noinspection PhpUnhandledExceptionInspection */
        if ($this->di->has($listener)) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $listenerConstructedClass = $this->di->get($listener);
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
