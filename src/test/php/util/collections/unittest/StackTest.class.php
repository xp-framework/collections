<?php namespace util\collections\unittest;
 
use lang\IndexOutOfBoundsException;
use unittest\{Expect, Test};
use util\collections\Stack;

class StackTest extends \unittest\TestCase {
  private $stack;
  
  /**
   * Setup method. Creates the Stack member
   *
   * @return void
   */
  public function setUp() {
    $this->stack= new Stack();
  }

  #[Test]
  public function initiallyEmpty() {
    $this->assertTrue($this->stack->isEmpty());
  }

  #[Test]
  public function equalsClone() {
    $this->stack->push(new Name('green'));
    $this->assertTrue($this->stack->equals(clone($this->stack)));
  }

  #[Test]
  public function push() {
    $this->stack->push(new Name('green'));
    $this->assertFalse($this->stack->isEmpty());
    $this->assertEquals(1, $this->stack->size());
  }

  #[Test]
  public function pop() {
    $color= new Name('green');
    $this->stack->push($color);
    $this->assertEquals($color, $this->stack->pop());
    $this->assertTrue($this->stack->isEmpty());
  }

  #[Test]
  public function peek() {
    $color= new Name('green');
    $this->stack->push($color);
    $this->assertEquals($color, $this->stack->peek());
    $this->assertFalse($this->stack->isEmpty());
  }

  #[Test]
  public function search() {
    $color= new Name('green');
    $this->stack->push($color);
    $this->assertEquals(0, $this->stack->search($color));
    $this->assertEquals(-1, $this->stack->search(new Name('non-existant')));
  }

  #[Test]
  public function elementAt() {
    $this->stack->push(new Name('red'));
    $this->stack->push(new Name('green'));
    $this->stack->push(new Name('blue'));

    $this->assertEquals(new Name('blue'), $this->stack->elementAt(0));
    $this->assertEquals(new Name('green'), $this->stack->elementAt(1));
    $this->assertEquals(new Name('red'), $this->stack->elementAt(2));
  }

  #[Test, Expect(IndexOutOfBoundsException::class)]
  public function elementAtIllegalOffset() {
    $this->stack->elementAt(-1);
  }

  #[Test]
  public function addFunction() {
    $f= function() { return 'test'; };
    $this->stack->push($f);
    $this->assertEquals($f, $this->stack->elementAt(0));
  }
}