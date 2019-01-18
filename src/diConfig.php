<?php
declare(strict_types=1);

use corbomite\di\Di;
use corbomite\events\EventCollector;
use corbomite\events\EventDispatcher;
use corbomite\configcollector\Collector;
use corbomite\requestdatastore\DataStore;
use corbomite\events\EventListenerRegistration;

return [
    EventCollector::class => function () {
        return new EventCollector(
            Di::get(DataStore::class),
            Di::get(Collector::class),
            Di::get(EventListenerRegistration::class)
        );
    },
    EventListenerRegistration::class => function () {
        return new EventListenerRegistration(Di::get(DataStore::class));
    },
    EventDispatcher::class => function () {
        return new EventDispatcher(new Di());
    },
];
