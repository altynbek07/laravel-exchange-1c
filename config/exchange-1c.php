<?php

use Altynbek07\Exchange1C\Interfaces\GroupInterface;
use Altynbek07\Exchange1C\Interfaces\OfferInterface;
use Altynbek07\Exchange1C\Interfaces\ProductInterface;

return [
    /**
     *
     */
    'exchange_path' => 'exchange-1c',
    /**
     *
     */
    'import_dir' => storage_path('app/exchange-1c'),
    /**
     *
     */
    'login' => env('EXCHANGE_1C_LOGIN', 'admin'),
    /**
     *
     */
    'password' => env('EXCHANGE_1C_PASSWORD', 'admin'),
    /**
     *
     */
    'use_zip' => false,
    /**
     *
     */
    'file_part' => 0,
    /**
     *
     */
    'logging' => true,
    /**
     *
     */
    'importFiles' => ['import.xml', 'offers.xml'],
    /**
     *
     */
    'models' => [
        GroupInterface::class => \App\Models\Category::class,
        ProductInterface::class => \App\Models\Product::class,
        OfferInterface::class => \App\Models\Offer::class,
    ],
];
