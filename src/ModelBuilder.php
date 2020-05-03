<?php

namespace Altynbek07\Exchange1C;

use Altynbek07\Exchange1C\Exceptions\Exchange1CException;
use Altynbek07\Exchange1C\Interfaces\ModelBuilderInterface;

/**
 * Class ModelBuilder.
 */
class ModelBuilder implements ModelBuilderInterface
{
    /**
     * Если модель в конфиге не установлена, то импорт не будет произведен.
     *
     * @param Config $config
     * @param string $interface
     *
     * @throws Exchange1CException
     *
     * @return null|mixed
     */
    public function getInterfaceClass(Config $config, string $interface)
    {
        $model = $config->getModelClass($interface);
        if ($model) {
            $modelInstance = new $model();
            if ($modelInstance instanceof $interface) {
                return $modelInstance;
            }
        }

        throw new Exchange1CException(sprintf('Model %s not instantiable interface %s', $config->getModelClass($interface), $interface));
    }
}
