<?php namespace util\collections\unittest;

use lang\{IllegalArgumentException, Value};
use unittest\{Expect, Test};
use util\collections\{HashSet, HashTable, LRUBuffer, Queue, Stack, Vector};

/**
 * TestCase
 *
 * @see      xp://util.collections.HashTable 
 * @see      xp://util.collections.HashSet 
 * @see      xp://util.collections.Vector
 * @see      xp://util.collections.Stack
 * @see      xp://util.collections.Queue
 * @see      xp://util.collections.LRUBuffer
 */
class GenericsTest extends \unittest\TestCase {

  #[Test]
  public function differingGenericHashTablesNotEquals() {
    $this->assertNotEquals(
      create('new util.collections.HashTable<lang.Value, lang.Value>'),
      create('new util.collections.HashTable<util.collections.unittest.Name, lang.Value>')
    );
  }

  #[Test]
  public function sameGenericHashTablesAreEqual() {
    $this->assertEquals(
      create('new util.collections.HashTable<util.collections.unittest.Name, lang.Value>'),
      create('new util.collections.HashTable<util.collections.unittest.Name, lang.Value>')
    );
  }

  #[Test]
  public function differingGenericHashSetsNotEquals() {
    $this->assertNotEquals(
      create('new util.collections.HashSet<lang.Value>'),
      create('new util.collections.HashSet<util.collections.unittest.Name>')
    );
  }

  #[Test]
  public function sameGenericHashSetsAreEqual() {
    $this->assertEquals(
      create('new util.collections.HashSet<util.collections.unittest.Name>'),
      create('new util.collections.HashSet<util.collections.unittest.Name>')
    );
  }

  #[Test]
  public function differingGenericVectorsNotEquals() {
    $this->assertNotEquals(
      create('new util.collections.Vector<lang.Value>'),
      create('new util.collections.Vector<util.collections.unittest.Name>')
    );
  }

  #[Test]
  public function sameGenericVectorsAreEqual() {
    $this->assertEquals(
      create('new util.collections.Vector<util.collections.unittest.Name>'),
      create('new util.collections.Vector<util.collections.unittest.Name>')
    );
  }

  #[Test]
  public function differingGenericQueuesNotEquals() {
    $this->assertNotEquals(
      create('new util.collections.Queue<lang.Value>'),
      create('new util.collections.Queue<util.collections.unittest.Name>')
    );
  }

  #[Test]
  public function sameGenericQueuesAreEqual() {
    $this->assertEquals(
      create('new util.collections.Queue<util.collections.unittest.Name>'),
      create('new util.collections.Queue<util.collections.unittest.Name>')
    );
  }

  #[Test]
  public function differingGenericStacksNotEquals() {
    $this->assertNotEquals(
      create('new util.collections.Stack<lang.Value>'),
      create('new util.collections.Stack<util.collections.unittest.Name>')
    );
  }

  #[Test]
  public function sameGenericStacksAreEqual() {
    $this->assertEquals(
      create('new util.collections.Stack<util.collections.unittest.Name>'),
      create('new util.collections.Stack<util.collections.unittest.Name>')
    );
  }

  #[Test]
  public function differingGenericLRUBuffersNotEquals() {
    $this->assertNotEquals(
      create('new util.collections.LRUBuffer<lang.Value>', [10]),
      create('new util.collections.LRUBuffer<util.collections.unittest.Name>', [10])
    );
  }

  #[Test]
  public function sameGenericLRUBuffersAreEqual() {
    $this->assertEquals(
      create('new util.collections.LRUBuffer<util.collections.unittest.Name>', [10]),
      create('new util.collections.LRUBuffer<util.collections.unittest.Name>', [10])
    );
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function nonGenericPassedToCreate() {
    create('new lang.Value<util.collections.unittest.Name>');
  }

  #[Test]
  public function stringVector() {
    create('new util.collections.Vector<util.collections.unittest.Name>')->add(new Name('Hi'));
  }

  #[Test]
  public function createStringVector() {
    $this->assertEquals(
      new Name('one'), 
      create('new util.collections.Vector<util.collections.unittest.Name>', [new Name('one')])->get(0)
    );
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function stringVectorAddIllegalValue() {
    create('new util.collections.Vector<util.collections.unittest.Name>')->add($this);
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function stringVectorSetIllegalValue() {
    create('new util.collections.Vector<util.collections.unittest.Name>', [new Name('')])->set(0, $this);
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function stringVectorContainsIllegalValue() {
    create('new util.collections.Vector<util.collections.unittest.Name>')->contains($this);
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function createStringVectorWithIllegalValue() {
    create('new util.collections.Vector<util.collections.unittest.Name>', [$this]);
  }

  #[Test]
  public function stringStack() {
    create('new util.collections.Stack<util.collections.unittest.Name>')->push(new Name('One'));
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function stringStackPushIllegalValue() {
    create('new util.collections.Stack<util.collections.unittest.Name>')->push($this);
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function stringStackSearchIllegalValue() {
    create('new util.collections.Stack<util.collections.unittest.Name>')->search($this);
  }

  #[Test]
  public function stringQueue() {
    create('new util.collections.Queue<util.collections.unittest.Name>')->put(new Name('One'));
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function stringQueuePutIllegalValue() {
    create('new util.collections.Queue<util.collections.unittest.Name>')->put($this);
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function stringQueueSearchIllegalValue() {
    create('new util.collections.Queue<util.collections.unittest.Name>')->search($this);
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function stringQueueRemoveIllegalValue() {
    create('new util.collections.Queue<util.collections.unittest.Name>')->remove($this);
  }

  #[Test]
  public function stringLRUBuffer() {
    create('new util.collections.LRUBuffer<util.collections.unittest.Name>', 1)->add(new Name('One'));
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function stringLRUBufferAddIllegalValue() {
    create('new util.collections.LRUBuffer<util.collections.unittest.Name>', 1)->add($this);
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function stringLRUBufferUpdateIllegalValue() {
    create('new util.collections.LRUBuffer<util.collections.unittest.Name>', 1)->update($this);
  }

  #[Test]
  public function stringHashSet() {
    create('new util.collections.HashSet<util.collections.unittest.Name>')->add(new Name('One'));
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function stringHashSetAddIllegalValue() {
    create('new util.collections.HashSet<util.collections.unittest.Name>')->add($this);
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function stringHashSetContainsIllegalValue() {
    create('new util.collections.HashSet<util.collections.unittest.Name>')->contains($this);
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function stringHashSetRemoveIllegalValue() {
    create('new util.collections.HashSet<util.collections.unittest.Name>')->remove($this);
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function stringHashSetAddAllIllegalValue() {
    create('new util.collections.HashSet<util.collections.unittest.Name>')->addAll([
      new Name('HELLO'),    // Still OK
      $this                 // Blam
    ]);
  }

  #[Test]
  public function stringHashSetUnchangedAferAddAllIllegalValue() {
    $h= create('new util.collections.HashSet<util.collections.unittest.Name>');
    try {
      $h->addAll([new Name('HELLO'), $this]);
    } catch (IllegalArgumentException $expected) {
    }
    $this->assertTrue($h->isEmpty());
  }

  #[Test]
  public function arrayAsKeyLookupWithMatchingKey() {
    with ($h= create('new util.collections.HashTable<string[], util.collections.unittest.Name>')); {
      $h->put(['hello'], new Name('World'));
      $this->assertEquals(new Name('World'), $h->get(['hello']));
    }
  }

  #[Test]
  public function arrayAsKeyLookupWithMismatchingKey() {
    with ($h= create('new util.collections.HashTable<string[], util.collections.unittest.Name>')); {
      $h->put(['hello'], new Name('World'));
      $this->assertNull($h->get(['world']));
    }
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function arrayAsKeyArrayComponentTypeMismatch() {
    create('new util.collections.HashTable<string[], util.collections.unittest.Name>')->put([1], new Name('World'));
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function arrayAsKeyTypeMismatch() {
    create('new util.collections.HashTable<string[], util.collections.unittest.Name>')->put('hello', new Name('World'));
  }

  /**
   * Tests HashTable with float keys
   *
   * @see   issue://31
   */
  #[Test]
  public function floatKeyHashTable() {
    $c= create('new util.collections.HashTable<float, string>');
    $c[0.1]= '1/10';
    $c[0.2]= '2/10';
    $this->assertEquals('1/10', $c[0.1], '0.1');
    $this->assertEquals('2/10', $c[0.2], '0.2');
  }

  /**
   * Tests HashSet with floats
   *
   * @see   issue://31
   */
  #[Test]
  public function floatInHashSet() {
    $c= create('new util.collections.HashSet<float>');
    $c->add(0.1);
    $c->add(0.2);
    $this->assertEquals([0.1, 0.2], $c->toArray());
  }

  /**
   * Tests LRUBuffer with floats
   *
   * @see   issue://31
   */
  #[Test]
  public function floatInLRUBuffer() {
    $c= create('new util.collections.LRUBuffer<float>', $irrelevant= 10);
    $c->add(0.1);
    $c->add(0.2);
    $this->assertEquals(2, $c->numElements());
  }

  /**
   * Tests HashTable::toString() in conjunction with primitives
   *
   * @see   issue://32
   */
  #[Test]
  public function primitiveInHashTableToString() {
    $c= create('new util.collections.HashTable<string, string>');
    $c->put('hello', 'World');
    $this->assertNotEquals('', $c->toString());
  }

  /**
   * Tests HashSet::toString() in conjunction with primitives
   *
   * @see   issue://32
   */
  #[Test]
  public function primitiveInHashSetToString() {
    $c= create('new util.collections.HashSet<string>');
    $c->add('hello');
    $this->assertNotEquals('', $c->toString());
  }

  /**
   * Tests Vector::toString() in conjunction with primitives
   *
   * @see   issue://32
   */
  #[Test]
  public function primitiveInVectorToString() {
    $c= create('new util.collections.Vector<string>');
    $c->add('hello');
    $this->assertNotEquals('', $c->toString());
  }
}