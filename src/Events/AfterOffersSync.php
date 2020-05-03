<?php

namespace Altynbek07\Exchange1C\Events;

class AfterOffersSync extends AbstractEventInterface
{
    const NAME = 'after.offers.sync';

    /**
     * @var array
     */
    public $ids;

    /**
     * AfterOffersSync constructor.
     *
     * @param array $ids
     */
    public function __construct(array $ids = [])
    {
        $this->ids = $ids;
    }
}
