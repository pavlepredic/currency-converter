<?php

namespace PavlePredic\CurrencyConverter\Service;

use PavlePredic\CurrencyConverter\Exception\CurrencyConversionException;
use PavlePredic\CurrencyConverter\Provider\ExchangeRatesProviderInterface;
use PavlePredic\CurrencyConverter\Provider\FixerExchangeRatesProvider;

class CurrencyConverter
{
    public function __construct(ExchangeRatesProviderInterface $exchangeRatesProvider = null)
    {
        if (!$exchangeRatesProvider) {
            $exchangeRatesProvider = new FixerExchangeRatesProvider();
        }
        $this->exchangeRatesProvider = $exchangeRatesProvider;
    }

    public function convert($amount, $sourceCurrency, $destinationCurrency)
    {
        if ($amount === null or !$sourceCurrency or !$destinationCurrency) {
            throw new CurrencyConversionException("Missing arguments to " . __METHOD__);
        }
        if ($sourceCurrency === $destinationCurrency) {
            return $amount;
        }

        $rate = $this->exchangeRatesProvider->getExchangeRate($sourceCurrency, $destinationCurrency);
        if (!$rate) {
            throw new CurrencyConversionException("No exchange rate for converting $sourceCurrency to $destinationCurrency");
        }
        return $amount * $rate->getRate();
    }
}