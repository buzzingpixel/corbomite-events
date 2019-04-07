<?php

declare(strict_types=1);

namespace corbomite\events;

use corbomite\configcollector\Collector;
use corbomite\requestdatastore\DataStoreInterface;

class EventCollector
{
    /** @var Collector */
    private $collector;
    /** @var DataStoreInterface */
    private $dataStore;
    /** @var EventListenerRegistration */
    private $registration;

    public function __construct(
        Collector $collector,
        DataStoreInterface $dataStore,
        EventListenerRegistration $registration
    ) {
        $this->collector    = $collector;
        $this->dataStore    = $dataStore;
        $this->registration = $registration;
    }

    public function collect() : void
    {
        if ($this->dataStore->storeItem(self::class) === true) {
            return;
        }

        $paths = $this->collector->getPathsFromExtraKey(
            'eventCollectorConfigFilePath'
        );

        /** @noinspection PhpUnusedLocalVariableInspection */
        $eventListenerRegistration = $r = $this->registration;

        foreach ($paths as $path) {
            require $path;
        }

        $this->dataStore->storeItem(self::class, true);
    }
}
