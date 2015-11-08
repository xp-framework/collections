<?php namespace util\collections\unittest;

class Name extends \lang\Object {
  private $value;

  /** @param string $value */
  public function __construct($value) { $this->value= (string)$value; }

  /** @return string */
  public function value() { return $this->value; }

  /**
   * Returns a hashcode
   *
   * @return string
   */
  public function hashCode() {
    return crc32($this->value);
  }

  /**
   * Returns whether this name is equal to another
   *
   * @param  var $cmp
   * @return bool
   */
  public function equals($cmp) {
    return $cmp instanceof self && $this->value === $cmp->value;
  }

  /**
   * Returns a string representation
   *
   * @return string
   */
  public function toString() {
    return $this->value;
  }
}