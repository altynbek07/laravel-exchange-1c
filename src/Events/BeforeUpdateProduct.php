<?php

namespace Altynbek07\Exchange1C\Events;

use Altynbek07\Exchange1C\Interfaces\ProductInterface;

class BeforeUpdateProduct extends AbstractEventInterface
{
    const NAME = 'before.update.product';

    /**
     * @var ProductInterface
     */
    public $product;

    /**
     * BeforeUpdateProduct constructor.
     *
     * @param ProductInterface $product
     */
    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }
}
