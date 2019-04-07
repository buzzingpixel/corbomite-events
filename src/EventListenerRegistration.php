<?php

declare(strict_types=1);

namespace corbomite\events;

use corbomite\events\interfaces\EventListenerRegistrationInterface;
use corbomite\requestdatastore\DataStoreInterface;

class EventListenerRegistration implements EventListenerRegistrationInterface
{
    /** @var DataStoreInterface */
    private $dataStore;

    public function __construct(DataStoreInterface $dataStore)
    {
        $this->dataStore = $dataStore;
    }

    public function register(string $provider, string $eventName, string $class) : void
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
    ) : iterable {
        $items = $this->dataStore->storeItem(
            self::class . '.' . $provider . '.' . $eventName
        );

        if (! $items) {
            $items = [];
        }

        return $items;
    }
}
