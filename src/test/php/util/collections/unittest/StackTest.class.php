<?php namespace util\collections\unittest;

use lang\IndexOutOfBoundsException;
use test\{Assert, Expect, Test};
use util\collections\Stack;

class StackTest {

  #[Test]
  public function initiallyEmpty() {
    Assert::true((new Stack())->isEmpty());
  }

  #[Test]
  public function equalsClone() {
    $stack= new Stack();
    $stack->push(new Name('green'));
    Assert::true($stack->equals(clone($stack)));
  }

  #[Test]
  public function push() {
    $stack= new Stack();
    $stack->push(new Name('green'));
    Assert::false($stack->isEmpty());
    Assert::equals(1, $stack->size());
  }

  #[Test]
  public function pop() {
    $stack= new Stack();
    $color= new Name('green');
    $stack->push($color);
    Assert::equals($color, $stack->pop());
    Assert::true($stack->isEmpty());
  }

  #[Test]
  public function peek() {
    $stack= new Stack();
    $color= new Name('green');
    $stack->push($color);
    Assert::equals($color, $stack->peek());
    Assert::false($stack->isEmpty());
  }

  #[Test]
  public function search() {
    $stack= new Stack();
    $color= new Name('green');
    $stack->push($color);
    Assert::equals(0, $stack->search($color));
    Assert::equals(-1, $stack->search(new Name('non-existant')));
  }

  #[Test]
  public function elementAt() {
    $stack= new Stack();
    $stack->push(new Name('red'));
    $stack->push(new Name('green'));
    $stack->push(new Name('blue'));

    Assert::equals(new Name('blue'), $stack->elementAt(0));
    Assert::equals(new Name('green'), $stack->elementAt(1));
    Assert::equals(new Name('red'), $stack->elementAt(2));
  }

  #[Test, Expect(IndexOutOfBoundsException::class)]
  public function elementAtIllegalOffset() {
    $stack= new Stack();
    $stack->elementAt(-1);
  }

  #[Test]
  public function addFunction() {
    $stack= new Stack();
    $f= function() { return 'test'; };
    $stack->push($f);
    Assert::equals($f, $stack->elementAt(0));
  }
}