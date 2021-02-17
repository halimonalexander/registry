# Registry

Registry pattern library

![main branch parameter](https://github.com/halimonalexander/registry/workflows/php/badge.svg)

## Install
```bash
$ composer require halimonalexander/registry
```

## Example of usage

```php
use HalimonAlexander\Registry\Registry;

$registry = Registry::getInstance();

$registry->set('key1', 1);
//...
if ($registry->has('key1')) {
    $var = $registry->get('key1');
}

$registry->set('db', new \PDO());
//...
/** @var \PDO|null $db */
$db = $registry->getByClassname(\PDO::class);
```