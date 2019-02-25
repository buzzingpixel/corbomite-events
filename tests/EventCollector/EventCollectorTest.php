<?php
declare(strict_types=1);

namespace corbomite\tests\EventCollector;

use PHPUnit\Framework\TestCase;
use corbomite\events\EventCollector;
use corbomite\configcollector\Collector;
use corbomite\events\EventListenerRegistration;
use corbomite\requestdatastore\DataStoreInterface;

class EventCollectorTest extends TestCase
{
    private $dataStoreCallCount = 0;

    private $regCalls = [];

    public function test(): void
    {
        $self = $this;

        $collector = $this->createMock(Collector::class);

        $dataStore = $this->createMock(DataStoreInterface::class);

        $registration = $this->createMock(EventListenerRegistration::class);

        $collector->expects(self::once())
            ->method('getPathsFromExtraKey')
            ->with(self::equalTo('eventCollectorConfigFilePath'))
            ->willReturn([
                TESTS_BASE_PATH . '/EventCollector/TestInclude.php',
            ]);

        $registration->expects(self::exactly(2))
            ->method('register')
            ->willReturnCallback(function ($provider, $event, $class) use ($self) {
                $self->regCalls[] = $provider . '.' . $event . '.' . $class;
            });

        $dataStore->expects(self::exactly(2))
            ->method('storeItem')
            ->willReturnCallback(function ($key, $val = null) use ($self) {
                $self->dataStoreCallCount++;

                $self::assertEquals(
                    EventCollector::class,
                    $key
                );

                if ($self->dataStoreCallCount === 1) {
                    return;
                }

                self::assertTrue($val);
            });

        $eventCollector = new EventCollector($collector, $dataStore, $registration);

        $eventCollector->collect();

        self::assertEquals(2, $this->dataStoreCallCount);

        self::assertEquals(
            'Provider1.Event1.Class1',
            $this->regCalls[0]
        );

        self::assertEquals(
            'Provider2.Event2.Class2',
            $this->regCalls[1]
        );
    }
}
