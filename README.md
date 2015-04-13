# Symfony2 Mailer Bundle

This is the explanation of how the bundle is structured and also an installation / example tutorial for the bundle.

Mailer bundle allows you to write very clean code when sending emails. By default it uses Swiftmailer, but if you want, you can
override the complete mailer implementation and use some other mailer library. Emails can be forwarded (send) to Swiftmailer directly
in the code where you require it, and also if you implement a queueable mailer, sending of the mails can be postponed until Symfony's
kernel.terminate event, which is handled after the output is already sent to the user, so the user does not notice the delay of the mailing.

## Installation

### Add the bundle to your composer.json:

``` js
{
    "require": {
        "tomazahlin/symfony-mailer-bundle": "~1.0"
    }
}
```

### Use composer to download the bundle by running the command:

``` bash
php composer.phar update tomazahlin/symfony-mailer-bundle
```

### Enable the bundle in your AppKernel.php

``` php
public function registerBundles()
{
    $bundles = array(
        // ...
        new Ahlin\Bundle\MailerBundle\AhlinMailerBundle(),
    );
}
```

## Run tests

``` bash
bin/phpunit
bin/behat
```
    
## Examples

