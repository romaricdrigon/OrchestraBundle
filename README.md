Orchestra Bundle
================

Orchestra is a Naked Object implementation on top of Symfony2
Available as a Symfony2 Bundle

## Installation

Install bundle using composer:
`composer require romaricdrigon/orchestra-bundle`

Import our routing file:
```yaml
# app/config/routing.yml
admin:
    resource: '@OrchestraBundle/Resources/config/routing.xml'
    prefix: /admin
```