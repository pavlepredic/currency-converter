<?php
namespace PavlePredic\CurrencyConverter\Entity;

interface ExchangeRateInterface
{
    /**
     * @return string
     */
    public function getDestinationCurrency();

    /**
     * @param string $destinationCurrency
     */
    public function setDestinationCurrency($destinationCurrency);

    /**
     * @return string
     */
    public function getSourceCurrency();

    /**
     * @param string $sourceCurrency
     */
    public function setSourceCurrency($sourceCurrency);

    /**
     * @return float
     */
    public function getRate();

    /**
     * @param float $rate
     */
    public function setRate($rate);
}