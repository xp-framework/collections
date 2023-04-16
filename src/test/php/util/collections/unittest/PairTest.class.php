<?php namespace util\collections\unittest;

use test\Assert;
use test\Test;
use util\collections\Pair;

/**
 * Test Pair class
 *
 * @see  xp://util.collections.Pair
 */
class PairTest {

  #[Test]
  public function can_create() {
    new Pair(null, null);
  }

  #[Test]
  public function key() {
    $p= new Pair('key', null);
    Assert::equals('key', $p->key);
  }

  #[Test]
  public function value() {
    $p= new Pair(null, 'value');
    Assert::equals('value', $p->value);
  }

  #[Test]
  public function equals_same_instance() {
    $p= new Pair(null, null);
    Assert::equals($p, $p);
  }

  #[Test]
  public function equals_null_key_null_value() {
    Assert::equals(new Pair(null, null), new Pair(null, null));
  }

  #[Test]
  public function equals_primitive_key_null_value() {
    Assert::equals(new Pair('key', null), new Pair('key', null));
  }

  #[Test]
  public function equals_primitive_key_primitive_value() {
    Assert::equals(new Pair('key', 'value'), new Pair('key', 'value'));
  }

  #[Test]
  public function equals_key_instance_value_instance() {
    Assert::equals(
      new Pair(new Name('key'), new Name('value')),
      new Pair(new Name('key'), new Name('value'))
    );
  }

  #[Test]
  public function primitive_key_and_value_not_equal_to_null_key_and_value() {
    Assert::notEquals(new Pair('key', 'value'), new Pair(null, null));
  }

  #[Test]
  public function instance_key_and_value_not_equal_to_null_key_and_value() {
    Assert::notEquals(
      new Pair(new Name('key'), new Name('value')),
      new Pair(null, null)
    );
  }

  #[Test]
  public function pair_not_equals_to_null() {
    Assert::notEquals(new Pair(null, null), null);
  }

  #[Test]
  public function hashcode_of_nulls_equal() {
    Assert::equals(
      (new Pair(null, null))->hashCode(),
      (new Pair(null, null))->hashCode()
    );
  }

  #[Test]
  public function hashcode_of_different_keys_not_equal() {
    Assert::notEquals(
      (new Pair(null, null))->hashCode(),
      (new Pair('key', null))->hashCode()
    );
  }

  #[Test]
  public function hashcode_of_different_values_not_equal() {
    Assert::notEquals(
      (new Pair(null, null))->hashCode(),
      (new Pair(null, 'value'))->hashCode()
    );
  }
}