<?php

declare(strict_types=1);

use corbomite\configcollector\Collector;
use corbomite\di\Di;
use corbomite\events\EventCollector;
use corbomite\events\EventDispatcher;
use corbomite\events\EventListenerRegistration;
use corbomite\requestdatastore\DataStore;

return [
    EventCollector::class => static function () {
        return new EventCollector(
            Di::get(Collector::class),
            Di::get(DataStore::class),
            Di::get(EventListenerRegistration::class)
        );
    },
    EventListenerRegistration::class => static function () {
        return new EventListenerRegistration(Di::get(DataStore::class));
    },
    EventDispatcher::class => static function () {
        return new EventDispatcher(new Di());
    },
];
