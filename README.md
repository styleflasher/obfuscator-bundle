# Styleflasher Obfuscation Bundle

## Installation

``` bash
composer require styleflasher/obfuscation-bundle
```

## Configure

### Enable the Bundle

``` yml
// config/bundles.php
return [
    // ...
    Styleflasher\ObfuscatorBundle\StyleflasherObfuscatorBundle::class => ['all' => true],
];
```

### Add the Rot13-JS

``` html
<script src="/bundles/styleflasherobfuscator/js/EmailObfuscator.js"></script>
```

### Override content_fields (optional)

This will call `obfuscateEmail` on following types:

* `ezrichtext_field`
* `ezemail_field`

``` yml
// ezplatform.yaml
ezplatform:
   system:
        default:
            field_templates:
                - { template: '@StyleflasherObfuscator/fields/content_fields.html.twig', priority: 10 }
```

## Usage

Now you can use it anywhere in your twig like

``` twig
{{ 'test@test.test' | obfuscateEmail }}
```
