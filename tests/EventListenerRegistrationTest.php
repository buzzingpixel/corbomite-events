<?php
declare(strict_types=1);

namespace corbomite\tests;

use PHPUnit\Framework\TestCase;
use corbomite\events\EventListenerRegistration;
use corbomite\requestdatastore\DataStoreInterface;

class EventListenerRegistrationTest extends TestCase
{
    private $calls = 0;

    public function test(): void
    {
        $self = $this;

        $dataStore = $this->createMock(DataStoreInterface::class);

        $dataStore->expects(self::exactly(2))
            ->method('storeItem')
            ->willReturnCallback(function ($key, $val = null) use ($self) {
                $self->calls++;

                $self::assertEquals(
                    EventListenerRegistration::class . '.EventProvider.EventName',
                    $key
                );

                if ($self->calls === 1) {
                    return;
                }

                $self::assertEquals(
                    [
                        'TestClass',
                    ],
                    $val
                );
            });

        $eventReg = new EventListenerRegistration($dataStore);

        $eventReg->register('EventProvider', 'EventName', 'TestClass');

        self::assertEquals(2, $this->calls);
    }
}
