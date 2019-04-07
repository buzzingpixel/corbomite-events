<?php

declare(strict_types=1);

namespace corbomite\events\interfaces;

interface EventListenerInterface
{
    /**
     * Responds to the event dispatcher call
     *
     * @return mixed
     */
    public function call(EventInterface $event);
}
