<?php

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
    'models' => [
        \Altynbek07\Exchange1C\Interfaces\GroupInterface::class => \App\Models\Category::class,
        \Altynbek07\Exchange1C\Interfaces\ProductInterface::class => \App\Models\Product::class,
        \Altynbek07\Exchange1C\Interfaces\OfferInterface::class => \App\Models\Offer::class,
    ],
];
