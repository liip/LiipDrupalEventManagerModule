# Liip Drupal EventManager Module
This module is done to get rid of the Drupal hook system; at least for custom events.


## Current Travis Status

[![Build Status](https://travis-ci.org/liip/LiipDrupalEventManagerModule.png?branch=master)](https://travis-ci.org/liip/LiipDrupalEventManagerModule)

## Installation
The source is now PSR-0 compatible. There is no specific installation routine to be followed. Just clone or checkout the source into to your project
and use it.
In case you don't use a [PSR-0](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md) compatible autoloader, you only have to add the `bootstrap.php` into your bootstrap or
autoloader.

### Composer
Add the following lines to your `composer.json` file and update your project's composer installation.

```json
{
    "require": {
       "liip/liipdrupaleventmanagermodule": "dev-master"
    }
}
```

This composer configuration will checkout the 'cutting eadge' version ('dev-master') of the project. Be alarmed that this might be broken sometimes.


**NOTE:**
In case you do not know what this means the [composer project website](http://getcomposer.org) is a good place to start.


### Github
Thus I recommend the composer way to make LiipDrupalEventManagerModule a dependency to your project.
The sources are also available via github. Just clone it as you might be familiar with.

```bash
$ git clone git://github.com/liip/drupaleventmanagermodule.git
```

## Dependencies

- LiipDrupalConnector (http://github.com/liip/liipdrupalconnector)
- LiipDrupalRegistryModul (http://github.com/liip/liipdrupalregistrymodule)
- Assert (http://github.com/beberlei/assert)

##
