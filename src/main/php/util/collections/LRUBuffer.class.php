<?php namespace util\collections;

use lang\{Generic, IllegalArgumentException};
use util\Objects;

/**
 * LRU (last recently used) buffer.
 *
 * The last recently used (that is, the longest time unchanged) 
 * element will be deleted when calling add().
 *
 * @test  xp://net.xp_framework.unittest.util.collections.LRUBufferTest
 * @test  xp://net.xp_framework.unittest.util.collections.GenericsTest
 */
#[Generic(['self' => 'T'])]
class LRUBuffer implements \lang\Value {
  protected
    $prefix    = 0,
    $size      = 0,
    $_elements = [];

  /**
   * Constructor
   *
   * @param   int size
   * @throws  lang.IllegalArgumentException is size is not greater than zero
   */
  public function __construct($size) {
    static $u;

    $this->prefix= ++$u;
    $this->setSize($size);
  }
  
  /**
   * Add an element to the buffer and return the id of the element 
   * which has been deleted in exchange. Returns NULL for the case 
   * that no element has been deleted (which is the case when the 
   * buffer's size has not yet been exceeded).
   *
   * <code>
   *   $deleted= $buf->add($key);
   * </code>
   *
   * @param   T element
   * @return  T victim
   */
  #[Generic(['params' => 'T', 'return' => 'T'])]
  public function add($element) {
    $h= $this->prefix.Objects::hashOf($element);
    $this->_elements[$h]= $element;

    // Check if this buffer's size has been exceeded
    if (sizeof($this->_elements) <= $this->size) return null;
    
    // Delete the element first added
    $p= key($this->_elements);
    $victim= $this->_elements[$p];
    unset($this->_elements[$p]);

    return $victim;
  }
  
  /**
   * Update an element
   *
   * @param   T element
   */
  #[Generic(['params' => 'T'])]
  public function update($element) {
    $h= $this->prefix.Objects::hashOf($element);
    unset($this->_elements[$h]);
    $this->_elements= $this->_elements + [$h => $element];
  }
  
  /**
   * Get number of elements currently contained in this buffer
   *
   * @return  int
   */
  public function numElements() {
    return sizeof($this->_elements);
  }
  
  /**
   * Set size
   *
   * @param   int size
   * @throws  lang.IllegalArgumentException is size is not greater than zero
   */
  public function setSize($size) {
    if ($size <= 0) throw new IllegalArgumentException(
      'Size must be greater than zero, '.$size.' given'
    );

    $this->size= $size;
  }

  /**
   * Get size
   *
   * @return  int
   */
  public function getSize() {
    return $this->size;
  }

  /**
   * Returns a string representation of this buffer
   *
   * @return  string
   */
  public function toString() {
    $s= nameof($this).'['.sizeof($this->_elements).'/'.$this->size.'] {';
    if (empty($this->_elements)) return $s.' }';

    $s.= "\n";
    foreach ($this->_elements as $e) {
      $s.= '  '.Objects::stringOf($e).",\n";
    }
    return substr($s, 0, -2)."\n}";
  }

  /** Creates a hash code for this object */
  public function hashCode() {
    return 'L'.$this->prefix.$this->size.Objects::hashOf($this->_elements);
  }

  /**
   * Compares a specified object to this object.
   *
   * @param   var $value
   * @return  int
   */
  public function compareTo($value) {
    return $value instanceof self
      ? Objects::compare([$this->size, $this->_elements], [$value->size, $value->_elements])
      : 1
    ;
  }

  /**
   * Returns true if this map equals another map.
   *
   * @param   var $value
   * @return  bool
   */
  public function equals($value) {
    return 
      $value instanceof self &&
      $this->size === $value->size &&
      Objects::equal($this->_elements, $value->_elements)
    ;
  }
}