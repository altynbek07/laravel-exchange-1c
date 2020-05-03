<?php
$path = config('exchange-1c.exchange_path', 'exchange-1c');

Route::group(['middleware' => [\Illuminate\Session\Middleware\StartSession::class]], function () use ($path) {
    Route::match(['get', 'post'], $path, Altynbek07\Exchange1C\Controllers\ImportController::class.'@request');
});
