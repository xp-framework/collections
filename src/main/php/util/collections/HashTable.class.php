<?php namespace util\collections;

use lang\{Generic, Value};
use util\Objects;

/**
 * Hash table consisting of non-null objects as keys and values
 *
 * @test  xp://net.xp_framework.unittest.util.collections.HashTableTest
 * @test  xp://net.xp_framework.unittest.util.collections.GenericsTest
 * @test  xp://net.xp_framework.unittest.util.collections.ArrayAccessTest
 * @test  xp://net.xp_framework.unittest.util.collections.BoxingTest
 * @see   xp://util.collections.Map
 */
#[@generic(['self' => 'K, V', 'implements' => ['K, V']])]
class HashTable implements Map, \lang\Value, \IteratorAggregate {
  protected $_buckets= [];

  /** @return iterable */
  public function getIterator() {
    foreach ($this->_buckets as $bucket) {
      yield new Pair($bucket[0], $bucket[1]);
    }
  }
  
  /**
   * = list[] overloading
   *
   * @param   K offset
   * @return  V
   */
  #[@generic(['params' => 'K', 'return' => 'V'])]
  public function offsetGet($offset) {
    return $this->get($offset);
  }

  /**
   * list[]= overloading
   *
   * @param   K offset
   * @param   V value
   */
  #[@generic(['params' => 'K, V'])]
  public function offsetSet($offset, $value) {
    $this->put($offset, $value);
  }

  /**
   * isset() overloading
   *
   * @param   K offset
   * @return  bool
   */
  #[@generic(['params' => 'K'])]
  public function offsetExists($offset) {
    return $this->containsKey($offset);
  }

  /**
   * unset() overloading
   *
   * @param   K offset
   */
  #[@generic(['params' => 'K'])]
  public function offsetUnset($offset) {
    $this->remove($offset);
  }

  /**
   * Associates the specified value with the specified key in this map.
   * If the map previously contained a mapping for this key, the old 
   * value is replaced by the specified value.
   * Returns previous value associated with specified key, or NULL if 
   * there was no mapping for the specified key.
   *
   * @param   K key
   * @param   V value
   * @return  V the previous value associated with the key
   */
  #[@generic(['params' => 'K, V', 'return' => 'V'])]
  public function put($key, $value) {
    $h= Objects::hashOf($key);
    if (!isset($this->_buckets[$h])) {
      $previous= null;
    } else {
      $previous= $this->_buckets[$h][1];
    }

    $this->_buckets[$h]= [$key, $value];
    return $previous;
  }

  /**
   * Returns the value to which this map maps the specified key. 
   * Returns NULL if the map contains no mapping for this key.
   *
   * @param   K key
   * @return  V the value associated with the key
   */
  #[@generic(['params' => 'K', 'return' => 'V'])]
  public function get($key) {
    $h= Objects::hashOf($key);
    return isset($this->_buckets[$h]) ? $this->_buckets[$h][1] : null; 
  }
  
  /**
   * Removes the mapping for this key from this map if it is present.
   * Returns the value to which the map previously associated the key, 
   * or null if the map contained no mapping for this key.
   *
   * @param   K key
   * @return  V the previous value associated with the key
   */
  #[@generic(['params' => 'K', 'return' => 'V'])]
  public function remove($key) {
    $h= Objects::hashOf($key);
    if (!isset($this->_buckets[$h])) {
      $prev= null;
    } else {
      $prev= $this->_buckets[$h][1];
      unset($this->_buckets[$h]);
    }

    return $prev;
  }
  
  /**
   * Removes all mappings from this map.
   *
   * @return void
   */
  public function clear() {
    $this->_buckets= [];
  }

  /**
   * Returns the number of key-value mappings in this map
   *
   * @return int
   */
  public function size() {
    return sizeof($this->_buckets);
  }

  /**
   * Returns true if this map contains no key-value mappings. 
   *
   * @return  bool
   */
  public function isEmpty() {
    return empty($this->_buckets);
  }
  
  /**
   * Returns true if this map contains a mapping for the specified key.
   *
   * @param   K key
   * @return  bool
   */
  #[@generic(['params' => 'K'])]
  public function containsKey($key) {
    $h= Objects::hashOf($key);
    return isset($this->_buckets[$h]);
  }

  /**
   * Returns true if this map maps one or more keys to the specified value. 
   *
   * @param   V value
   * @return  bool
   */
  #[@generic(['params' => 'V'])]
  public function containsValue($value) {
    if ($value instanceof Generic) {
      foreach (array_keys($this->_buckets) as $key) {
        if ($value->equals($this->_buckets[$key][1])) return true;
      }
    } else if ($value instanceof Value) {
      foreach (array_keys($this->_buckets) as $key) {
        if (0 === $value->compareTo($this->_buckets[$key][1])) return true;
      }
    } else {
      foreach (array_keys($this->_buckets) as $key) {
        if ($value === $this->_buckets[$key][1]) return true;
      }
    }
    return false;
  }
  
  /**
   * Returns an array of keys
   *
   * @return  K[]
   */
  #[@generic(['return' => 'K[]'])]
  public function keys() {
    $keys= [];
    foreach ($this->_buckets as $key => $value) {
      $keys[]= $value[0];
    }
    return $keys;
  }

  /**
   * Returns an array of values
   *
   * @return  V[]
   */
  #[@generic(['return' => 'V[]'])]
  public function values() {
    $values= [];
    foreach ($this->_buckets as $key => $value) {
      $values[]= $value[1];
    }
    return $values;
  }

  /**
   * Returns a string representation of this map
   *
   * @return  string
   */
  public function toString() {
    $s= nameof($this).'['.sizeof($this->_buckets).'] {';
    if (empty($this->_buckets)) return $s.' }';

    $s.= "\n";
    foreach ($this->_buckets as $b) {
      $s.= '  '.Objects::stringOf($b[0]).' => '.Objects::stringOf($b[1]).",\n";
    }
    return substr($s, 0, -2)."\n}";
  }

  /** Creates a hash code for this object */
  public function hashCode() {
    $hash= '';
    foreach ($this->_buckets as $key => $value) {
      $hash.= $key.Objects::hashOf($value[1]);
    }
    return md5($hash);
  }

  /**
   * Compares a specified object to this object.
   *
   * @param   var $value
   * @return  int
   */
  public function compareTo($value) {
    return $value instanceof self ? Objects::compare($this->_buckets, $value->_buckets) : 1;
  }

  /**
   * Returns true if this map equals another map.
   *
   * @param   var $value
   * @return  bool
   */
  public function equals($value) {
    return $value instanceof self && Objects::equal($this->_buckets, $value->_buckets);
  }
}