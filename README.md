#KOLAB

## Requirements
* composer
* PHP version >= 7
* MySQL

## Install
```
$ composer install
$ php bin/console doctrine:migrations:migrate
```

## Projection
Running and reseting
```
$ php bin/console projection:run *service_name* yes
$ php bin/console projection:reset *projection_name*
```