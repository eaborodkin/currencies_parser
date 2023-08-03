<?php

namespace App\Modules\Shared\CurrencyRate\ValueObjects;

use InvalidArgumentException;

abstract class BaseValueObject
{
    public function __construct()
    {
        if (!$this->isValid()) {
            throw $this->throwInvalidValueException();
        }
    }
    protected function throwInvalidValueException(): InvalidArgumentException {
        return new InvalidArgumentException(static::class . ': Parameter(s) is/are not valid!');
    }
    abstract protected function isValid(): bool;
    abstract public function value();
}
