# Slick Hero Banner for Silverstripe

## Installation

`composer require jinjie/slickhero`

Add extension to the page where you want to have the hero banners

```yaml
Page:
  extensions:
    - SwiftDevLabs\SlickHero\Extensions\SlickHeroBannerExtension
```

or

```php
class MyObject extends Page {
    private static $extensions = [
        SwiftDevLabs\SlickHero\Extensions\SlickHeroBannerExtension::class,
    ];
}
```

## SilverStripe Elemental

If you are using Elemental, you can use the [elemental version](https://github.com/jinjie/slickhero-elemental) instead.

## Slick Options

Slick have many options. So I did not implement all the options. I welome you to implement them!

For now, you can set the options by overriding `getSlickOptions()`. Do make sure to `json_encode`!

See available options at https://kenwheeler.github.io/slick/

```php
public function getSlickOptions()
{
    return json_encode([
        'dots' => true,
    ]);
}
```
