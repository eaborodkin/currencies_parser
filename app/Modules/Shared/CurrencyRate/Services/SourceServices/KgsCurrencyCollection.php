<?php

namespace App\Modules\Shared\CurrencyRate\Services\SourceServices;

use App\Modules\Shared\CurrencyRate\ValueObjects\Currency;

class KgsCurrencyCollection extends AbstractCurrencyCollection
{
    public function __construct()
    {
        $code = 'KGS';
        $this->currencies[$code] = new Currency($code, 1);
    }
}
