<?php
namespace PavlePredic\CurrencyConverter\Service;

use PavlePredic\CurrencyConverter\Provider\ExchangeRatesProviderInterface;
use PavlePredic\CurrencyConverter\Repository\ExchangeRateRepositoryInterface;

class CurrencyUpdater
{
    private $exchangeRateRepository;
    private $exchangeRatesProvider;
    private $currencies;

    public function __construct(ExchangeRateRepositoryInterface $exchangeRateRepository, ExchangeRatesProviderInterface $exchangeRatesProvider, array $currencies)
    {
        $this->exchangeRateRepository = $exchangeRateRepository;
        $this->exchangeRatesProvider = $exchangeRatesProvider;
        $this->currencies = $currencies;
    }

    public function update()
    {
        foreach ($this->currencies as $sourceCurrency) {
            foreach ($this->exchangeRatesProvider->getExchangeRates($sourceCurrency, $this->currencies) as $exchangeRate) {
                $this->exchangeRateRepository->update($exchangeRate->getSourceCurrency(), $exchangeRate->getDestinationCurrency(), $exchangeRate->getRate());
            }
        }
    }


}