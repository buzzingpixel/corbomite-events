<?php

declare(strict_types=1);

namespace corbomite\events\interfaces;

interface EventInterface
{
    /**
     * Returns the event provider
     */
    public function provider() : string;

    /**
     * Returns the event name
     */
    public function name() : string;

    /**
     * Returns the value of stopPropagation. Value will be set by incoming
     * parameter if provided
     */
    public function stopPropagation(?bool $stop = null) : bool;
}
