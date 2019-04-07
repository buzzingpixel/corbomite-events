<?php

declare(strict_types=1);

namespace corbomite\tests;

use corbomite\events\EventListenerRegistration;
use corbomite\requestdatastore\DataStoreInterface;
use PHPUnit\Framework\TestCase;
use Throwable;

class EventListenerRegistrationTest extends TestCase
{
    /** @var int */
    private $calls = 0;

    /**
     * @throws Throwable
     */
    public function test() : void
    {
        $self = $this;

        $dataStore = $this->createMock(DataStoreInterface::class);

        $dataStore->expects(self::exactly(2))
            ->method('storeItem')
            ->willReturnCallback(static function ($key, $val = null) use ($self) : void {
                $self->calls++;

                $self::assertEquals(
                    EventListenerRegistration::class . '.EventProvider.EventName',
                    $key
                );

                if ($self->calls === 1) {
                    return;
                }

                $self::assertEquals(
                    ['TestClass'],
                    $val
                );
            });

        /** @noinspection PhpParamsInspection */
        $eventReg = new EventListenerRegistration($dataStore);

        $eventReg->register('EventProvider', 'EventName', 'TestClass');

        self::assertEquals(2, $this->calls);
    }
}
