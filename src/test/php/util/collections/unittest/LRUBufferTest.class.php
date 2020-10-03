<?php namespace util\collections\unittest;

use lang\IllegalArgumentException;
use unittest\{Expect, Test, TestCase};
use util\Objects;
use util\collections\LRUBuffer;

class LRUBufferTest extends TestCase {
  const DEFAULT_SIZE = 3;

  protected $buffer= null;
  
  /**
   * Setup method. Creates the buffer member
   *
   * @return void
   */
  public function setUp() {
    $this->buffer= new LRUBuffer(self::DEFAULT_SIZE);
  }

  #[Test]
  public function initiallyEmpty() {
    $this->assertEquals(0, $this->buffer->numElements());
  }

  #[Test]
  public function getSize() {
    $this->assertEquals(self::DEFAULT_SIZE, $this->buffer->getSize());
  }

  #[Test]
  public function add() {
    $this->buffer->add(new Name('one'));
    $this->assertEquals(1, $this->buffer->numElements());
  }

  #[Test]
  public function addReturnsVictim() {

    // We should be able to add at least as many as the buffer's size
    // elements to the LRUBuffer. Nothing should be deleted from it
    // during this loop.
    for ($i= 0, $s= $this->buffer->getSize(); $i < $s; $i++) {
      if (null === ($victim= $this->buffer->add(new Name('item #'.$i)))) continue;
      
      $this->fail(
        'Victim '.Objects::stringOf($victim).' when inserting item #'.($i + 1).'/'.$s, 
        $victim, 
        null
      );
    }
    
    // The LRUBuffer is now "full". Next time we add something, the
    // element last recently used should be returned.
    $this->assertEquals(
      new Name('item #0'), 
      $this->buffer->add(new Name('last item'))
    );
  }
  
  /**
   * Add a specified number of strings to the buffer.
   *
   * @param   int num
   */
  protected function addElements($num) {
    for ($i= 0; $i < $num; $i++) {
      $this->buffer->add(new Name('item #'.$i));
    }
  }
  
  #[Test]
  public function bufferDoesNotGrowBeyondSize() {
    $this->addElements($this->buffer->getSize()+ 1);
    $this->assertEquals($this->buffer->getSize(), $this->buffer->numElements());
  }
 
  #[Test]
  public function update() {
  
    // Fill the LRUBuffer until its size is reached
    $this->addElements($this->buffer->getSize());
    
    // Update the first item
    $this->buffer->update(new Name('item #0'));
    
    // Now the second item should be chosen the victim when adding 
    // another element
    $this->assertEquals(
      new Name('item #1'), 
      $this->buffer->add(new Name('last item'))
    );
  }

  #[Test]
  public function setSize() {
    $this->buffer->setSize(10);
    $this->assertEquals(10, $this->buffer->getSize());
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function illegalSize() {
    $this->buffer->setSize(0);
  }

  #[Test]
  public function equalsClone() {
    $this->assertTrue($this->buffer->equals(clone $this->buffer));
  }

  #[Test]
  public function doesNotEqualWithDifferentSize() {
    $this->assertFalse($this->buffer->equals(new LRUBuffer(self::DEFAULT_SIZE - 1)));
  }
 
  #[Test]
  public function doesNotEqualWithSameElements() {
    $other= new LRUBuffer(self::DEFAULT_SIZE);
    with ($string= new Name('Hello')); {
      $other->add($string);
      $this->buffer->add($string);
    }
    $this->assertFalse($this->buffer->equals($other));
  }

  #[Test]
  public function addFunction() {
    $f= function() { return 'test'; };
    $this->buffer->add($f);
    $this->assertEquals(1, $this->buffer->numElements());
  }
}