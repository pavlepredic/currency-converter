<?php
namespace PavlePredic\CurrencyConverter\Tests\Provider;

use PavlePredic\CurrencyConverter\Entity\ExchangeRateInterface;
use PavlePredic\CurrencyConverter\Provider\FixerExchangeRatesProvider;

/**
 * @group unit
 */
class FixerExchangeRatesProviderTest extends ExchangeRateTest
{
    public function testGetExchangeRate()
    {
        $fixer = new FixerExchangeRatesProvider();
        /** @var ExchangeRateInterface $rate */
        $sourceCurrency = 'EUR';
        $destinationCurrency = 'USD';
        $rate = $fixer->getExchangeRate($sourceCurrency, $destinationCurrency);
        $this->assertInstanceOf(ExchangeRateInterface::class, $rate);
        $this->validateExchangeRate($rate, $sourceCurrency, $destinationCurrency);
    }

    public function testGetExchangeRates()
    {
        $fixer = new FixerExchangeRatesProvider();
        $sourceCurrency = 'EUR';
        $destinationCurrencies = ['USD', 'GBP'];
        $rates = $fixer->getExchangeRates($sourceCurrency, $destinationCurrencies);
        $this->assertInternalType('array', $rates);
        $this->validateExchangeRates($rates, $sourceCurrency, $destinationCurrencies);
    }
}