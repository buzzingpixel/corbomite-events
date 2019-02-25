<?php
declare(strict_types=1);

namespace corbomite\tests\EventDispatcher;

use corbomite\events\interfaces\EventInterface;

class ListenerNoInterface
{
    public function call(EventInterface $event): void
    {
        $event->listenersCalled[] = self::class;
    }
}
