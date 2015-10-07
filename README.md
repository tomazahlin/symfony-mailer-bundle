# Symfony2 Mailer Bundle

[![Build Status](https://travis-ci.org/tomazahlin/symfony-mailer-bundle.svg?branch=master)](https://travis-ci.org/tomazahlin/symfony-mailer-bundle)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/4fe70994-cedd-49aa-a03f-2a018574d90f/big.png)](https://insight.sensiolabs.com/projects/4fe70994-cedd-49aa-a03f-2a018574d90f)

This is the explanation of how the bundle is structured and also an installation / example tutorial for the bundle.

Mailer bundle allows you to write very clean code when sending emails. By default it uses Swiftmailer, but if you want, you can
override the complete mailer implementation and use some other mailer library. Emails can be forwarded (send) to Swiftmailer directly
in the code where you require it, and also if you implement a queueable mailer, sending of the mails can be postponed until Symfony's
kernel.terminate event, which is handled after the output is already sent to the user, so the user does not notice the delay of the mailing.

The code is coupled to the Symfony2 framework, as it is presented in the bundle. It might be decoupled later if needed or requested.

## Installation

### Use composer to require the bundle inside composer.json by running the command:

``` bash
php composer.phar require tomazahlin/symfony-mailer-bundle
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
bin/phpspec run
```
    
## Usage

[View a controller with examples here](https://github.com/tomazahlin/symfony-mailer-bundle/blob/master/src/Ahlin/Bundle/MailerBundle/Controller/ExampleController.php)

The bundle provides you with the mailing service which gives you access to other services as well, because it uses composition.
It exposes one service, so you only have to inject one dependency, preferably the MailingInterface, to keep things decoupled.

``` php
namespace Company\App;

use Ahlin\Mailer\MailingInterface;

class MyService
{
    private $mailing;
        
    public function __construct(MailingInterface $mailing)
    {
        $this->mailing = $mailing;
    }

    public function doSomething()
    {
        // How to access factory to create mail instances
        $factory = $this->mailing->getFactory();
        
        // How to access mailer to send or queue the mail
        $mailer = $this->mailing->getMailer();
    }
}
```

To define your service, you should inject the ahlin_mailer.mailing service:

``` xml
<service id="my_bundle.my_service" class="Company\App\MyService">
    <argument type="service" id="ahlin_mailer.mailing" />
</service>
```

## Templates

To override anything in the bundle, you can of course use bundle inheritance, but for simplicity you can also
override some classes by overriding some of the default parameters of the bundle. And to override templates you
can define your custom templates in app/Resources.

The bundle is packaged with a default responsive html template:

    - Resources/views/Mail/default.html.twig

You can easily replace the template, by defining your own in app/Resources folder or you can use bundle inheritance
to do the same.

To define your own templates, the bundle uses Open for extension / closed for modification solid principle. To
define your own templates, you need to create a class and tag it with "ahlin_mailer.mapping". Let's say you wanted to
create a mapping for your UserBundle.

Create a class which implements TemplateMappingInterface.

``` php
namespace Company\Bundle\UserBundle\Mapping;

use Ahlin\Mailer\Mapping\TemplateMappingInterface;

class UserMapping implements TemplateMappingInterface
{
    public function getMappings()
    {
        return array(
            'registration'      => array('view' => 'CompanyUserBundle:Mail:registration.html.twig',     'contentType' => 'text/html'),
            'activation'        => array('view' => 'CompanyUserBundle:Mail:activation.html.twig',       'contentType' => 'text/html'),
            'forgot_password'   => array('view' => 'CompanyUserBundle:Mail:forgot_password.html.twig',  'contentType' => 'text/html'),
        );
    }
}
```

As you can see, it is only a mapping between aliases and their paths, so when you need to specify which template you want to use,
your code will be much shorter and cleaner. And the service definition for the container would look like this:

``` xml
<service id="my_user_bundle.user_mapping" class="Company\Bundle\UserBundle\Mapping\UserMapping" public="false">
    <tag name="ahlin_mailer.mapping" />
</service>
```

You can define (override) the parameters which are always passed to the email templates, by overriding the parameter:

``` xml
<parameter type="collection" key="ahlin_mailer.default.parameters">
    <parameter key="myHomepageUrl" type="string">https://localhost</parameter>
</parameter>
```

In the twig template, you can access it with {{ myHomepageUrl }}.

For any questions or issues regarding this bundle, please do not hesitate to ask. Feel free to create your own forked version
or submit any pull requests.
