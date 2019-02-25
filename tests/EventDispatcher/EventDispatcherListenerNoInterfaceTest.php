<?php
declare(strict_types=1);

namespace corbomite\tests\EventDispatcher;

use corbomite\di\Di;
use PHPUnit\Framework\TestCase;
use corbomite\events\EventCollector;
use corbomite\events\EventDispatcher;
use corbomite\events\EventListenerRegistration;
use corbomite\events\interfaces\EventListenerRegistrationInterface;

class EventDispatcherListenerNoInterfaceTest extends TestCase
{
    public function test(): void
    {
        $collector = $this->createMock(EventCollector::class);

        $collector->expects(self::once())
            ->method('collect');

        $reg = $this->createMock(EventListenerRegistrationInterface::class);

        $reg->expects(self::once())
            ->method('getListenersForEvent')
            ->willReturn([
                Listener1::class,
                ListenerNoInterface::class,
            ]);

        $di = $this->createMock(Di::class);

        $di->expects(self::exactly(2))
            ->method('getFromDefinition')
            ->willReturnCallback(function ($def) use (
                $collector,
                $reg
            ) {
                switch ($def) {
                    case EventCollector::class:
                        return $collector;
                    case EventListenerRegistration::class:
                        return $reg;
                    default:
                        throw new \Exception('Unknown class');
                }
            });

        $di->expects(self::exactly(2))
            ->method('hasDefinition')
            ->with(self::logicalOr(
                self::equalTo(Listener1::class),
                self::equalTo(ListenerNoInterface::class)
            ))
            ->willReturnCallback(function ($def) {
                return $def === Listener1::class;
            });

        $di->expects(self::once())
            ->method('makeFromDefinition')
            ->with(self::equalTo(Listener1::class))
            ->willReturn(new Listener1());

        $eventDispatcher = new EventDispatcher($di);

        $event = new Event();

        $exception = null;

        try {
            $eventDispatcher->dispatch($event);
        } catch (\LogicException $e) {
            $exception = $e;
        }

        self::assertInstanceOf(\LogicException::class, $exception);

        self::assertCount(1, $event->listenersCalled);

        self::assertEquals(Listener1::class, $event->listenersCalled[0]);
    }
}
