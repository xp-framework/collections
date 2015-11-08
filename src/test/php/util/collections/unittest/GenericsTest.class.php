<?php namespace util\collections\unittest;

use util\collections\HashTable;
use util\collections\HashSet;
use util\collections\Vector;
use util\collections\Stack;
use util\collections\Queue;
use util\collections\LRUBuffer;
use lang\types\Integer;
use lang\types\String;
use lang\IllegalArgumentException;

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

  #[@test]
  public function differingGenericHashTablesNotEquals() {
    $this->assertNotEquals(
      create('new util.collections.HashTable<lang.Object, lang.Object>'),
      create('new util.collections.HashTable<lang.types.String, lang.Object>')
    );
  }

  #[@test]
  public function sameGenericHashTablesAreEqual() {
    $this->assertEquals(
      create('new util.collections.HashTable<lang.types.String, lang.Object>'),
      create('new util.collections.HashTable<lang.types.String, lang.Object>')
    );
  }

  #[@test]
  public function differingGenericHashSetsNotEquals() {
    $this->assertNotEquals(
      create('new util.collections.HashSet<lang.Object>'),
      create('new util.collections.HashSet<lang.types.String>')
    );
  }

  #[@test]
  public function sameGenericHashSetsAreEqual() {
    $this->assertEquals(
      create('new util.collections.HashSet<lang.types.String>'),
      create('new util.collections.HashSet<lang.types.String>')
    );
  }

  #[@test]
  public function differingGenericVectorsNotEquals() {
    $this->assertNotEquals(
      create('new util.collections.Vector<lang.Object>'),
      create('new util.collections.Vector<lang.types.String>')
    );
  }

  #[@test]
  public function sameGenericVectorsAreEqual() {
    $this->assertEquals(
      create('new util.collections.Vector<lang.types.String>'),
      create('new util.collections.Vector<lang.types.String>')
    );
  }

  #[@test]
  public function differingGenericQueuesNotEquals() {
    $this->assertNotEquals(
      create('new util.collections.Queue<lang.Object>'),
      create('new util.collections.Queue<lang.types.String>')
    );
  }

  #[@test]
  public function sameGenericQueuesAreEqual() {
    $this->assertEquals(
      create('new util.collections.Queue<lang.types.String>'),
      create('new util.collections.Queue<lang.types.String>')
    );
  }

  #[@test]
  public function differingGenericStacksNotEquals() {
    $this->assertNotEquals(
      create('new util.collections.Stack<lang.Object>'),
      create('new util.collections.Stack<lang.types.String>')
    );
  }

  #[@test]
  public function sameGenericStacksAreEqual() {
    $this->assertEquals(
      create('new util.collections.Stack<lang.types.String>'),
      create('new util.collections.Stack<lang.types.String>')
    );
  }

  #[@test]
  public function differingGenericLRUBuffersNotEquals() {
    $this->assertNotEquals(
      create('new util.collections.LRUBuffer<lang.Object>', [10]),
      create('new util.collections.LRUBuffer<lang.types.String>', [10])
    );
  }

  #[@test]
  public function sameGenericLRUBuffersAreEqual() {
    $this->assertEquals(
      create('new util.collections.LRUBuffer<lang.types.String>', [10]),
      create('new util.collections.LRUBuffer<lang.types.String>', [10])
    );
  }

  #[@test, @expect(IllegalArgumentException::class)]
  public function nonGenericPassedToCreate() {
    create('new lang.Object<lang.types.String>');
  }

  #[@test]
  public function stringVector() {
    create('new util.collections.Vector<lang.types.String>')->add(new \lang\types\String('Hi'));
  }

  #[@test]
  public function createStringVector() {
    $this->assertEquals(
      new \lang\types\String('one'), 
      create('new util.collections.Vector<lang.types.String>', [new \lang\types\String('one')])->get(0)
    );
  }

  #[@test, @expect(IllegalArgumentException::class)]
  public function stringVectorAddIllegalValue() {
    create('new util.collections.Vector<lang.types.String>')->add(new \lang\types\Integer(1));
  }

  #[@test, @expect(IllegalArgumentException::class)]
  public function stringVectorSetIllegalValue() {
    create('new util.collections.Vector<lang.types.String>', [new \lang\types\String('')])->set(0, new \lang\types\Integer(1));
  }

  #[@test, @expect(IllegalArgumentException::class)]
  public function stringVectorContainsIllegalValue() {
    create('new util.collections.Vector<lang.types.String>')->contains(new \lang\types\Integer(1));
  }

  #[@test, @expect(IllegalArgumentException::class)]
  public function createStringVectorWithIllegalValue() {
    create('new util.collections.Vector<lang.types.String>', [new \lang\types\Integer(1)]);
  }

  #[@test]
  public function stringStack() {
    create('new util.collections.Stack<lang.types.String>')->push(new \lang\types\String('One'));
  }

  #[@test, @expect(IllegalArgumentException::class)]
  public function stringStackPushIllegalValue() {
    create('new util.collections.Stack<lang.types.String>')->push(new \lang\types\Integer(1));
  }

  #[@test, @expect(IllegalArgumentException::class)]
  public function stringStackSearchIllegalValue() {
    create('new util.collections.Stack<lang.types.String>')->search(new \lang\types\Integer(1));
  }

  #[@test]
  public function stringQueue() {
    create('new util.collections.Queue<lang.types.String>')->put(new \lang\types\String('One'));
  }

  #[@test, @expect(IllegalArgumentException::class)]
  public function stringQueuePutIllegalValue() {
    create('new util.collections.Queue<lang.types.String>')->put(new \lang\types\Integer(1));
  }

  #[@test, @expect(IllegalArgumentException::class)]
  public function stringQueueSearchIllegalValue() {
    create('new util.collections.Queue<lang.types.String>')->search(new \lang\types\Integer(1));
  }

  #[@test, @expect(IllegalArgumentException::class)]
  public function stringQueueRemoveIllegalValue() {
    create('new util.collections.Queue<lang.types.String>')->remove(new \lang\types\Integer(1));
  }

  #[@test]
  public function stringLRUBuffer() {
    create('new util.collections.LRUBuffer<lang.types.String>', 1)->add(new \lang\types\String('One'));
  }

  #[@test, @expect(IllegalArgumentException::class)]
  public function stringLRUBufferAddIllegalValue() {
    create('new util.collections.LRUBuffer<lang.types.String>', 1)->add(new \lang\types\Integer(1));
  }

  #[@test, @expect(IllegalArgumentException::class)]
  public function stringLRUBufferUpdateIllegalValue() {
    create('new util.collections.LRUBuffer<lang.types.String>', 1)->update(new \lang\types\Integer(1));
  }

  #[@test]
  public function stringHashSet() {
    create('new util.collections.HashSet<lang.types.String>')->add(new \lang\types\String('One'));
  }

  #[@test, @expect(IllegalArgumentException::class)]
  public function stringHashSetAddIllegalValue() {
    create('new util.collections.HashSet<lang.types.String>')->add(new \lang\types\Integer(1));
  }

  #[@test, @expect(IllegalArgumentException::class)]
  public function stringHashSetContainsIllegalValue() {
    create('new util.collections.HashSet<lang.types.String>')->contains(new \lang\types\Integer(1));
  }

  #[@test, @expect(IllegalArgumentException::class)]
  public function stringHashSetRemoveIllegalValue() {
    create('new util.collections.HashSet<lang.types.String>')->remove(new \lang\types\Integer(1));
  }

  #[@test, @expect(IllegalArgumentException::class)]
  public function stringHashSetAddAllIllegalValue() {
    create('new util.collections.HashSet<lang.types.String>')->addAll([
      new \lang\types\String('HELLO'),    // Still OK
      new \lang\types\Integer(2),         // Blam
    ]);
  }

  #[@test]
  public function stringHashSetUnchangedAferAddAllIllegalValue() {
    $h= create('new util.collections.HashSet<lang.types.String>');
    try {
      $h->addAll([new \lang\types\String('HELLO'), new \lang\types\Integer(2)]);
    } catch (\lang\IllegalArgumentException $expected) {
    }
    $this->assertTrue($h->isEmpty());
  }

  #[@test]
  public function arrayAsKeyLookupWithMatchingKey() {
    with ($h= create('new util.collections.HashTable<string[], lang.types.String>')); {
      $h->put(['hello'], new \lang\types\String('World'));
      $this->assertEquals(new \lang\types\String('World'), $h->get(['hello']));
    }
  }

  #[@test]
  public function arrayAsKeyLookupWithMismatchingKey() {
    with ($h= create('new util.collections.HashTable<string[], lang.types.String>')); {
      $h->put(['hello'], new \lang\types\String('World'));
      $this->assertNull($h->get(['world']));
    }
  }

  #[@test, @expect(IllegalArgumentException::class)]
  public function arrayAsKeyArrayComponentTypeMismatch() {
    create('new util.collections.HashTable<string[], lang.types.String>')->put([1], new \lang\types\String('World'));
  }

  #[@test, @expect(IllegalArgumentException::class)]
  public function arrayAsKeyTypeMismatch() {
    create('new util.collections.HashTable<string[], lang.types.String>')->put('hello', new \lang\types\String('World'));
  }

  /**
   * Tests HashTable with float keys
   *
   * @see   issue://31
   */
  #[@test]
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
  #[@test]
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
  #[@test]
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
  #[@test]
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
  #[@test]
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
  #[@test]
  public function primitiveInVectorToString() {
    $c= create('new util.collections.Vector<string>');
    $c->add('hello');
    $this->assertNotEquals('', $c->toString());
  }
}
