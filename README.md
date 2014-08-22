Orchestra Bundle
================

Orchestra is a Naked Object implementation on top of Symfony2
Available as a Symfony2 Bundle

## Installation

Install bundle using composer:
`composer require romaricdrigon/orchestra-bundle`

Register the bundle in `app/AppKernel.php`:
```php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new RomaricDrigon\OrchestraBundle\RomaricDrigonOrchestraBundle(),
        );
```

Import our routing file:
```yaml
# app/config/routing.yml
admin:
    resource: '@RomaricDrigonOrchestraBundle/Resources/config/routing.xml'
    prefix: /admin
```

## Getting started

With Orchestra admin generator you will have to focus only on 2 objects: `Repositories` and `Aggregates`.
All those objects must be placed within a valid Symfony2 bundle.

### Repositories

We advise you to place those, by convention, in your bundle within a `Repository` folder. Those are NOT Doctrine repositories!

They must implement `RomaricDrigon\OrchestraBundle\Domain\RepositoryInterface`.
They must be declared as services, tagged with `orchestra.repository`.