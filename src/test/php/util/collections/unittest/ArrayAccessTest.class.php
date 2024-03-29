<?php namespace util\collections\unittest;

use lang\{IllegalArgumentException, IndexOutOfBoundsException};
use test\Assert;
use test\{Expect, Test};
use util\collections\{HashSet, HashTable, Vector};

/**
 * TestCase
 *
 * @see   xp://util.collections.HashTable
 * @see   xp://util.collections.HashSet
 * @see   xp://util.collections.Vector
 */
class ArrayAccessTest {

  #[Test]
  public function hashTableReadElement() {
    $c= new HashTable();
    $world= new Name('world');
    $c->put(new Name('hello'), $world);
    Assert::equals($world, $c[new Name('hello')]);
  }

  #[Test]
  public function hashTableReadNonExistantElement() {
    $c= new HashTable();
    Assert::equals(null, $c[new Name('hello')]);
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function hashTableReadIllegalElement() {
    $c= create('new util.collections.HashTable<string, lang.Value>()');
    $c[STDIN];
  }

  #[Test]
  public function hashTableWriteElement() {
    $c= new HashTable();
    $world= new Name('world');
    $c[new Name('hello')]= $world;
    Assert::equals($world, $c->get(new Name('hello')));
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function hashTableWriteIllegalKey() {
    $c= create('new util.collections.HashTable<string, lang.Value>()');
    $c[STDIN]= new Name('Hello');
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function hashTableWriteIllegalValue() {
    $c= create('new util.collections.HashTable<string, lang.Value>()');
    $c['hello']= 'scalar';
  }

  #[Test]
  public function hashTableTestElement() {
    $c= new HashTable();
    $c->put(new Name('hello'), new Name('world'));
    Assert::true(isset($c[new Name('hello')]));
    Assert::false(isset($c[new Name('world')]));
  }

  #[Test]
  public function hashTableRemoveElement() {
    $c= new HashTable();
    $c->put(new Name('hello'), new Name('world'));
    Assert::true(isset($c[new Name('hello')]));
    unset($c[new Name('hello')]);
    Assert::false(isset($c[new Name('hello')]));
  }

  #[Test]
  public function vectorReadElement() {
    $v= new Vector();
    $world= new Name('world');
    $v->add($world);
    Assert::equals($world, $v[0]);
  }

  #[Test, Expect(IndexOutOfBoundsException::class)]
  public function vectorReadNonExistantElement() {
    $v= new Vector();
    $v[0];
  }

  #[Test]
  public function vectorAddElement() {
    $v= new Vector();
    $world= new Name('world');
    $v[]= $world;
    Assert::equals($world, $v[0]);
  }
  
  #[Test]
  public function vectorWriteElement() {
    $v= new Vector([new Name('hello')]);
    $world= new Name('world');
    $v[0]= $world;
    Assert::equals($world, $v[0]);
  }

  #[Test, Expect(IndexOutOfBoundsException::class)]
  public function vectorWriteElementBeyondBoundsKey() {
    $v= new Vector();
    $v[0]= new Name('world');
  }

  #[Test, Expect(IndexOutOfBoundsException::class)]
  public function vectorWriteElementNegativeKey() {
    $v= new Vector();
    $v[-1]= new Name('world');
  }

  #[Test]
  public function vectorTestElement() {
    $v= new Vector();
    $v[]= new Name('world');
    Assert::true(isset($v[0]));
    Assert::false(isset($v[1]));
    Assert::false(isset($v[-1]));
  }

  #[Test]
  public function vectorRemoveElement() {
    $v= new Vector();
    $v[]= new Name('world');
    unset($v[0]);
    Assert::false(isset($v[0]));
  }

  #[Test]
  public function vectorIsUsableInForeach() {
    $values= [new Name('hello'), new Name('world')];
    foreach (new Vector($values) as $i => $value) {
      Assert::equals($values[$i], $value);
    }
    Assert::equals(sizeof($values)- 1, $i);
  }

  #[Test]
  public function hashSetAddElement() {
    $s= new HashSet();
    $s[]= new Name('X');
    Assert::true($s->contains(new Name('X')));
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function hashSetWriteElement() {
    $s= new HashSet();
    $s[0]= new Name('X');
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function hashSetReadElement() {
    $s= new HashSet();
    $s[]= new Name('X');
    $x= $s[0];
  }

  #[Test]
  public function hashSetTestElement() {
    $s= new HashSet();
    Assert::false(isset($s[new Name('X')]));
    $s[]= new Name('X');
    Assert::true(isset($s[new Name('X')]));
  }

  #[Test]
  public function hashSetRemoveElement() {
    $s= new HashSet();
    $s[]= new Name('X');
    unset($s[new Name('X')]);
    Assert::false(isset($s[new Name('X')]));
  }

  #[Test]
  public function hashSetUsableInForeach() {
    $s= new HashSet();
    $s->addAll([new Name('0'), new Name('1'), new Name('2')]);
    foreach ($s as $i => $element) {
      Assert::equals(new Name($i), $element);
    }
  }
}