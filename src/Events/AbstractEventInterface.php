<?php

namespace Altynbek07\Exchange1C\Events;

/**
 * Class AbstractEventInterface.
 */
abstract class AbstractEventInterface implements \Altynbek07\Exchange1C\Interfaces\EventInterface
{
    public const NAME = self::class;

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
