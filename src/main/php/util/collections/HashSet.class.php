<?php namespace util\collections;

use lang\IllegalArgumentException;
use util\Objects;

/**
 * A set of objects
 *
 * @test  xp://net.xp_framework.unittest.util.collections.HashSetTest
 * @test  xp://net.xp_framework.unittest.util.collections.GenericsTest
 * @test  xp://net.xp_framework.unittest.util.collections.ArrayAccessTest
 */
#[@generic(['self' => 'T', 'implements' => ['T']])]
class HashSet implements Set {
  protected $_elements= [];

  /** @return iterable */
  public function getIterator() {
    foreach ($this->_elements as $element) {
      yield $element;
    }
  }

  /**
   * = list[] overloading
   *
   * @param   int offset
   * @return  lang.Generic
   */
  public function offsetGet($offset) {
    throw new IllegalArgumentException('Unsupported operation');
  }

  /**
   * list[]= overloading
   *
   * @param   int offset
   * @param   T value
   * @throws  lang.IllegalArgumentException if key is neither numeric (set) nor NULL (add)
   */
  #[@generic(['params' => ', T'])]
  public function offsetSet($offset, $value) {
     if (null === $offset) {
      $this->add($value);
    } else {
      throw new IllegalArgumentException('Unsupported operation');
    }
  }

  /**
   * isset() overloading
   *
   * @param   T offset
   * @return  bool
   */
  #[@generic(['params' => 'T'])]
  public function offsetExists($offset) {
    return $this->contains($offset);
  }

  /**
   * unset() overloading
   *
   * @param   T offset
   */
  #[@generic(['params' => 'T'])]
  public function offsetUnset($offset) {
    $this->remove($offset);
  }
  
  /**
   * Adds an object
   *
   * @param   T element
   * @return  bool TRUE if this set did not already contain the specified element. 
   */
  #[@generic(['params' => 'T'])]
  public function add($element) { 
    $h= Objects::hashOf($element);
    if (isset($this->_elements[$h])) return false;
    
    $this->_elements[$h]= $element;
    return true;
  }

  /**
   * Removes an object from this set
   *
   * @param   T element
   * @return  bool TRUE if this set contained the specified element. 
   */
  #[@generic(['params' => 'T'])]
  public function remove($element) { 
    $h= Objects::hashOf($element);
    if (!isset($this->_elements[$h])) return false;

    unset($this->_elements[$h]);
    return true;
  }

  /**
   * Removes an object from this set
   *
   * @param   T element
   * @return  bool TRUE if the set contains the specified element. 
   */
  #[@generic(['params' => 'T'])]
  public function contains($element) { 
    $h= Objects::hashOf($element);
    return isset($this->_elements[$h]);
  }

  /**
   * Returns this set's size
   *
   * @return  int
   */
  public function size() { 
    return sizeof($this->_elements);
  }

  /**
   * Removes all of the elements from this set
   *
   * @return void
   */
  public function clear() { 
    $this->_elements= [];
  }

  /**
   * Returns whether this set is empty
   *
   * @return  bool
   */
  public function isEmpty() {
    return 0 == sizeof($this->_elements);
  }
  
  /**
   * Adds an array of objects
   *
   * @param   T[] elements
   * @return  bool TRUE if this set changed as a result of the call. 
   */
  #[@generic(['params' => 'T[]'])]
  public function addAll($elements) { 
    $changed= false;
    foreach ($elements as $element) {
      $h= Objects::hashOf($element);
      if (isset($this->_elements[$h])) continue;

      $this->_elements[$h]= $element;
      $changed= true;
    }
    return $changed;
  }

  /**
   * Returns an array containing all of the elements in this set. 
   *
   * @return  T[] objects
   */
  #[@generic(['return' => 'T[]'])]
  public function toArray() { 
    return array_values($this->_elements);
  }

  /**
   * Returns a hashcode for this set
   *
   * @return  string
   */
  public function hashCode() {
    $hash= '';
    foreach ($this->_elements as $element) {
      $hash.= Objects::hashOf($element);
    }
    return md5($hash);
  }
  
  /**
   * Returns true if this set equals another set.
   *
   * @param   var cmp
   * @return  bool
   */
  public function equals($cmp) {
    return $cmp instanceof self && $this->hashCode() === $cmp->hashCode();
  }

  /**
   * Returns a string representation of this set
   *
   * @return  string
   */
  public function toString() {
    $s= nameof($this).'['.sizeof($this->_elements).'] {';
    if (empty($this->_elements)) return $s.' }';

    $s.= "\n";
    foreach ($this->_elements as $e) {
      $s.= '  '.Objects::stringOf($e).",\n";
    }
    return substr($s, 0, -2)."\n}";
  }
} 
