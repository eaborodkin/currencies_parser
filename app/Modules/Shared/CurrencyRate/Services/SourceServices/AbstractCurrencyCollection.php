<?php

namespace App\Modules\Shared\CurrencyRate\Services\SourceServices;

use App\Modules\Shared\CurrencyRate\ValueObjects\Currency;

abstract class AbstractCurrencyCollection implements CurrencyCollectionInterface
{
    /** @var array<string, class-string<Currency>> */
    protected array $currencies;

    /** @return  array<string, class-string<Currency>> */
    public function getCurrencies(): array
    {
        return $this->currencies;
    }

    public function getCurrencyByCode(string $codeName): ?Currency
    {
        if (!key_exists($codeName, $this->currencies)) {
            return null;
        }

        /** @var Currency $currency */
        $currency = $this->currencies[$codeName];

        return $currency;
    }
}
