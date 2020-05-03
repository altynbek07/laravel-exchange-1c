<?php

namespace Altynbek07\Exchange1C\Interfaces;

/**
 * Interface EventDispatcherInterface.
 */
interface EventDispatcherInterface
{
    /**
     * @param EventInterface $event
     */
    public function dispatch(EventInterface $event): void;
}
