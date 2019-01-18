<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\events\interfaces;

interface EventInterface
{
    /**
     * Returns the event provider
     * @return string
     */
    public function provider(): string;

    /**
     * Returns the event name
     * @return string
     */
    public function name(): string;

    /**
     * Returns the value of stopPropagation. Value will be set by incoming
     * parameter if provided
     * @param bool|null $stop
     * @return bool
     */
    public function stopPropagation(?bool $stop = null): bool;
}
