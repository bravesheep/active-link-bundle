# BravesheepActiveLinkBundle
This bundle provides a few Twig helper functions and filters for checking
whether or not a specific part of your controller structure is active.

Note that some limitations apply, specifically this bundle does not
work well with subrequests. Instead the bundle always requests the master
request.

## Installation
Using [Composer][composer] add the bundle to your requirements:

```json
{
    "require": {
        "bravesheep/active-link-bundle": "dev-master"
    }
}
```

Then run `composer update bravesheep/active-link-bundle`. Finally add the bundle in
`app/AppKernel.php`:

```php
public function registerBundles()
{
    return array(
        // ...
        new Bravesheep\ActiveLinkBundle\BravesheepActiveLinkBundle(),
        // ...
    );
}
```


## Available twig functions
* `active(location[, params])`
* `active_route(route[, params])`
* `active_bundle(bundle[, params])`
* `active_controller(controller[, params])`
* `active_action(action[, params])`

## Available twig filters
* `location is active([params])`
* `route is active_route([params])`
* `bundle is active_bundle([params])`
* `controller is active_controller([params])`
* `action is active_action([params])`

[composer]: https://getcomposer.org/
