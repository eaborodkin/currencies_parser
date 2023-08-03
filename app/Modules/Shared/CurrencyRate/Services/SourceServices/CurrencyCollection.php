<?php

namespace App\Modules\Shared\CurrencyRate\Services\SourceServices;

use App\Modules\Shared\CurrencyRate\Services\ParseXmlFromUrl;
use App\Modules\Shared\CurrencyRate\ValueObjects\Currency;

class CurrencyCollection extends AbstractCurrencyCollection
{

    public function __construct(
        Currency ...$currencies
    )
    {
        foreach ($currencies as $currency){
            $this->currencies[$currency->getCodeName()] = $currency;
        }
    }

    public static function createFromParseXml(ParseXmlFromUrl $parseXmlFromUrl):self
    {
        $currencies = [];
        foreach ($parseXmlFromUrl->getSimpleXmlElements() as $simpleXMLElement) {
            $currencies[] = Currency::makeFromSimpleXmlElement($simpleXMLElement);
        }

        return new static(...$currencies);
    }
}
