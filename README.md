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
<script>
    function rot13(str) {
        var input     = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        var output    = 'NOPQRSTUVWXYZABCDEFGHIJKLMnopqrstuvwxyzabcdefghijklm';
        var index     = x => input.indexOf(x);
        var translate = x => index(x) > -1 ? output[index(x)] : x;
        return str.split('').map(translate).join('');
    }
    document.getElementsByClassName("email-obfuscation").item(0).innerHTML = rot13(document.getElementsByClassName("email-obfuscation").item(0).innerHTML);
</script>
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
