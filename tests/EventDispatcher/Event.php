<?php
declare(strict_types=1);

namespace corbomite\tests\EventDispatcher;

use corbomite\events\interfaces\EventInterface;

class Event implements EventInterface
{
    public $listenersCalled = [];

    public function provider(): string
    {
        return 'Provider';
    }

    public function name(): string
    {
        return 'Name';
    }

    private $stop = false;

    public function stopPropagation(?bool $stop = null): bool
    {
        return $this->stop = $stop ?? $this->stop;
    }
}
