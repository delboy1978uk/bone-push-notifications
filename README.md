# pushtoken
PushToken package for Bone Mvc Framework
## installation
Use Composer
```
composer require delboy1978uk/bone-notifications
```
## usage
Simply add to the `config/packages.php`
```php
<?php

// use statements here
use Bone\Notification\PushToken\PushTokenPackage;

return [
    'packages' => [
        // packages here...,
        PushTokenPackage::class,
    ],
    // ...
];
```