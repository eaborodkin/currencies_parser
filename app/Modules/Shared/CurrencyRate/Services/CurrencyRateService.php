<?php

namespace App\Modules\Shared\CurrencyRate\Services;

use App\Models\CurrencyRate;
use App\Modules\Shared\CurrencyRate\Enums\CurrencyEnum;
use App\Modules\Shared\CurrencyRate\Services\SourceServices\CurrencyCollection;
use App\Modules\Shared\CurrencyRate\Services\SourceServices\CurrencyCollectionHelper;
use App\Modules\Shared\CurrencyRate\Services\SourceServices\CurrencyCollectionInterface;
use App\Modules\Shared\CurrencyRate\Services\SourceServices\KgsCurrencyCollection;
use App\Modules\Shared\CurrencyRate\ValueObjects\Currency;
use App\Modules\Shared\CurrencyRate\ValueObjects\Url;
use App\Exceptions\RuntimeException;
use Illuminate\Database\Eloquent\Builder;

class CurrencyRateService implements CurrencyRateServiceInterface
{
    private CurrencyCollectionInterface $dailyWeeklyCurrencyCollection;
    private CurrencyCollectionInterface $dailyWeeklyWithKgsCurrencyCollection;

    public function __construct()
    {
        $dailyCurrencyCollection = CurrencyCollection::createFromParseXml(new ParseXmlFromUrl(new Url(env('DAILY_CURRENCIES_URL'))));
        $weeklyCurrencyCollection = CurrencyCollection::createFromParseXml(new ParseXmlFromUrl(new Url(env('WEEKLY_CURRENCIES_URL'))));
        $this->dailyWeeklyCurrencyCollection = CurrencyCollectionHelper::mergeCurrencyCollections(
            $weeklyCurrencyCollection,
            $dailyCurrencyCollection
        );
        $this->dailyWeeklyWithKgsCurrencyCollection = CurrencyCollectionHelper::mergeCurrencyCollections(
            $this->dailyWeeklyCurrencyCollection,
            new KgsCurrencyCollection()
        );
    }

    public function syncToDb(): void
    {
        /** @var Builder $currencyRate */
        $currencyRate = new CurrencyRate();
        $currencyRate->upsert(
            CurrencyCollectionHelper::convertToModelFormat($this->dailyWeeklyCurrencyCollection),
            ['code', 'created_at'],
            ['rate', 'updated_at'],
        );
    }

    /**
     * @throws RuntimeException
     */
    public function getCurrentRate(CurrencyEnum $currency): float
    {
        /** @var Currency $currencyValueObject */
        if (!$currencyValueObject = $this->dailyWeeklyWithKgsCurrencyCollection->getCurrencyByCode($currency->value)) {
            throw RuntimeException::invalidCurrencyCode($currency);
        }

        return $currencyValueObject->getCurrencyValue();
    }

    public function __destruct()
    {
        $this->syncToDb();
    }
}
