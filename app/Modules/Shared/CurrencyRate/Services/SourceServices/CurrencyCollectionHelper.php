<?php

namespace App\Modules\Shared\CurrencyRate\Services\SourceServices;

use App\Modules\Shared\CurrencyRate\ValueObjects\Currency;

class CurrencyCollectionHelper
{
    public static function mergeCurrencyCollections(CurrencyCollectionInterface ...$currencyCollections): CurrencyCollection
    {
        $collections = [];
        foreach ($currencyCollections as $currencyCollection) {
            $collections[] = $currencyCollection->getCurrencies();
        }

        return new CurrencyCollection(...array_merge(...$collections));
    }

    public static function convertToModelFormat(CurrencyCollectionInterface $currencyCollection): array
    {
        $result = [];
        /** @var Currency $currency */
        foreach ($currencyCollection->getCurrencies() as $currency) {
            $result[] = [
                'code' => $currency->getCodeName(),
                'rate' => $currency->getCurrencyValue(),
            ];
        }
        return $result;
    }
}
