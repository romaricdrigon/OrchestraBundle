Orchestra Bundle
================

Orchestra is a Naked Object implementation on top of Symfony2
Available as a Symfony2 Bundle

## Installation

Install bundle using composer: `composer require romaricdrigon/orchestra-bundle`

Register the bundle and the vendor we use in `app/AppKernel.php`:
```php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new RomaricDrigon\OrchestraBundle\RomaricDrigonOrchestraBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
        );
```

Import our routes (both the XML and our custom type):
```yaml
# app/config/routing.yml
orchestra_routing:
    resource: '@RomaricDrigonOrchestraBundle/Resources/config/routing.xml'
    prefix: /admin

orchestra_generated:
    prefix: /admin
    resource: .
    type: orchestra
```

## Getting started

With Orchestra admin generator you will have to focus only on 2 objects: `Entities` and `Repositories`.
All those objects must be placed within a valid Symfony2 bundle.

### Entities

`Entities` are the basic Domain objects of your application.
Even if we will see later that they are persisted, they may be differ than Doctrine entities.

#### Basic entity

By convention, place those in your bundle `Entity` folder.

They must implement `RomaricDrigon\OrchestraBundle\Domain\EntityInterface`:
```php
use RomaricDrigon\OrchestraBundle\Domain\EntityInterface;

class SomeEntity implements EntityInterface
{
```

Naked Object follow a DDD mindset.
We strike not to have an [Anemic Domain Model](http://www.martinfowler.com/bliki/AnemicDomainModel.html).
A few guidelines and advices:

 * entities properties are private or protected, *not public*,, in compliance with encapsulation
 * entities must have public getters for the properties you will want to expose, for example in the views
 * they expose methods corresponding to actions on the objects, leading to modification of its internal state, but **not public setters**
 * you may want to add *private* setters, in order to achieve self-encapsulation, it's up to you

#### Persisting

Usually, they are persisted. Orchestra supports Doctrine ORM through its Symfony2 bridge.
You will have to do their mapping, using Doctrine annotations, YAML or XML as you want.
For this part, please refer to [Symfony documentation](http://symfony.com/doc/2.4/book/doctrine.html).

### Repositories

Those are NOT Doctrine repositories!
We stick to the original Repository pattern (Fowler, 2002), "a collection-like interface for accessing domain objects".

Their name will be the name of the `Entity` suffixed by `Repository` but you're free to do otherwise.

**Each `Repository` must have a corresponding `Entity`, with the same slug (lowercase name without suffix):
 for a `FooBar` entity, you must have a `FoobarRepository`, or `FooBarRepository` or `FooBar` (though this last is less readable).**

#### Basic repository

We advise you to place those, by convention, in your bundle within a `Repository` folder.

They must implement `RomaricDrigon\OrchestraBundle\Domain\RepositoryInterface`:
```php
use RomaricDrigon\OrchestraBundle\Domain\RepositoryInterface;
use RomaricDrigon\OrchestraBundle\Annotation\Name;

class MyRepository implements RepositoryInterface
{
```

They must be declared as services, tagged with `orchestra.repository`:
```xml
<!-- your bundle services.xml -->
<?xml version="1.0" ?>
<container xmlns="http://symfony.com/schema/dic/services"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd">

    <services>
        <service id="romaric_drigon_example.my_repository" class="My\Repository\Class\Path">
            <tag name="orchestra.repository" />
        </service>
        ...
```

#### Fetching Doctrine repository

An Orchestra Repository is a Symfony2 service, so you can inject it dependencies.

Orchestra can automatically resolve and inject to your service the corresponding Doctrine repository.
To benefit from this, just implement `RomaricDrigon\OrchestraBundle\Domain\Doctrine\DoctrineAwareInterface`.

For simplicity, you can extends the provided `BaseRepository` class.
You will then have access to the corresponding Doctrine repository, and we provide a generic `listing` method.

```php
use RomaricDrigon\OrchestraBundle\Domain\Doctrine\BaseRepository;
use RomaricDrigon\OrchestraBundle\Annotation\Name;

class MyRepository implements BaseRepository
{
    public function someMethod()
    {
        $doctrineRepository = $this->doctrineRepository;

        ...
```

#### Customize displayed name

The name displayed for the Repository can be automatically generated, from the class name, or optionally personalized using the `@Name` annotation.

Example:
```php
use RomaricDrigon\OrchestraBundle\Domain\RepositoryInterface;
use RomaricDrigon\OrchestraBundle\Annotation\Name;

/**
 * @Name("CustomName")
 */
class MyRepository implements RepositoryInterface
{
```

## Configuration

You can configure the Bundle by putting those settings in your `config.yml`:
```yaml
# app/config/config.yml
romaric_drigon_orchestra:
    app_title: Orchestra # default. Will be used as title (prefix) for pages
```

## Misc

IE8 is not supported by provided templates. Twitter Bootstrap is missing its JS polyfills, and we are using jQuery 2.0

## Thanks

Twitter Bootstrap integration have been realized using templates from [Braincrafted Bootstrap bundle](https://github.com/braincrafted/bootstrap-bundle)
