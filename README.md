Collections
===========

[![Build Status on TravisCI](https://secure.travis-ci.org/xp-framework/collections.svg)](http://travis-ci.org/xp-framework/collections)
[![XP Framework Module](https://raw.githubusercontent.com/xp-framework/web/master/static/xp-framework-badge.png)](https://github.com/xp-framework/core)
[![BSD Licence](https://raw.githubusercontent.com/xp-framework/web/master/static/licence-bsd.png)](https://github.com/xp-framework/core/blob/master/LICENCE.md)
[![Required PHP 5.6+](https://raw.githubusercontent.com/xp-framework/web/master/static/php-5_6plus.png)](http://php.net/)
[![Supports PHP 7.0+](https://raw.githubusercontent.com/xp-framework/web/master/static/php-7_0plus.png)](http://php.net/)
[![Latest Stable Version](https://poser.pugx.org/xp-framework/collections/version.png)](https://packagist.org/packages/xp-framework/collections)

Generic collections for the XP Framework

API
---
```php
package util.collections {
  public interface util.collections.IList<T>
  public interface util.collections.Map<K, V>
  public interface util.collections.Set<T>

  public class util.collections.HashSet<T>
  public class util.collections.HashTable<K, V>
  public class util.collections.LRUBuffer<T>
  public class util.collections.Pair<K, V>
  public class util.collections.Queue<T>
  public class util.collections.Stack<T>
  public class util.collections.Vector<T>
}
```

Example: HashTable
------------------
```php
$map= create('new util.collections.HashTable<string, com.example.Customer>');
$empty= $map->isEmpty();
$size= $map->size();

// Write values
$map['@example']= new Customer(0, 'Example customer');
$map->put('@friebe', new Customer(1, 'Timm Friebe'));

// Raises an exception
$map['@invalid']= new Date();

// Access
$customer= $map['@example'];
$customer= $map->get('@example');

// Test
if (isset($map['@example'])) {
  // ...
}

// Will return NULL
$customer= $map['@nonexistant'];

// Remove
unset($map['@example']);
$map->remove('@example');

// Iteration
foreach ($map as $pair) {
  echo $pair->key, ': ', $pair->value->toString(), "\n";
}
```

Example: Vector
---------------
```php
$list= create('new util.collections.Vector<com.example.Customer>');
$empty= $list->isEmpty();
$size= $list->size();

// Write values
$list[]= new Customer(0, 'Example customer');
$list->add(new Customer(1, 'Timm Friebe'));

$list[0]= new Customer(0, 'Example customer');
$list->set(1, new Customer(1, 'Timm Friebe'));

// Raises an exception
$list[0]= new Date();

// Access
$customer= $list[0];
$customer= $list->get(0);

// Test
if (isset($list[1])) {
  // ...
}

// Will return NULL
$customer= $list[1];

// Remove
unset($list[1]);
$list->remove(1);

// Iteration
foreach ($list as $customer) {
  echo $customer->toString(), "\n";
}
```

Further reading
---------------
* [RFC #0193: Generics optimization](https://github.com/xp-framework/rfc/issues/193)
* [RFC #0106: Array access / iteration / type boxing / generics](https://github.com/xp-framework/rfc/issues/106)
* [HHVM: Hack Language Reference: Generic](http://docs.hhvm.com/manual/en/hack.generics.php)
* [PHP RFC: Introduce generics into PHP](https://wiki.php.net/rfc/generics)