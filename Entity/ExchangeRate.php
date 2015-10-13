<?php
namespace PavlePredic\CurrencyConverter\Entity;

class ExchangeRate implements ExchangeRateInterface
{
    /**
     * @var string
     */
    protected $sourceCurrency;

    /**
     * @var string
     */
    protected $destinationCurrency;

    /**
     * @var float
     */
    protected $rate;

    public static function create($sourceCurrency, $destinationCurrency, $rate)
    {
        $exchangeRate = new static;
        $exchangeRate->sourceCurrency = $sourceCurrency;
        $exchangeRate->destinationCurrency = $destinationCurrency;
        $exchangeRate->rate = $rate;
        return $exchangeRate;
    }


    /**
     * @return string
     */
    public function getDestinationCurrency()
    {
        return $this->destinationCurrency;
    }

    /**
     * @param string $destinationCurrency
     */
    public function setDestinationCurrency($destinationCurrency)
    {
        $this->destinationCurrency = $destinationCurrency;
    }

    /**
     * @return float
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * @param float $rate
     */
    public function setRate($rate)
    {
        $this->rate = $rate;
    }

    /**
     * @return string
     */
    public function getSourceCurrency()
    {
        return $this->sourceCurrency;
    }

    /**
     * @param string $sourceCurrency
     */
    public function setSourceCurrency($sourceCurrency)
    {
        $this->sourceCurrency = $sourceCurrency;
    }
}