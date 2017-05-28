<?php namespace util\collections;

use util\Objects;
use lang\IndexOutOfBoundsException;
use util\NoSuchElementException;

/**
 * A First-In-First-Out (FIFO) queue of objects.
 *
 * Example:
 * ```php
 * use util\collections\Queue;
 *   
 * // Fill queue
 * with ($q= new Queue()); {
 *   $q->put(new String('One'));
 *   $q->put(new String('Two'));
 *   $q->put(new String('Three'));
 *   $q->put(new String('Four'));
 * }
 * 
 * // Empty queue
 * while (!$q->isEmpty()) {
 *   var_dump($q->get());
 * }
 * ```
 *
 * @test     xp://net.xp_framework.unittest.util.collections.GenericsTest
 * @test     xp://net.xp_framework.unittest.util.collections.QueueTest
 * @see      xp://util.collections.Stack
 * @see      http://www.faqs.org/docs/javap/c12/ex-12-1-answer.html
 */
#[@generic(self= 'T')]
class Queue implements \lang\Value {
  protected $_elements= [];

  /**
   * Puts an item into the queue. Returns the element that was added.
   *
   * @param   T element
   * @return  T element
   */
  #[@generic(params= 'T', return= 'T')]
  public function put($element) {
    $this->_elements[]= $element;
    return $element;
  }

  /**
   * Gets an item from the front of the queue.
   *
   * @return  lang.Generic
   * @throws  util.NoSuchElementException
   */    
  #[@generic(return= 'T')]
  public function get() {
    if (empty($this->_elements)) {
      throw new NoSuchElementException('Queue is empty');
    }

    $element= $this->_elements[0];
    $this->_elements= array_slice($this->_elements, 1);
    return $element;
  }
  
  /**
   * Peeks at the front of the queue (retrieves the first element 
   * without removing it).
   *
   * Returns NULL in case the queue is empty.
   *
   * @return  T element
   */        
  #[@generic(return= 'T')]
  public function peek() {
    if (empty($this->_elements)) return null; else return $this->_elements[0];
  }

  /**
   * Returns true if the queue is empty. This is effectively the same
   * as testing size() for 0.
   *
   * @return  bool
   */
  public function isEmpty() {
    return empty($this->_elements);
  }

  /**
   * Returns the size of the queue.
   *
   * @return  int
   */
  public function size() {
    return sizeof($this->_elements);
  }
  
  /**
   * Sees if an object is in the queue and returns its position.
   * Returns -1 if the object is not found.
   *
   * @param   T element
   * @return  int position
   */
  #[@generic(params= 'T')]
  public function search($element) {
    return ($keys= array_keys($this->_elements, $element)) ? $keys[0] : -1;
  }

  /**
   * Remove an object from the queue. Returns TRUE in case the element
   * was deleted, FALSE otherwise.
   *
   * @return  lang.Generic
   * @return  bool
   */
  #[@generic(params= 'T')]
  public function remove($element) {
    if (-1 === ($pos= $this->search($element))) return false;

    unset($this->_elements[$pos]);
    $this->_elements= array_values($this->_elements);   // Re-index
    return true;
  }
  
  /**
   * Retrieves an element by its index.
   *
   * @param   int index
   * @return  T
   * @throws  lang.IndexOutOfBoundsException
   */
  #[@generic(return= 'T')]
  public function elementAt($index) {
    if (!isset($this->_elements[$index])) {
      throw new IndexOutOfBoundsException('Index '.$index.' out of bounds');
    }
    return $this->_elements[$index];
  }

  /**
   * Returns a string representation of this queue
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

  /**
   * Returns a hashcode for this queue
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
   * Compares a specified object to this object.
   *
   * @param   var $value
   * @return  int
   */
  public function compareTo($value) {
    return $value instanceof self ? Objects::compare($this->_elements, $value->_elements) : 1;
  }

  /**
   * Returns true if this map equals another value.
   *
   * @param   var $value
   * @return  bool
   */
  public function equals($value) {
    return $value instanceof self && Objects::equal($this->_elements, $value->_elements);
  }
}
