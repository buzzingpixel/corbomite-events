<?php
declare(strict_types=1);

namespace corbomite\tests\EventCollector;

use PHPUnit\Framework\TestCase;
use corbomite\events\EventCollector;
use corbomite\configcollector\Collector;
use corbomite\events\EventListenerRegistration;
use corbomite\requestdatastore\DataStoreInterface;

class EventCollectorStoreItemTrueTest extends TestCase
{
    private $dataStoreCallCount = 0;

    private $regCalls = [];

    public function test(): void
    {
        $self = $this;

        $collector = $this->createMock(Collector::class);

        $dataStore = $this->createMock(DataStoreInterface::class);

        $registration = $this->createMock(EventListenerRegistration::class);

        $collector->expects(self::exactly(0))
            ->method('getPathsFromExtraKey')
            ->with(self::equalTo('eventCollectorConfigFilePath'))
            ->willReturn([
                TESTS_BASE_PATH . '/EventCollector/TestInclude.php',
            ]);

        $registration->expects(self::exactly(0))
            ->method('register')
            ->willReturnCallback(function ($provider, $event, $class) use ($self) {
                $self->regCalls[] = $provider . '.' . $event . '.' . $class;
            });

        $dataStore->expects(self::once())
            ->method('storeItem')
            ->with(self::equalTo(EventCollector::class))
            ->willReturn(true);

        $eventCollector = new EventCollector($collector, $dataStore, $registration);

        $eventCollector->collect();

        self::assertEquals(0, $this->dataStoreCallCount);

        self::assertCount(0, $this->regCalls);
    }
}