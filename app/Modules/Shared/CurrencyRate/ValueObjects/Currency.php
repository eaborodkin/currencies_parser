<?php

namespace App\Modules\Shared\CurrencyRate\ValueObjects;

use SimpleXMLElement;

class Currency extends BaseValueObject
{

    /**
     * @return string
     */
    public function getCodeName(): string
    {
        return $this->codeName;
    }

    /**
     * @return float
     */
    public function getCurrencyValue(): float
    {
        return $this->currencyValue;
    }

    public function __construct(
        private readonly string $codeName,
        private readonly float  $currencyValue
    )
    {
        parent::__construct();
    }

    protected function isValid(): bool
    {
        return true;
    }

    public function value(): array
    {
        return [$this->codeName => $this->currencyValue];
    }

    public static function makeFromSimpleXmlElement(SimpleXMLElement $simpleXMLElement): static
    {
        $codeName = $simpleXMLElement['ISOCode'];
        $currencyValue = (float)str_replace(',', '.', $simpleXMLElement->Value)
            / (float)str_replace(',', '.', $simpleXMLElement->Nominal);

        return new static($codeName, $currencyValue);
    }
}
