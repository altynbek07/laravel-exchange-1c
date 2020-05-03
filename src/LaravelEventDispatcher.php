<?php

namespace Altynbek07\Exchange1C;

use Altynbek07\Exchange1C\Interfaces\EventDispatcherInterface;
use Altynbek07\Exchange1C\Interfaces\EventInterface;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class LaravelEventDispatcher.
 */
class LaravelEventDispatcher implements EventDispatcherInterface
{
    /**
     * @var Dispatcher
     */
    protected $eventDispatcher;

    /**
     * LaravelEventDispatcher constructor.
     *
     * @param Dispatcher $eventDispatcher
     */
    public function __construct(Dispatcher $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param EventInterface $event
     */
    public function dispatch(EventInterface $event): void
    {
        $this->eventDispatcher->dispatch($event);
    }
}
