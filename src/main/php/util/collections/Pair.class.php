<?php namespace util\collections;

use lang\{Generic, Value};
use util\Objects;

/**
 * Provides key and value for iteration
 *
 * @see  xp://util.collections.HashTable
 * @test xp://net.xp_framework.unittest.util.collections.PairTest
 */
#[Generic(['self' => 'K, V'])]
class Pair implements Value {
  #[Type('K')]
  public $key;
  #[Type('V')]
  public $value;

  /**
   * Constructor
   *
   * @param  K key
   * @param  V value
   */
  #[Generic(['params' => 'K, V'])]
  public function __construct($key, $value) {
    $this->key= $key;
    $this->value= $value;
  }

  /**
   * Returns whether a given value is equal to this pair
   *
   * @param  var $value
   * @return int
   */
  public function compareTo($value) {
    return $value instanceof self ? Objects::compare($this->key, $value->key) : 1;
  }

  /**
   * Returns a hashcode for this pair
   *
   * @return string
   */
  public function hashCode() {
    return md5(Objects::hashOf($this->key).Objects::hashOf($this->value));
  }

  /**
   * Get string representation
   *
   * @return  string
   */
  public function toString() {
    return nameof($this).'<key= '.Objects::stringOf($this->key).', value= '.Objects::stringOf($this->value).'>';
  }
}