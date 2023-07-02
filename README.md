# bone-push-notifications
Push Notifications using Expo for Bone Native apps
## installation
Use Composer
```
composer require delboy1978uk/bone-push-notifications
```
## configuration
Enable the package in `config/packages.php`, and generate and run migrations.
```php
<?php

// use statements here
use Bone\Notification\PushToken\PushNotificationPackage;

return [
    'packages' => [
        // packages here...,
        PushNotificationPackage::class,
    ],
    // ...
];
```
## usage
In a Bone Native app, call the API endpoints.
