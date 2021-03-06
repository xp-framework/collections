<?php namespace util\collections;

use lang\IndexOutOfBoundsException;
use util\{Generic, NoSuchElementException, Objects};

/**
 * A Last-In-First-Out (LIFO) stack of objects.
 *
 * Example:
 * <code>
 * use util\collections\Stack;
 * 
 * // Fill stack
 * with ($s= new Stack()); {
 *   $s->push(new String('One'));
 *   $s->push(new String('Two'));
 *   $s->push(new String('Three'));
 *   $s->push(new String('Four'));
 * }
 * 
 * // Empty stack
 * while (!$s->isEmpty()) {
 *   var_dump($s->pop());
 * }
 * ```
 *
 * @see      xp://util.collections.Queue
 * @test     xp://net.xp_framework.unittest.util.collections.GenericsTest
 * @test     xp://net.xp_framework.unittest.util.collections.StackTest
 * @see      http://www.faqs.org/docs/javap/c12/ex-12-1-answer.html
 * @see      http://java.sun.com/j2se/1.4.2/docs/api/java/util/Stack.html 
 */
#[Generic(['self' => 'T'])]
class Stack implements \lang\Value {
  protected $_elements= [];

  /**
   * Pushes an item onto the top of the stack. Returns the element that 
   * was added.
   *
   * @param   T element
   * @return  T
   */
  #[Generic(['params' => 'T', 'return' => 'T'])]
  public function push($element) {
    array_unshift($this->_elements, $element);
    return $element;
  }

  /**
   * Gets an item from the top of the stack
   *
   * @return  T
   * @throws  util.NoSuchElementException
   */    
  #[Generic(['return' => 'T'])]
  public function pop() {
    if (empty($this->_elements)) {
      throw new NoSuchElementException('Stack is empty');
    }
    $element= array_shift($this->_elements);
    return $element;
  }

  /**
   * Peeks at the front of the stack (retrieves the first element 
   * without removing it).
   *
   * Returns NULL in case the stack is empty.
   *
   * @return  T element
   */        
  #[Generic(['return' => 'T'])]
  public function peek() {
    return empty($this->_elements) ? null : $this->_elements[0];
  }

  /**
   * Returns true if the stack is empty. This is effectively the same
   * as testing size() for 0.
   *
   * @return  bool
   */
  public function isEmpty() {
    return empty($this->_elements);
  }

  /**
   * Returns the size of the stack.
   *
   * @return  int
   */
  public function size() {
    return sizeof($this->_elements);
  }
  
  /**
   * Sees if an object is in the stack and returns its position.
   * Returns -1 if the object is not found.
   *
   * @param   T object
   * @return  int position
   */
  #[Generic(['params' => 'T'])]
  public function search($element) {
    return ($keys= array_keys($this->_elements, $element)) ? $keys[0] : -1;
  }
  
  /**
   * Retrieves an element by its index.
   *
   * @param   int index
   * @return  T
   * @throws  lang.IndexOutOfBoundsException
   */
  #[Generic(['return' => 'T'])]
  public function elementAt($index) {
    if (!isset($this->_elements[$index])) {
      throw new IndexOutOfBoundsException('Index '.$index.' out of bounds');
    }
    return $this->_elements[$index];
  }

  /**
   * Returns a string representation of this stack
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
   * Returns a hashcode for this stack
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