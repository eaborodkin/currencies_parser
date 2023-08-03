<?php

namespace App\Modules\Shared\CurrencyRate\Services;

use App\Modules\Shared\CurrencyRate\ValueObjects\Url;
use Illuminate\Support\Facades\Http;
use SimpleXMLElement;

class ParseXmlFromUrl
{
    /** @var array<int, class-string<SimpleXMLElement>> */
    protected array $simpleXmlElements;

    public function __construct(Url $url)
    {
        $response = Http::get($url->value())->body();

        /** @var $xml array */
        $xml = ((array)simplexml_load_string($response))['Currency'];

        $this->simpleXmlElements = $xml;
    }

    /** @return  array<int, class-string<SimpleXMLElement>> */
    public function getSimpleXmlElements(): array
    {
        return $this->simpleXmlElements;
    }
}
