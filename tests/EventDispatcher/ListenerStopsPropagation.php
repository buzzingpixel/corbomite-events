<?php
declare(strict_types=1);

namespace corbomite\tests\EventDispatcher;

use corbomite\events\interfaces\EventInterface;
use corbomite\events\interfaces\EventListenerInterface;

class ListenerStopsPropagation implements EventListenerInterface
{
    public function call(EventInterface $event): void
    {
        $event->listenersCalled[] = self::class;
        $event->stopPropagation(true);
    }
}
