<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\events;

use corbomite\requestdatastore\DataStoreInterface;
use corbomite\events\interfaces\EventListenerRegistrationInterface;

class EventListenerRegistration implements EventListenerRegistrationInterface
{
    private $dataStore;

    public function __construct(DataStoreInterface $dataStore)
    {
        $this->dataStore = $dataStore;
    }

    public function register(string $provider, string $eventName, string $class)
    {
        $items = $this->getListenersForEvent($provider, $eventName);

        $items[] = $class;

        $this->dataStore->storeItem(
            self::class . '.' . $provider . '.' . $eventName,
            $items
        );
    }

    public function getListenersForEvent(
        string $provider,
        string $eventName
    ): iterable {
        $items = $this->dataStore->storeItem(
            self::class . '.' . $provider . '.' . $eventName
        );

        if (! $items) {
            $items = [];
        }

        return $items;
    }
}
