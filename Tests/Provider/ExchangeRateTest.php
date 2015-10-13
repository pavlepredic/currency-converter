<?php
namespace PavlePredic\CurrencyConverter\Tests\Provider;

use PavlePredic\CurrencyConverter\Entity\ExchangeRateInterface;

abstract class ExchangeRateTest extends \PHPUnit_Framework_TestCase
{
    protected function validateExchangeRate(ExchangeRateInterface $exchangeRateInterface, $expectedSourceCurrency, $expectedDestinationCurrency)
    {
        $this->assertInternalType('float', $exchangeRateInterface->getRate());
        $this->assertEquals($expectedSourceCurrency, $exchangeRateInterface->getSourceCurrency());
        $this->assertEquals($expectedDestinationCurrency, $exchangeRateInterface->getDestinationCurrency());
    }

    protected function validateExchangeRates(array $exchangeRateInterfaces, $expectedSourceCurrency, array $expectedDestinationCurrencies)
    {
        /** @var ExchangeRateInterface $exchangeRateInterface */
        foreach ($exchangeRateInterfaces as $exchangeRateInterface) {
            $this->assertInstanceOf(ExchangeRateInterface::class, $exchangeRateInterface);
            $this->assertInternalType('float', $exchangeRateInterface->getRate());
            $this->assertEquals($expectedSourceCurrency, $exchangeRateInterface->getSourceCurrency());
            $this->assertTrue(in_array($exchangeRateInterface->getDestinationCurrency(), $expectedDestinationCurrencies), "Currency " . $exchangeRateInterface->getDestinationCurrency() . " is not in expected currencies " . join(', ', $expectedDestinationCurrencies));
        }
    }
}