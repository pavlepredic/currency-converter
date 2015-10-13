<?php

namespace PavlePredic\CurrencyConverter\Provider;

use PavlePredic\CurrencyConverter\Repository\ExchangeRateRepositoryInterface;

class DbExchangeRatesProvider implements ExchangeRatesProviderInterface
{
    private $exchangeRateRepository;

    public function __construct(ExchangeRateRepositoryInterface $exchangeRateRepository)
    {
        $this->exchangeRateRepository = $exchangeRateRepository;
    }

    public function getExchangeRates($sourceCurrency, array $destinationCurrencies)
    {
        return $this->exchangeRateRepository->findAllBySourceCurrencyAndDestinationCurrencies($sourceCurrency, $destinationCurrencies);
    }

    public function getExchangeRate($sourceCurrency, $destinationCurrency)
    {
        return $this->exchangeRateRepository->findOneBySourceCurrencyAndDestinationCurrency($sourceCurrency, $destinationCurrency);
    }

}