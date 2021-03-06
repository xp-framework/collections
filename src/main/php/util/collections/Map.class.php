<?php namespace util\collections;

use lang\Generic;

/**
 * An object that maps keys to values. A map cannot contain duplicate 
 * keys; each key can map to at most one value. 
 */
#[Generic(['self' => 'K, V'])]
interface Map extends \ArrayAccess {
  
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
  #[Generic(['params' => 'K, V', 'return' => 'V'])]
  public function put($key, $value);

  /**
   * Returns the value to which this map maps the specified key. 
   * Returns NULL if the map contains no mapping for this key.
   *
   * @param   K key
   * @return  V the value associated with the key
   */
  #[Generic(['params' => 'K', 'return' => 'V'])]
  public function get($key);
  
  /**
   * Removes the mapping for this key from this map if it is present.
   * Returns the value to which the map previously associated the key, 
   * or null if the map contained no mapping for this key.
   *
   * @param   K key
   * @return  V the previous value associated with the key
   */
  #[Generic(['params' => 'K', 'return' => 'V'])]
  public function remove($key);
  
  /**
   * Removes all mappings from this map.
   *
   */
  public function clear();

  /**
   * Returns the number of key-value mappings in this map
   *
   * @return int
   */
  public function size();

  /**
   * Returns true if this map contains no key-value mappings. 
   *
   * @return  bool
   */
  public function isEmpty();
  
  /**
   * Returns true if this map contains a mapping for the specified key.
   *
   * @param   K key
   * @return  bool
   */
  #[Generic(['params' => 'K'])]
  public function containsKey($key);

  /**
   * Returns true if this map maps one or more keys to the specified value. 
   *
   * @param   V value
   * @return  bool
   */
  #[Generic(['params' => 'V'])]
  public function containsValue($value);

  /**
   * Returns an array of keys
   *
   * @return  K[]
   */
  #[Generic(['return' => 'K[]'])]
  public function keys();

  /**
   * Returns an array of values
   *
   * @return  V[]
   */
  #[Generic(['return' => 'V[]'])]
  public function values();

  /**
   * Returns a hashcode for this map
   *
   * @return  string
   */
  public function hashCode();
  
  /**
   * Returns true if this map equals another map.
   *
   * @param   lang.Generic cmp
   * @return  bool
   */
  public function equals($cmp);
}
