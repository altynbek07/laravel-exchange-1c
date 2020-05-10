<?php

namespace Altynbek07\Exchange1C\Controllers;

use Altynbek07\Exchange1C\Exceptions\Exchange1CException;
use Altynbek07\Exchange1C\Services\CatalogService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Class ImportController.
 */
class ImportController extends Controller
{
    /**
     * @param Request        $request
     * @param CatalogService $service
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function request(Request $request, CatalogService $service)
    {
        $mode = $request->get('mode');
        $type = $request->get('type');

        try {
            if ($type == 'catalog') {
                if (!method_exists($service, $mode)) {
                    throw new Exchange1CException('not correct request, class ExchangeCML not found');
                }

                $response = $service->$mode();
                if (config('exchange-1c.logging', true)) {
                    \Log::debug('exchange_1c:' . PHP_EOL . '$mode: ' . $mode . PHP_EOL . '$response:' . PHP_EOL . $response);
                }

                return response($response, 200, ['Content-Type', 'text/plain']);
            } else {
                throw new \LogicException(sprintf('Logic for method %s not released', $type));
            }
        } catch (Exchange1CException $e) {
            if (config('exchange-1c.logging', true)) {
                \Log::error("exchange_1c: failure \n" . $e->getMessage() . "\n" . $e->getFile() . "\n" . $e->getLine() . "\n");
            }

            $response = "failure\n";
            $response .= $e->getMessage() . "\n";
            $response .= $e->getFile() . "\n";
            $response .= $e->getLine() . "\n";

            return response($response, 500, ['Content-Type', 'text/plain']);
        }
    }
}
