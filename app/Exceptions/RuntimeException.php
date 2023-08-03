<?php

namespace App\Exceptions;

use App\Modules\Shared\CurrencyRate\Enums\CurrencyEnum;
use Exception;

class RuntimeException extends Exception
{
    public static function invalidCurrencyCode(CurrencyEnum $currencyEnum): static
    {
        $msg = <<<MSG
    RuntimeException

  $currencyEnum->value => Rate not found

MSG;
//        echo $msg;
        return new static($msg);
    }
}
