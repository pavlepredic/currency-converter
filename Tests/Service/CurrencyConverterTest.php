<?php
namespace PavlePredic\CurrencyConverter\Tests\Service;

use PavlePredic\CurrencyConverter\Entity\ExchangeRate;
use PavlePredic\CurrencyConverter\Provider\ExchangeRatesProviderInterface;
use PavlePredic\CurrencyConverter\Service\CurrencyConverter;
use PavlePredic\CurrencyConverter\Tests\Provider\ExchangeRateTest;

/**
 * @group unit
 */
class CurrencyConverterTest extends ExchangeRateTest
{
    public function testConvert()
    {
        $sourceCurrency = 'EUR';
        $destinationCurrency = 'USD';
        $mockRate = 1.23;

        $exchangeRate = ExchangeRate::create($sourceCurrency, $destinationCurrency, $mockRate);
        $rateProvider = $this->getMock(ExchangeRatesProviderInterface::class);
        $rateProvider->expects($this->once())
            ->method('getExchangeRate')
            ->will($this->returnValue($exchangeRate))
        ;

        $converter = new CurrencyConverter($rateProvider);
        $converted = $converter->convert(100, $sourceCurrency, $destinationCurrency);
        $this->assertEquals(123, $converted);
    }
}