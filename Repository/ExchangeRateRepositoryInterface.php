<?php
namespace PavlePredic\CurrencyConverter\Repository;

use Doctrine\Common\Persistence\ObjectRepository;
use PavlePredic\CurrencyConverter\Entity\ExchangeRateInterface;

interface ExchangeRateRepositoryInterface extends ObjectRepository
{
    /**
     * @param string $sourceCurrency
     * @param array $destinationCurrencies
     * @return ExchangeRateInterface[]
     */
    public function findAllBySourceCurrencyAndDestinationCurrencies($sourceCurrency, array $destinationCurrencies);

    /**
     * @param string $sourceCurrency
     * @param string $destinationCurrency
     * @return ExchangeRateInterface
     */
    public function findOneBySourceCurrencyAndDestinationCurrency($sourceCurrency, $destinationCurrency);

    /**
     * @param string $sourceCurrency
     * @param string $destinationCurrency
     * @param float $rate
     * @return ExchangeRateInterface
     */
    public function update($sourceCurrency, $destinationCurrency, $rate);
}