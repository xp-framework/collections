<?php namespace util\collections;

use lang\{Generic, IndexOutOfBoundsException};

/**
 * Interface for lists
 */
#[Generic(['self' => 'T'])]
interface IList extends \ArrayAccess, \IteratorAggregate {

  /**
   * Returns the number of elements in this list.
   *
   * @return  int
   */
  public function size();
  
  /**
   * Tests if this list has no elements.
   *
   * @return  bool
   */
  public function isEmpty();

  /**
   * Adds an element to this list
   *
   * @param   T element
   * @return  T the added element
   */
  #[Generic(['params' => 'T', 'return' => 'T'])]
  public function add($element);

  /**
   * Replaces the element at the specified position in this list with 
   * the specified element.
   *
   * @param   int index
   * @param   T element
   * @return  T the element previously at the specified position.
   */
  #[Generic(['params' => ', T', 'return' => 'T'])]
  public function set($index, $element);

  /**
   * Returns the element at the specified position in this list.
   *
   * @param   int index
   * @return  T
   * @throws  lang.IndexOutOfBoundsException if key does not exist
   */
  #[Generic(['return' => 'T'])]
  public function get($index);
 
  /**
   * Removes the element at the specified position in this list.
   * Shifts any subsequent elements to the left (subtracts one 
   * from their indices).
   *
   * @param   int index
   * @return  T the element that was removed from the list
   */
  #[Generic(['return' => 'T'])]
  public function remove($index);

  /**
   * Checks if a value exists in this list
   *
   * @param   T element
   * @return  bool
   */
  #[Generic(['params' => 'T'])]
  public function contains($element);

  /**
   * Removes all of the elements from this list. The list will be empty 
   * after this call returns.
   *
   */
  public function clear();

}