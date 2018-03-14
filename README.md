# Module Settings

db stored settings

## Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```bash
$ php composer.phar require --prefer-dist plusser/yii2-settings "*"
```

or add

```
"plusser/yii2-settings": "*"
```

to the require section of your `composer.json` file.

## Settings

```php
$modules = [
		...,
		'settings' => [
				'class' => 'settings\Module',
		],
];

```