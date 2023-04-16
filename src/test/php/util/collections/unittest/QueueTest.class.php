<?php namespace util\collections\unittest;

use lang\IndexOutOfBoundsException;
use test\{Assert, Expect, Test};
use util\collections\Queue;
use util\{NoSuchElementException, Objects};

class QueueTest {
      
  #[Test]
  public function initiallyEmpty() {
    Assert::true((new Queue())->isEmpty());
  }

  #[Test]
  public function equalsClone() {
    $queue= new Queue();
    $queue->put(new Name('green'));
    Assert::true($queue->equals(clone($queue)));
  }

  #[Test]
  public function put() {
    $queue= new Queue();
    $queue->put(new Name('green'));
    Assert::false($queue->isEmpty());
    Assert::equals(1, $queue->size());
  }

  #[Test]
  public function get() {
    $queue= new Queue();
    $color= new Name('red');
    $queue->put($color);
    Assert::equals($color, $queue->get());
    Assert::true($queue->isEmpty());
  }

  #[Test, Expect(NoSuchElementException::class)]
  public function exceptionOnNoMoreElements() {
    (new Queue())->get();
  }

  #[Test]
  public function peek() {
    $queue= new Queue();
    $color= new Name('blue');
    $queue->put($color);
    Assert::equals($color, $queue->peek());
    Assert::false($queue->isEmpty());
  }

  #[Test]
  public function peekReturnsNullOnNoMoreElements() {
    Assert::null((new Queue())->peek());
  }

  #[Test]
  public function remove() {
    $queue= new Queue();
    $color= new Name('blue');
    $queue->put($color);
    $queue->remove($color);
    Assert::true($queue->isEmpty());
  }

  #[Test]
  public function removeReturnsWhetherDeleted() {
    $queue= new Queue();
    $color= new Name('pink');
    $queue->put($color);
    Assert::true($queue->remove($color));
    Assert::false($queue->remove(new Name('purple')));
    Assert::true($queue->isEmpty());
    Assert::false($queue->remove($color));
    Assert::false($queue->remove(new Name('purple')));
  }

  #[Test]
  public function elementAt() {
    $queue= new Queue();
    $queue->put(new Name('red'));
    $queue->put(new Name('green'));
    $queue->put(new Name('blue'));
    Assert::equals(new Name('red'), $queue->elementAt(0));
    Assert::equals(new Name('green'), $queue->elementAt(1));
    Assert::equals(new Name('blue'), $queue->elementAt(2));
  }

  #[Test]
  public function iterativeUse() {
    $queue= new Queue();
    $input= [new Name('red'), new Name('green'), new Name('blue')];
    
    // Add
    for ($i= 0, $s= sizeof($input); $i < sizeof($input); $i++) {
      $queue->put($input[$i]);
    }
    
    // Retrieve
    $i= 0;
    while (!$queue->isEmpty()) {
      $element= $queue->get();

      if (!Objects::equal($input[$i], $element)) {
        $this->fail('Not equal at offset #'.$i, $element, $input[$i]);
        break;
      }
      $i++;
    }
  }

  #[Test, Expect(IndexOutOfBoundsException::class)]
  public function elementAtIllegalOffset() {
    (new Queue())->elementAt(-1);
  }

  #[Test, Expect(IndexOutOfBoundsException::class)]
  public function elementAtOffsetOutOfBounds() {
    $queue= new Queue();
    $queue->put(new Name('one'));
    $queue->elementAt($queue->size() + 1);
  }

  #[Test, Expect(IndexOutOfBoundsException::class)]
  public function elementAtEmptyList() {
    (new Queue())->elementAt(0);
  }

  #[Test]
  public function addFunction() {
    $queue= new Queue();
    $f= function() { return 'test'; };
    $queue->put($f);
    Assert::equals($f, $queue->elementAt(0));
  }
}