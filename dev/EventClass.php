<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

use corbomite\events\interfaces\EventInterface;

class EventClass implements EventInterface
{
    public function provider(): string
    {
        return 'someProvider';
    }

    public function name(): string
    {
        return 'someEvent';
    }

    private $stop = false;

    public function stopPropagation(?bool $stop = null): bool
    {
        return $this->stop = $stop !== null ? $stop : $this->stop;
    }
}
