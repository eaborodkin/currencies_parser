<?php

namespace App\Modules\Shared\CurrencyRate\Services\SourceServices;

use App\Modules\Shared\CurrencyRate\ValueObjects\Currency;

interface CurrencyCollectionInterface
{
    /** @return  array<int, class-string<Currency>> */
    public function getCurrencies(): array;

    public function getCurrencyByCode(string $codeName): ?Currency;
}
