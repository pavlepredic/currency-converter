<?php

namespace PavlePredic\CurrencyConverter\Provider;

use PavlePredic\CurrencyConverter\Entity\ExchangeRateInterface;

interface ExchangeRatesProviderInterface
{
    /**
     * @param string $sourceCurrency
     * @param array $destinationCurrencies
     * @return ExchangeRateInterface[]
     */
    public function getExchangeRates($sourceCurrency, array $destinationCurrencies);

    /**
     * @param string $sourceCurrency
     * @param string $destinationCurrency
     * @return ExchangeRateInterface
     */
    public function getExchangeRate($sourceCurrency, $destinationCurrency);
}