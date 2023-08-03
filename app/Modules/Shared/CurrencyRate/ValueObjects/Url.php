<?php

namespace App\Modules\Shared\CurrencyRate\ValueObjects;

use InvalidArgumentException;

class Url extends BaseValueObject
{
    public function __construct(
        private readonly ?string $url
    )
    {
        parent::__construct();
    }

    protected function isValid(): bool
    {
        return match (true) {
            !empty($this->url) => true,
            default => false,
        };
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->url;
    }
}
