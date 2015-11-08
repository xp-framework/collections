Collections
===========

[![Build Status on TravisCI](https://secure.travis-ci.org/xp-framework/collections.svg)](http://travis-ci.org/xp-framework/collections)
[![XP Framework Module](https://raw.githubusercontent.com/xp-framework/web/master/static/xp-framework-badge.png)](https://github.com/xp-framework/core)
[![BSD Licence](https://raw.githubusercontent.com/xp-framework/web/master/static/licence-bsd.png)](https://github.com/xp-framework/core/blob/master/LICENCE.md)
[![Required PHP 5.5+](https://raw.githubusercontent.com/xp-framework/web/master/static/php-5_5plus.png)](http://php.net/)
[![Supports PHP 7.0+](https://raw.githubusercontent.com/xp-framework/web/master/static/php-7_0plus.png)](http://php.net/)
[![Supports HHVM 3.4+](https://raw.githubusercontent.com/xp-framework/web/master/static/hhvm-3_4plus.png)](http://hhvm.com/)
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

// Write values
$map['@example']= new Customer(0, 'Example customer');
$map['@friebe']= new Customer(1, 'Timm Friebe');

// Raises an exception
$map['@invalid']= new Date();

// Access
$customer= $map['@example'];

// Will return NULL
$customer= $map['@nonexistant'];

// Iteration
foreach ($customer as $pair) {
  echo $pair->key, ': ', $pair->value->toString(), "\n";
}
```