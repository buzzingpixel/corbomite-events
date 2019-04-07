<?php

declare(strict_types=1);

namespace corbomite\tests\EventDispatcher;

use corbomite\events\EventCollector;
use corbomite\events\EventDispatcher;
use corbomite\events\interfaces\EventListenerRegistrationInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Throwable;

class EventDispatcherTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function test() : void
    {
        $collector = $this->createMock(EventCollector::class);

        $collector->expects(self::once())
            ->method('collect');

        $reg = $this->createMock(EventListenerRegistrationInterface::class);

        $reg->expects(self::once())
            ->method('getListenersForEvent')
            ->willReturn([
                Listener1::class,
                Listener2::class,
            ]);

        $di = $this->createMock(ContainerInterface::class);

        $di->expects(self::at(0))
            ->method('get')
            ->with(self::equalTo(EventCollector::class))
            ->willReturn($collector);

        $di->expects(self::at(1))
            ->method('get')
            ->with(self::equalTo(EventListenerRegistrationInterface::class))
            ->willReturn($reg);

        $di->expects(self::at(2))
            ->method('has')
            ->with(self::equalTo(Listener1::class))
            ->willReturn(true);

        $di->expects(self::at(3))
            ->method('get')
            ->with(self::equalTo(Listener1::class))
            ->willReturn(new Listener1());

        $di->expects(self::at(4))
            ->method('has')
            ->with(self::equalTo(Listener2::class))
            ->willReturn(false);

        /** @noinspection PhpParamsInspection */
        $eventDispatcher = new EventDispatcher($di);

        $event = new Event();

        $eventDispatcher->dispatch($event);

        self::assertCount(2, $event->listenersCalled);

        self::assertEquals(Listener1::class, $event->listenersCalled[0]);

        self::assertEquals(Listener2::class, $event->listenersCalled[1]);
    }
}
