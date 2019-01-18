<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace corbomite\events;

use corbomite\configcollector\Collector;
use corbomite\requestdatastore\DataStoreInterface;

class EventCollector
{
    private $dataStore;
    private $collector;
    private $registration;

    public function __construct(
        Collector $collector,
        DataStoreInterface $dataStore,
        EventListenerRegistration $registration
    ) {
        $this->collector = $collector;
        $this->dataStore = $dataStore;
        $this->registration = $registration;
    }

    public function collect()
    {
        if ($this->dataStore->storeItem(self::class) === true) {
            return;
        }

        $paths = $this->collector->getExtraKeyAsArray(
            'eventCollectorConfigFilePath'
        );

        $eventListenerRegistration = $this->registration;

        foreach ($paths as $path) {
            require $path;
        }

        $this->dataStore->storeItem(self::class, true);
    }
}
