<?php namespace util\collections\unittest;

use lang\IllegalArgumentException;
use test\{Assert, Expect, Test};
use util\Objects;
use util\collections\LRUBuffer;

class LRUBufferTest {
  const DEFAULT_SIZE= 3;

  /**
   * Add a specified number of strings to the give buffer.
   *
   * @param   util.collections.LRUBuffer $buffer
   * @param   int $num
   */
  private function addElements($buffer, $num) {
    for ($i= 0; $i < $num; $i++) {
      $buffer->add(new Name('item #'.$i));
    }
  }

  #[Test]
  public function initiallyEmpty() {
    $buffer= new LRUBuffer(self::DEFAULT_SIZE);
    Assert::equals(0, $buffer->numElements());
  }

  #[Test]
  public function getSize() {
    $buffer= new LRUBuffer(self::DEFAULT_SIZE);
    Assert::equals(self::DEFAULT_SIZE, $buffer->getSize());
  }

  #[Test]
  public function add() {
    $buffer= new LRUBuffer(self::DEFAULT_SIZE);
    $buffer->add(new Name('one'));
    Assert::equals(1, $buffer->numElements());
  }

  #[Test]
  public function addReturnsVictim() {
    $buffer= new LRUBuffer(self::DEFAULT_SIZE);

    // We should be able to add at least as many as the buffer's size
    // elements to the LRUBuffer. Nothing should be deleted from it
    // during this loop.
    for ($i= 0, $s= $buffer->getSize(); $i < $s; $i++) {
      if (null === ($victim= $buffer->add(new Name('item #'.$i)))) continue;
      
      $this->fail(
        'Victim '.Objects::stringOf($victim).' when inserting item #'.($i + 1).'/'.$s, 
        $victim, 
        null
      );
    }
    
    // The LRUBuffer is now "full". Next time we add something, the
    // element last recently used should be returned.
    Assert::equals(
      new Name('item #0'), 
      $buffer->add(new Name('last item'))
    );
  }

  #[Test]
  public function bufferDoesNotGrowBeyondSize() {
    $buffer= new LRUBuffer(self::DEFAULT_SIZE);
    $this->addElements($buffer, $buffer->getSize() + 1);
    Assert::equals($buffer->getSize(), $buffer->numElements());
  }
 
  #[Test]
  public function update() {
    $buffer= new LRUBuffer(self::DEFAULT_SIZE);
  
    // Fill the LRUBuffer until its size is reached
    $this->addElements($buffer, $buffer->getSize());
    
    // Update the first item
    $buffer->update(new Name('item #0'));
    
    // Now the second item should be chosen the victim when adding 
    // another element
    Assert::equals(
      new Name('item #1'), 
      $buffer->add(new Name('last item'))
    );
  }

  #[Test]
  public function setSize() {
    $buffer= new LRUBuffer(self::DEFAULT_SIZE);
    $buffer->setSize(10);
    Assert::equals(10, $buffer->getSize());
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function illegalSize() {
    $buffer= new LRUBuffer(self::DEFAULT_SIZE);
    $buffer->setSize(0);
  }

  #[Test]
  public function equalsClone() {
    $buffer= new LRUBuffer(self::DEFAULT_SIZE);
    Assert::true($buffer->equals(clone $buffer));
  }

  #[Test]
  public function doesNotEqualWithDifferentSize() {
    $buffer= new LRUBuffer(self::DEFAULT_SIZE);
    Assert::false($buffer->equals(new LRUBuffer(self::DEFAULT_SIZE - 1)));
  }
 
  #[Test]
  public function doesNotEqualWithSameElements() {
    $buffer= new LRUBuffer(self::DEFAULT_SIZE);
    $other= new LRUBuffer(self::DEFAULT_SIZE);
    with ($string= new Name('Hello')); {
      $other->add($string);
      $buffer->add($string);
    }
    Assert::false($buffer->equals($other));
  }

  #[Test]
  public function addFunction() {
    $buffer= new LRUBuffer(self::DEFAULT_SIZE);
    $f= function() { return 'test'; };
    $buffer->add($f);
    Assert::equals(1, $buffer->numElements());
  }
}