<?php

declare(strict_types=1);

namespace corbomite\tests\EventDispatcher;

use corbomite\events\interfaces\EventInterface;
use corbomite\events\interfaces\EventListenerInterface;

class Listener2 implements EventListenerInterface
{
    public function call(EventInterface $event) : void
    {
        /** @noinspection PhpUndefinedFieldInspection */
        $event->listenersCalled[] = self::class;
    }
}
