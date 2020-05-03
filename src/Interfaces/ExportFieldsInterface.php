<?php

namespace Altynbek07\Exchange1C\Interfaces;

interface ExportFieldsInterface
{
    /**
     * @param mixed|null $context
     *
     * @return array
     */
    public function getExportFields1c($context = null);
}
