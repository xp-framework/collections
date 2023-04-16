<?php namespace util\collections\unittest;

use test\{Assert, Test};
use util\collections\HashSet;

class HashSetTest {

  #[Test]
  public function initiallyEmpty() {
    Assert::true((new HashSet())->isEmpty());
  }

  #[Test]
  public function equalsClone() {
    $set= new HashSet();
    $set->add(new Name('green'));
    Assert::true($set->equals(clone($set)));
  }
 
  #[Test]
  public function equalsOtherSetWithSameContents() {
    $set= new HashSet();
    $other= new HashSet();
    $set->add(new Name('color'));
    $other->add(new Name('color'));
    Assert::true($set->equals($other));
  }

  #[Test]
  public function doesNotEqualSetWithDifferentContents() {
    $set= new HashSet();
    $other= new HashSet();
    $set->add(new Name('blue'));
    $other->add(new Name('yellow'));
    Assert::false($set->equals($other));
  }
 
  #[Test]
  public function add() {
    $set= new HashSet();
    $set->add(new Name('green'));
    Assert::false($set->isEmpty());
    Assert::equals(1, $set->size());
  }

  #[Test]
  public function addAll() {
    $set= new HashSet();
    $array= [new Name('one'), new Name('two'), new Name('three')];
    $set->addAll($array);
    Assert::false($set->isEmpty());
    Assert::equals(3, $set->size());
  }

  #[Test]
  public function addAllUniques() {
    $set= new HashSet();
    $array= [new Name('one'), new Name('one'), new Name('two')];
    $set->addAll($array);
    Assert::false($set->isEmpty());
    Assert::equals(2, $set->size());   // Name{"one"} and Name{"two"}
  }

  #[Test]
  public function addAllReturnsWhetherSetHasChanged() {
    $set= new HashSet();
    $array= [new Name('caffeine'), new Name('nicotine')];
    Assert::true($set->addAll($array));
    Assert::false($set->addAll($array));
    Assert::false($set->addAll([new Name('caffeine')]));
    Assert::false($set->addAll([]));
  }

  #[Test]
  public function contains() {
    $set= new HashSet();
    $set->add(new Name('key'));
    Assert::true($set->contains(new Name('key')));
    Assert::false($set->contains(new Name('non-existant-key')));
  }

  #[Test]
  public function addSameValueTwice() {
    $set= new HashSet();
    $color= new Name('green');
    Assert::true($set->add($color));
    Assert::false($set->add($color));
  }

  #[Test]
  public function remove() {
    $set= new HashSet();
    $set->add(new Name('key'));
    Assert::true($set->remove(new Name('key')));
    Assert::true($set->isEmpty());
  }

  #[Test]
  public function removeOnEmptySet() {
    $set= new HashSet();
    Assert::false($set->remove(new Name('irrelevant-set-is-empty-anyway')));
  }

  #[Test]
  public function removeNonExistantObject() {
    $set= new HashSet();
    $set->add(new Name('key'));
    Assert::false($set->remove(new Name('non-existant-key')));
  }

  #[Test]
  public function clear() {
    $set= new HashSet();
    $set->add(new Name('key'));
    $set->clear();
    Assert::true($set->isEmpty());
  }

  #[Test]
  public function toArray() {
    $set= new HashSet();
    $color= new Name('red');
    $set->add($color);
    Assert::equals([$color], $set->toArray());
  }

  #[Test]
  public function toArrayOnEmptySet() {
    $set= new HashSet();
    Assert::equals([], $set->toArray());
  }

  #[Test]
  public function iteration() {
    $set= new HashSet();
    $set->add(new Name('1'));
    $set->add(new Name('2'));
    $set->add(new Name('3'));
    
    foreach ($set as $i => $value) {
      Assert::equals(new Name($i+ 1), $value);
    }
  }

  #[Test]
  public function stringRepresentation() {
    $set= new HashSet();
    $set->add(new Name('color'));
    $set->add(new Name('price'));
    Assert::equals(
      "util.collections.HashSet[2] {\n  color,\n  price\n}",
      $set->toString()
    );
  }

  #[Test]
  public function stringRepresentationOfEmptySet() {
    $set= new HashSet();
    Assert::equals(
      'util.collections.HashSet[0] { }',
      $set->toString()
    );
  }

  #[Test]
  public function addFunction() {
    $set= new HashSet();
    $f= function() { return 'test'; };
    $set->add($f);
    Assert::equals([$f], $set->toArray());
  }
}