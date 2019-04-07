<?php

declare(strict_types=1);

namespace corbomite\events\interfaces;

interface EventDispatcherInterface
{
    /**
     * Dispatches an event
     *
     * @return mixed
     */
    public function dispatch(EventInterface $event);
}
