<?php
namespace PavlePredic\CurrencyConverter\Tests\Provider;

use PavlePredic\CurrencyConverter\Entity\ExchangeRate;
use PavlePredic\CurrencyConverter\Entity\ExchangeRateInterface;
use PavlePredic\CurrencyConverter\Provider\DbExchangeRatesProvider;
use PavlePredic\CurrencyConverter\Repository\ExchangeRateRepositoryInterface;

/**
 * @group unit
 */
class DbExchangeRatesProviderTest extends ExchangeRateTest
{
    public function testGetExchangeRate()
    {
        $sourceCurrency = 'EUR';
        $destinationCurrency = 'USD';
        $mockRate = 1.23;
        $exchangeRate = ExchangeRate::create($sourceCurrency, $destinationCurrency, $mockRate);

        $repository = $this->getMock(ExchangeRateRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('findOneBySourceCurrencyAndDestinationCurrency')
            ->will($this->returnValue($exchangeRate))
        ;

        $dbProvider = new DbExchangeRatesProvider($repository);
        $rate = $dbProvider->getExchangeRate($sourceCurrency, $destinationCurrency);
        $this->assertInstanceOf(ExchangeRateInterface::class, $rate);
        $this->validateExchangeRate($rate, $sourceCurrency, $destinationCurrency);
    }

    public function testGetExchangeRates()
    {
        $sourceCurrency = 'EUR';
        $destinationCurrencies = ['USD', 'GBP'];
        $mockRate = 1.23;
        $exchangeRates = [];
        foreach ($destinationCurrencies as $destinationCurrency) {
            $exchangeRates[] = ExchangeRate::create($sourceCurrency, $destinationCurrency, $mockRate);
        }
        $repository = $this->getMock(ExchangeRateRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('findAllBySourceCurrencyAndDestinationCurrencies')
            ->will($this->returnValue($exchangeRates))
        ;

        $dbProvider = new DbExchangeRatesProvider($repository);
        $rates = $dbProvider->getExchangeRates($sourceCurrency, $destinationCurrencies);
        $this->assertInternalType('array', $rates);
        $this->validateExchangeRates($rates, $sourceCurrency, $destinationCurrencies);
    }
}