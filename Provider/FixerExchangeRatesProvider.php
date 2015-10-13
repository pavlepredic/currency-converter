<?php

namespace PavlePredic\CurrencyConverter\Provider;

use PavlePredic\CurrencyConverter\Entity\ExchangeRate;
use PavlePredic\CurrencyConverter\Exception\FixerCurrencyConversionException;

class FixerExchangeRatesProvider implements ExchangeRatesProviderInterface
{
    const API_URL = 'http://api.fixer.io/latest';

    public function getExchangeRates($sourceCurrency, array $destinationCurrencies)
    {
        $rates = [];
        foreach ($this->apiCall($sourceCurrency, $destinationCurrencies) as $destinationCurrency => $rate) {
            $rates[] = ExchangeRate::create($sourceCurrency, $destinationCurrency, $rate);
        }

        return $rates;
    }

    public function getExchangeRate($sourceCurrency, $destinationCurrency)
    {
        $rates = $this->apiCall($sourceCurrency, [$destinationCurrency]);
        if (!isset($rates[$destinationCurrency])) {
            throw new FixerCurrencyConversionException("Destination currency $destinationCurrency not found in API response");
        }
        return ExchangeRate::create($sourceCurrency, $destinationCurrency, $rates[$destinationCurrency]);
    }

    protected function apiCall($sourceCurrency, array $destinationCurrencies)
    {
        $url = self::API_URL . '?symbols=' . join(',', $destinationCurrencies) . '&base=' . $sourceCurrency;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new FixerCurrencyConversionException("Error performing HTTP request. Curl error: " . curl_error($ch));
        }

        $data = json_decode($result, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new FixerCurrencyConversionException("Error parsing JSON: $result");
        }

        return $data['rates'];
    }

}