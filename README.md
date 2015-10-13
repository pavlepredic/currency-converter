# Currency converter
Tools for performing currency conversion. This library might be used with Symfony2 framework, but this is not a requirement. You can use the basic exchange rate conversion utility with vanilla PHP. In order to use the storage layer, you will need Doctrine. This library is a work in progress. 

# Installing
```
composer require pavlepredic/currency-converter
```

# Basic usage example
```
use PavlePredic\CurrencyConverter\Service\CurrencyConverter;

$converter = new CurrencyConverter();
$converted = $converter->convert(100, 'USD', 'EUR');
```

# Storing exchange rates to DB using Doctrine
- Create an ORM Entity that implements PavlePredic\CurrencyConverter\Entity\ExchangeRateInterface

- Implement PavlePredic\CurrencyConverter\Repository\ExchangeRateRepositoryInterface. The repository might look something like this:
```
<?php
namespace AppBundle\Repository;

use AppBundle\Entity\ExchangeRate;
use Doctrine\ORM\EntityRepository;
use PavlePredic\CurrencyConverter\Entity\ExchangeRateInterface;
use PavlePredic\CurrencyConverter\Repository\ExchangeRateRepositoryInterface;

class ExchangeRateRepository extends EntityRepository implements ExchangeRateRepositoryInterface
{
    /**
     * @param string $sourceCurrency
     * @param array $destinationCurrencies
     * @return ExchangeRateInterface[]
     */
    public function findAllBySourceCurrencyAndDestinationCurrencies($sourceCurrency, array $destinationCurrencies)
    {
        return $this->findBy([
            'sourceCurrency' => $sourceCurrency,
            'destinationCurrency' => $destinationCurrencies,
        ]);
    }

    /**
     * @param string $sourceCurrency
     * @param string $destinationCurrency
     * @return ExchangeRateInterface
     */
    public function findOneBySourceCurrencyAndDestinationCurrency($sourceCurrency, $destinationCurrency)
    {
        return $this->findOneBy([
            'sourceCurrency' => $sourceCurrency,
            'destinationCurrency' => $destinationCurrency,
        ]);
    }

    /**
     * @param string $sourceCurrency
     * @param string $destinationCurrency
     * @param float $rate
     * @return ExchangeRateInterface
     */
    public function update($sourceCurrency, $destinationCurrency, $rate)
    {
        $exchangeRate = $this->findOneBySourceCurrencyAndDestinationCurrency($sourceCurrency, $destinationCurrency);
        if (!$exchangeRate) {
            $exchangeRate = ExchangeRate::create($sourceCurrency, $destinationCurrency, $rate);
            $this->getEntityManager()->persist($exchangeRate);
        }

        $exchangeRate->setRate($rate);

        return $exchangeRate;
    }

}
```

- Update the exchange rates using CurrencyUpdater service:
```
//the following might be executed in a symfony command, but is not restricted to symfony in any way
//you only need to use Doctrine EntityManager and EntityRepository
$em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
$repo = $em->getRepository('AppBundle:ExchangeRate');
$supportedCurrencies = ['USD','EUR','GBP'];

$updater = new CurrencyUpdater($repo, new FixerExchangeRatesProvider(), $supportedCurrencies);
$updater->update();

$em->flush();
```

- Now you can use the CurrencyConverter service using DbExchangeRatesProvider
```
use PavlePredic\CurrencyConverter\Provider\DbExchangeRatesProvider;
use PavlePredic\CurrencyConverter\Service\CurrencyConverter;

$em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
$repo = $em->getRepository('AppBundle:ExchangeRate');
$provider = new DbExchangeRatesProvider($repo);
$converter = new CurrencyConverter($provider);
$converted = $converter->convert(100, 'USD', 'EUR');
```
