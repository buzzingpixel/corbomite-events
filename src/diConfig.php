<?php

declare(strict_types=1);

use corbomite\configcollector\Collector;
use corbomite\events\EventCollector;
use corbomite\events\EventDispatcher;
use corbomite\events\EventListenerRegistration;
use corbomite\events\interfaces\EventListenerRegistrationInterface;
use corbomite\requestdatastore\DataStore;
use Psr\Container\ContainerInterface;

return [
    EventCollector::class => static function (ContainerInterface $di) {
        return new EventCollector(
            $di->get(Collector::class),
            $di->get(DataStore::class),
            $di->get(EventListenerRegistration::class)
        );
    },
    EventListenerRegistration::class => static function (ContainerInterface $di) {
        return new EventListenerRegistration($di->get(DataStore::class));
    },
    EventListenerRegistrationInterface::class => static function (ContainerInterface $di) {
        return $di->get(EventListenerRegistration::class);
    },
    EventDispatcher::class => static function (ContainerInterface $di) {
        return new EventDispatcher($di);
    },
];
