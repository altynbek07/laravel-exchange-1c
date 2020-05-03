<?php

namespace Altynbek07\Exchange1C\Events;

use Altynbek07\Exchange1C\Interfaces\ProductInterface;

class AfterUpdateProduct extends AbstractEventInterface
{
    const NAME = 'after.update.product';

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
