<?php

declare(strict_types=1);

use corbomite\events\EventListenerRegistration;

/** @var EventListenerRegistration $eventListenerRegistration */
/** @var EventListenerRegistration $r */

$eventListenerRegistration->register('Provider1', 'Event1', 'Class1');

$r->register('Provider2', 'Event2', 'Class2');
