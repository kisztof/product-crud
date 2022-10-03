# Product CRUD
Product CRUD app using Laravel framework

## Requirements
- [PHP 8.1](https://www.php.net/releases/8.1/en.php)
- [Laravel9]()

## Installation
```shell
git clone git@github.com:kisztof/product-crud.git

composer install -a --no-dev

php artisan migrate

php artisan serve
```

## Example data
If you would like to use example data, simply run command below
```shell
php artisan db:seed
```

## Tests

```shell
composer install 

./vendor/bin/phpunit
```
or use simply composer script
```shell
composer tests
```

## Contribution

Make sure your PR meets requirements below

```shell
composer phpstan
composer rector
composer ecs
composer tests
```

## PHPSTAN
PHPStan runs on MAX settings on app catalogue.
```shell
composer phpstan
```
## Rector
Configured to support 
up to PHP8.1 and laravel up to 9 on:
- app
- database
- routes
- tests
```shell
composer rector
```
## ECS
Configured to follow PSR-12 on:
- app
- database
- tests

with additional rules:
- SetList::STRICT,
- SetList::CLEAN_CODE,
- SetList::CONTROL_STRUCTURES,
- SetList::SPACES,

To check if you code is following standards run:
```shell
composer ecs
```

In other side if you want to fix it:
```shell
composer ecs-fix
```
