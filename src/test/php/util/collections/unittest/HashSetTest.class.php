<?php namespace util\collections\unittest;
 
use unittest\Test;
use util\collections\HashSet;

/**
 * Test HashSet class
 *
 * @see   xp://util.collections.HashSet
 */
class HashSetTest extends \unittest\TestCase {
  public $set= null;
  
  /**
   * Setup method. Creates the set member
   */
  public function setUp() {
    $this->set= new HashSet();
  }

  #[Test]
  public function initiallyEmpty() {
    $this->assertTrue($this->set->isEmpty());
  }

  #[Test]
  public function equalsClone() {
    $this->set->add(new Name('green'));
    $this->assertTrue($this->set->equals(clone($this->set)));
  }
 
  #[Test]
  public function equalsOtherSetWithSameContents() {
    $other= new HashSet();
    $this->set->add(new Name('color'));
    $other->add(new Name('color'));
    $this->assertTrue($this->set->equals($other));
  }

  #[Test]
  public function doesNotEqualSetWithDifferentContents() {
    $other= new HashSet();
    $this->set->add(new Name('blue'));
    $other->add(new Name('yellow'));
    $this->assertFalse($this->set->equals($other));
  }
 
  #[Test]
  public function add() {
    $this->set->add(new Name('green'));
    $this->assertFalse($this->set->isEmpty());
    $this->assertEquals(1, $this->set->size());
  }

  #[Test]
  public function addAll() {
    $array= [new Name('one'), new Name('two'), new Name('three')];
    $this->set->addAll($array);
    $this->assertFalse($this->set->isEmpty());
    $this->assertEquals(3, $this->set->size());
  }

  #[Test]
  public function addAllUniques() {
    $array= [new Name('one'), new Name('one'), new Name('two')];
    $this->set->addAll($array);
    $this->assertFalse($this->set->isEmpty());
    $this->assertEquals(2, $this->set->size());   // Name{"one"} and Name{"two"}
  }

  #[Test]
  public function addAllReturnsWhetherSetHasChanged() {
    $array= [new Name('caffeine'), new Name('nicotine')];
    $this->assertTrue($this->set->addAll($array));
    $this->assertFalse($this->set->addAll($array));
    $this->assertFalse($this->set->addAll([new Name('caffeine')]));
    $this->assertFalse($this->set->addAll([]));
  }

  #[Test]
  public function contains() {
    $this->set->add(new Name('key'));
    $this->assertTrue($this->set->contains(new Name('key')));
    $this->assertFalse($this->set->contains(new Name('non-existant-key')));
  }

  #[Test]
  public function addSameValueTwice() {
    $color= new Name('green');
    $this->assertTrue($this->set->add($color));
    $this->assertFalse($this->set->add($color));
  }

  #[Test]
  public function remove() {
    $this->set->add(new Name('key'));
    $this->assertTrue($this->set->remove(new Name('key')));
    $this->assertTrue($this->set->isEmpty());
  }

  #[Test]
  public function removeOnEmptySet() {
    $this->assertFalse($this->set->remove(new Name('irrelevant-set-is-empty-anyway')));
  }

  #[Test]
  public function removeNonExistantObject() {
    $this->set->add(new Name('key'));
    $this->assertFalse($this->set->remove(new Name('non-existant-key')));
  }

  #[Test]
  public function clear() {
    $this->set->add(new Name('key'));
    $this->set->clear();
    $this->assertTrue($this->set->isEmpty());
  }

  #[Test]
  public function toArray() {
    $color= new Name('red');
    $this->set->add($color);
    $this->assertEquals([$color], $this->set->toArray());
  }

  #[Test]
  public function toArrayOnEmptySet() {
    $this->assertEquals([], $this->set->toArray());
  }

  #[Test]
  public function iteration() {
    $this->set->add(new Name('1'));
    $this->set->add(new Name('2'));
    $this->set->add(new Name('3'));
    
    foreach ($this->set as $i => $value) {
      $this->assertEquals(new Name($i+ 1), $value);
    }
  }

  #[Test]
  public function stringRepresentation() {
    $this->set->add(new Name('color'));
    $this->set->add(new Name('price'));
    $this->assertEquals(
      "util.collections.HashSet[2] {\n  color,\n  price\n}",
      $this->set->toString()
    );
  }

  #[Test]
  public function stringRepresentationOfEmptySet() {
    $this->assertEquals(
      'util.collections.HashSet[0] { }',
      $this->set->toString()
    );
  }

  #[Test]
  public function addFunction() {
    $f= function() { return 'test'; };
    $this->set->add($f);
    $this->assertEquals([$f], $this->set->toArray());
  }
}