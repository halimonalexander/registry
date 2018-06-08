# HalimonAlexander\Registry

[![Build Status](https://travis-ci.org/halimonalexander/registry.svg?branch=master)](https://travis-ci.org/halimonalexander/registry)
[![Code Climate](https://codeclimate.com/github/halimonalexander/registry/badges/gpa.svg)](https://codeclimate.com/github/halimonalexander/registry)
[![Test Coverage](https://codeclimate.com/github/halimonalexander/registry/badges/coverage.svg)](https://codeclimate.com/github/halimonalexander/registry/coverage)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/3ca17365-c61a-4258-b0dc-340e002530ca/mini.png)](https://insight.sensiolabs.com/projects/3ca17365-c61a-4258-b0dc-340e002530ca)

Registry library

## Example of Usage

```php
$registry = new Registry()

$registry->set('key1', 1);

$var = $registry->get('key1');

if ($registry->has('key1')) {
    ...
}
```