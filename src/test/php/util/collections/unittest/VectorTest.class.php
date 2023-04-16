<?php namespace util\collections\unittest;

use lang\{IllegalArgumentException, IndexOutOfBoundsException, Value};
use test\Assert;
use test\{Expect, Test};
use util\collections\Vector;

/**
 * TestCase for vector class
 *
 * @see  xp://util.collections.Vector
 */
class VectorTest {

  #[Test]
  public function initiallyEmpty() {
    Assert::true((new Vector())->isEmpty());
  }

  #[Test]
  public function sizeOfEmptyVector() {
    Assert::equals(0, (new Vector())->size());
  }
  
  #[Test]
  public function nonEmptyVector() {
    $v= new Vector([new Name('Test')]);
    Assert::equals(1, $v->size());
    Assert::false($v->isEmpty());
  }

  #[Test]
  public function adding() {
    $v= new Vector();
    $v->add(new Name('Test'));
    Assert::equals(1, $v->size());
  }

  #[Test]
  public function addAllArray() {
    $v= new Vector();
    Assert::true($v->addAll([new Name('Test'), new Name('Test')]));
    Assert::equals(2, $v->size());
  }

  #[Test]
  public function addAllVector() {
    $v1= new Vector();
    $v2= new Vector();
    $v2->add(new Name('Test'));
    $v2->add(new Name('Test'));
    Assert::true($v1->addAll($v2));
    Assert::equals(2, $v1->size());
  }

  #[Test]
  public function addAllArrayObject() {
    $v= new Vector();
    Assert::true($v->addAll(new \ArrayObject([new Name('Test'), new Name('Test')])));
    Assert::equals(2, $v->size());
  }

  #[Test]
  public function addAllEmptyArray() {
    Assert::false((new Vector())->addAll([]));
  }

  #[Test]
  public function addAllEmptyVector() {
    Assert::false((new Vector())->addAll(new Vector()));
  }

  #[Test]
  public function addAllEmptyArrayObject() {
    Assert::false((new Vector())->addAll(new \ArrayObject([])));
  }

  #[Test]
  public function unchangedAfterNullInAddAll() {
    $v= create('new util.collections.Vector<lang.Value>()');
    try {
      $v->addAll([new Name('Test'), null]);
      $this->fail('addAll() did not throw an exception', null, 'lang.IllegalArgumentException');
    } catch (IllegalArgumentException $expected) {
    }
    Assert::true($v->isEmpty());
  }

  #[Test]
  public function unchangedAfterIntInAddAll() {
    $v= create('new util.collections.Vector<string>()');
    try {
      $v->addAll(['hello', 5]);
      $this->fail('addAll() did not throw an exception', null, 'lang.IllegalArgumentException');
    } catch (IllegalArgumentException $expected) {
    }
    Assert::true($v->isEmpty());
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function addingNull() {
    create('new util.collections.Vector<lang.Value>()')->add(null);
  }

  #[Test]
  public function replacing() {
    $v= new Vector();
    $o= new Name('one');
    $v->add($o);
    $r= $v->set(0, new Name('two'));
    Assert::equals(1, $v->size());
    Assert::equals($o, $r);
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function replacingWithNull() {
    create('new util.collections.Vector<lang.Value>', [new Name('Test')])->set(0, null);
  }

  #[Test, Expect(IndexOutOfBoundsException::class)]
  public function settingPastEnd() {
    (new Vector())->set(0, new Name('Test'));
  }

  #[Test, Expect(IndexOutOfBoundsException::class)]
  public function settingNegative() {
    (new Vector())->set(-1, new Name('Test'));
  }

  #[Test]
  public function reading() {
    $v= new Vector();
    $o= new Name('one');
    $v->add($o);
    $r= $v->get(0);
    Assert::equals($o, $r);
  }

  #[Test, Expect(IndexOutOfBoundsException::class)]
  public function readingPastEnd() {
    (new Vector())->get(0);
  }

  #[Test, Expect(IndexOutOfBoundsException::class)]
  public function readingNegative() {
    (new Vector())->get(-1);
  }

  #[Test]
  public function removing() {
    $v= new Vector();
    $o= new Name('one');
    $v->add($o);
    $r= $v->remove(0);
    Assert::equals(0, $v->size());
    Assert::equals($o, $r);
  }

  #[Test, Expect(IndexOutOfBoundsException::class)]
  public function removingPastEnd() {
    (new Vector())->get(0);
  }

  #[Test, Expect(IndexOutOfBoundsException::class)]
  public function removingNegative() {
    (new Vector())->get(-1);
  }

  #[Test]
  public function clearing() {
    $v= new Vector([new Name('Goodbye cruel world')]);
    Assert::false($v->isEmpty());
    $v->clear();
    Assert::true($v->isEmpty());
  }

  #[Test]
  public function elementsOfEmptyVector() {
    Assert::equals([], (new Vector())->elements());
  }

  #[Test]
  public function elementsOf() {
    $el= [new Name('a'), new Name('Test')];
    Assert::equals($el, (new Vector($el))->elements());
  }

  #[Test]
  public function addedNameIsContained() {
    $v= new Vector();
    $o= new Name('one');
    $v->add($o);
    Assert::true($v->contains($o));
  }

  #[Test]
  public function emptyVectorDoesNotContainName() {
    Assert::false((new Vector())->contains(new Name('Test')));
  }

  #[Test]
  public function indexOfOnEmptyVector() {
    Assert::false((new Vector())->indexOf(new Name('Test')));
  }

  #[Test]
  public function indexOf() {
    $a= new Name('A');
    Assert::equals(0, (new Vector([$a]))->indexOf($a));
  }

  #[Test]
  public function indexOfElementContainedTwice() {
    $a= new Name('A');
    Assert::equals(0, (new Vector([$a, new Name('Test'), $a]))->indexOf($a));
  }

  #[Test]
  public function lastIndexOfOnEmptyVector() {
    Assert::false((new Vector())->lastIndexOf(new Name('Test')));
  }

  #[Test]
  public function lastIndexOf() {
    $a= new Name('A');
    Assert::equals(0, (new Vector([$a]))->lastIndexOf($a));
  }

  #[Test]
  public function lastIndexOfElementContainedTwice() {
    $a= new Name('A');
    Assert::equals(2, (new Vector([$a, new Name('Test'), $a]))->lastIndexOf($a));
  }

  #[Test]
  public function stringOfEmptyVector() {
    Assert::equals(
      "util.collections.Vector[0]@{\n}",
      (new Vector())->toString()
    );
  }

  #[Test]
  public function stringOf() {
    Assert::equals(
      "util.collections.Vector[2]@{\n  0: One\n  1: Two\n}",
      (new Vector([new Name('One'), new Name('Two')]))->toString()
    );
  }

  #[Test]
  public function iteration() {
    $v= new Vector();
    for ($i= 0; $i < 5; $i++) {
      $v->add(new Name('#'.$i));
    }
    
    $i= 0;
    foreach ($v as $offset => $string) {
      Assert::equals($offset, $i);
      Assert::equals(new Name('#'.$i), $string);
      $i++;
    }
  }

  #[Test]
  public function twoEmptyVectorsAreEqual() {
    Assert::true((new Vector())->equals(new Vector()));
  }

  #[Test]
  public function sameVectorsAreEqual() {
    $a= new Vector([new Name('One'), new Name('Two')]);
    Assert::true($a->equals($a));
  }

  #[Test]
  public function vectorsWithSameContentsAreEqual() {
    $a= new Vector([new Name('One'), new Name('Two')]);
    $b= new Vector([new Name('One'), new Name('Two')]);
    Assert::true($a->equals($b));
  }

  #[Test]
  public function aVectorIsNotEqualToNull() {
    Assert::false((new Vector())->equals(null));
  }

  #[Test]
  public function twoVectorsOfDifferentSizeAreNotEqual() {
    Assert::false((new Vector([new Name('Test')]))->equals(new Vector()));
  }

  #[Test]
  public function orderMattersForEquality() {
    $a= [new Name('a'), new Name('b')];
    $b= [new Name('b'), new Name('a')];
    Assert::false((new Vector($a))->equals(new Vector($b)));
  }

  #[Test]
  public function addFunction() {
    $f= function() { return 'test'; };
    Assert::equals($f, (new Vector([$f]))[0]);
  }

  #[Test]
  public function addFunctions() {
    $f= [function() { return 'one'; }, function() { return 'two'; }];
    Assert::equals($f, (new Vector($f))->elements());
  }
}