<?php namespace util\collections\unittest;

use lang\{IllegalArgumentException, Value};
use test\{Assert, Expect, Test, Values};
use util\collections\{HashTable, Pair};
use util\{Currency, Money};

class HashTableTest {

  /** @return var[] */
  private function fixtures() {
    return [
      [new HashTable(), [
        new Pair('color', 'pink'),
        new Pair('price', null)
      ]],
      [new HashTable(), [
        new Pair(new Name('color'), new Name('green')),
        new Pair(new Name('price'), new Money(12.99, Currency::$EUR))
      ]],
      [create('new util.collections.HashTable<string, util.collections.unittest.Name>'), [
        new Pair('hello', new Name('World')),
        new Pair('hallo', new Name('Welt'))
      ]],
      [create('new util.collections.HashTable<util.collections.unittest.Name, string[]>'), [
        new Pair(new Name('1'), ['one', 'eins']),
        new Pair(new Name('2'), ['two', 'zwei'])
      ]],
      [create('new util.collections.HashTable<int[], var>'), [
        new Pair([1, 2], 3),
        new Pair([0, -1], 'Test')
      ]],
      [create('new util.collections.HashTable<string, function(): var>'), [
        new Pair('color', function() { return 'purple'; }),
        new Pair('price', function() { return 12.99; }),
      ]],
    ];
  }

  /** @return var[] */
  private function variations() {
    return [
      [new HashTable()],
      [create('new util.collections.HashTable<lang.Value, lang.Value>')]
    ];
  }

  /** @return lang.Value */
  private function hashCodeCounter() {
    return new class() implements Value {
      public $invoked= 0;
      public function toString() { return 'Test'; }
      public function hashCode() { $this->invoked++; return 'Test'; }
      public function compareTo($value) { return 0; }
    };
  }

  #[Test, Values(from: 'fixtures')]
  public function can_create($fixture, $pairs) {
    // Intentionally empty
  }

  #[Test, Values(from: 'fixtures')]
  public function map_is_initially_empty($fixture, $pairs) {
    Assert::true($fixture->isEmpty());
  }

  #[Test, Values(from: 'fixtures')]
  public function map_size_is_initially_zero($fixture, $pairs) {
    Assert::equals(0, $fixture->size());
  }

  #[Test, Values(from: 'fixtures')]
  public function put($fixture, $pairs) {
    $fixture->put($pairs[0]->key, $pairs[0]->value);
  }

  #[Test, Values(from: 'variations')]
  public function put_uses_hashCode_for_keys($fixture) {
    $object= $this->hashCodeCounter();
    $fixture->put($object, new Name('test'));
    Assert::equals(1, $object->invoked);
  }

  #[Test, Values(from: 'fixtures')]
  public function array_access_for_writing($fixture, $pairs) {
    $fixture[$pairs[0]->key]= $pairs[0]->value;
  }

  #[Test, Values(from: 'fixtures')]
  public function put_returns_previously_value($fixture, $pairs) {
    $fixture->put($pairs[0]->key, $pairs[0]->value);
    Assert::equals($pairs[0]->value, $fixture->put($pairs[0]->key, $pairs[1]->value));
  }

  #[Test, Values(from: 'fixtures')]
  public function map_no_longer_empty_after_put($fixture, $pairs) {
    $fixture->put($pairs[0]->key, $pairs[0]->value);
    Assert::false($fixture->isEmpty());
  }

  #[Test, Values(from: 'fixtures')]
  public function map_size_no_longer_zero_after_put($fixture, $pairs) {
    $fixture->put($pairs[0]->key, $pairs[0]->value);
    Assert::equals(1, $fixture->size());
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function put_illegal_type_in_key() {
    create('new util.collections.HashTable<string, util.collections.unittest.Name>')->put(5, new Name('hello'));
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function put_illegal_type_in_value() {
    create('new util.collections.HashTable<string, util.collections.unittest.Name>')->put('hello', $this);
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function put_raises_when_using_null_for_string_instance() {
    create('new util.collections.HashTable<string, util.collections.unittest.Name>')->put('test', null);
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function put_raises_when_using_null_for_arrays() {
    create('new util.collections.HashTable<string, var[]>')->put('test', null);
  }

  #[Test, Values(from: 'fixtures')]
  public function get_returns_null_when_key_does_not_exist($fixture, $pairs) {
    Assert::null($fixture->get($pairs[0]->key));
  }

  #[Test, Values(from: 'fixtures')]
  public function get_returns_previously_put_element($fixture, $pairs) {
    $fixture->put($pairs[0]->key, $pairs[0]->value);
    Assert::equals($pairs[0]->value, $fixture->get($pairs[0]->key));
  }

  #[Test, Values(from: 'fixtures')]
  public function array_access_for_reading_non_existant($fixture, $pairs) {
    Assert::null($fixture[$pairs[0]->key]);
  }

  #[Test, Values(from: 'fixtures')]
  public function array_access_for_reading($fixture, $pairs) {
    $fixture->put($pairs[0]->key, $pairs[0]->value);
    Assert::equals($pairs[0]->value, $fixture[$pairs[0]->key]);
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function get_illegal_type_in_argument() {
    create('new util.collections.HashTable<util.collections.unittest.Name, util.collections.unittest.Name>')->get($this);
  }

  #[Test, Values(from: 'fixtures')]
  public function containsKey_returns_false_when_element_does_not_exist($fixture, $pairs) {
    Assert::false($fixture->containsKey($pairs[0]->key));
  }

  #[Test, Values(from: 'fixtures')]
  public function containsKey_returns_true_when_element_exists($fixture, $pairs) {
    $fixture->put($pairs[0]->key, $pairs[0]->value);
    Assert::true($fixture->containsKey($pairs[0]->key));
  }

  #[Test, Values(from: 'fixtures')]
  public function array_access_for_testing_non_existant($fixture, $pairs) {
    Assert::false(isset($fixture[$pairs[0]->key]));
  }

  #[Test, Values(from: 'fixtures')]
  public function array_access_for_testing($fixture, $pairs) {
    $fixture->put($pairs[0]->key, $pairs[0]->value);
    Assert::true(isset($fixture[$pairs[0]->key]));
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function containsKey_illegal_type_in_argument() {
    create('new util.collections.HashTable<util.collections.unittest.Name, util.collections.unittest.Name>')->containsKey($this);
  }

  #[Test, Values(from: 'fixtures')]
  public function containsValue_returns_false_when_element_does_not_exist($fixture, $pairs) {
    Assert::false($fixture->containsValue($pairs[0]->value));
  }

  #[Test, Values(from: 'fixtures')]
  public function containsValue_returns_true_when_element_exists($fixture, $pairs) {
    $fixture->put($pairs[0]->key, $pairs[0]->value);
    Assert::true($fixture->containsValue($pairs[0]->value));
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function containsValue_illegal_type_in_argument() {
    create('new util.collections.HashTable<util.collections.unittest.Name, util.collections.unittest.Name>')->containsValue($this);
  }

  #[Test, Values(from: 'fixtures')]
  public function remove_returns_previously_value($fixture, $pairs) {
    $fixture->put($pairs[0]->key, $pairs[0]->value);
    Assert::equals($pairs[0]->value, $fixture->remove($pairs[0]->key));
  }

  #[Test, Values(from: 'fixtures')]
  public function remove_previously_put_element($fixture, $pairs) {
    $fixture->put($pairs[0]->key, $pairs[0]->value);
    $fixture->remove($pairs[0]->key);
    Assert::false($fixture->containsKey($pairs[0]->key));
  }

  #[Test, Values(from: 'fixtures')]
  public function array_access_for_removing($fixture, $pairs) {
    $fixture->put($pairs[0]->key, $pairs[0]->value);
    unset($fixture[$pairs[0]->key]);
    Assert::false($fixture->containsKey($pairs[0]->key));
  }

  #[Test, Values(from: 'fixtures')]
  public function remove_non_existant_element($fixture, $pairs) {
    $fixture->remove($pairs[0]->key);
    Assert::false($fixture->containsKey($pairs[0]->key));
  }

  #[Test, Values(from: 'fixtures')]
  public function array_access_for_removing_non_existant_element($fixture, $pairs) {
    unset($fixture[$pairs[0]->key]);
    Assert::false($fixture->containsKey($pairs[0]->key));
  }

  #[Test, Expect(IllegalArgumentException::class)]
  public function remove_illegal_type_in_argument() {
    create('new util.collections.HashTable<util.collections.unittest.Name, util.collections.unittest.Name>')->remove($this);
  }

  #[Test, Values(from: 'fixtures')]
  public function equals_its_clone($fixture, $pairs) {
    $fixture->put($pairs[0]->key, $pairs[0]->value);
    Assert::equals($fixture, clone $fixture);
  }

  #[Test, Values(from: 'fixtures')]
  public function equals_its_clone_when_empty($fixture, $pairs) {
    Assert::equals($fixture, clone $fixture);
  }

  #[Test, Values(from: 'fixtures')]
  public function does_not_equal_empty_map($fixture, $pairs) {
    $other= clone $fixture;
    $fixture->put($pairs[0]->key, $pairs[0]->value);
    Assert::notEquals($fixture, $other);
  }

  #[Test, Values(from: 'fixtures')]
  public function does_not_equal_map_with_different_elements($fixture, $pairs) {
    $other= clone $fixture;
    $fixture->put($pairs[0]->key, $pairs[0]->value);
    $other->put($pairs[1]->key, $pairs[1]->value);
    Assert::notEquals($fixture, $other);
  }

  #[Test, Values(from: 'fixtures')]
  public function clear($fixture, $pairs) {
    $fixture->put($pairs[0]->key, $pairs[0]->value);
    $fixture->clear();
    Assert::true($fixture->isEmpty());
  }

  #[Test, Values(from: 'fixtures')]
  public function keys_returns_empty_array_for_empty_map($fixture, $pairs) {
    Assert::equals([], $fixture->keys());
  }

  #[Test, Values(from: 'fixtures')]
  public function keys_returns_array_of_added_keys($fixture, $pairs) {
    $fixture->put($pairs[0]->key, $pairs[0]->value);
    $fixture->put($pairs[1]->key, $pairs[1]->value);
    Assert::equals([$pairs[0]->key, $pairs[1]->key], $fixture->keys());
  }

  #[Test, Values(from: 'fixtures')]
  public function values_returns_empty_array_for_empty_map($fixture, $pairs) {
    Assert::equals([], $fixture->values());
  }

  #[Test, Values(from: 'fixtures')]
  public function values_returns_array_of_added_values($fixture, $pairs) {
    $fixture->put($pairs[0]->key, $pairs[0]->value);
    $fixture->put($pairs[1]->key, $pairs[1]->value);
    Assert::equals([$pairs[0]->value, $pairs[1]->value], $fixture->values());
  }

  #[Test, Values(from: 'fixtures')]
  public function can_be_used_in_foreach($fixture, $pairs) {
    $fixture->put($pairs[0]->key, $pairs[0]->value);
    $fixture->put($pairs[1]->key, $pairs[1]->value);
    $iterated= [];
    foreach ($fixture as $pair) {
      $iterated[]= $pair;
    }
    Assert::equals([$pairs[0], $pairs[1]], $iterated);
  }

  #[Test, Values(from: 'fixtures')]
  public function can_be_used_in_foreach_with_empty_map($fixture, $pairs) {
    $iterated= [];
    foreach ($fixture as $pair) {
      $iterated[]= $pair;
    }
    Assert::equals([], $iterated);
  }

  #[Test, Values(from: 'fixtures')]
  public function iteration_invoked_twice($fixture, $pairs) {
    $fixture->put($pairs[0]->key, $pairs[0]->value);
    $fixture->put($pairs[1]->key, $pairs[1]->value);
    $iterated= [];
    foreach ($fixture as $pair) {
      $iterated[]= $pair;
    }
    foreach ($fixture as $pair) {
      $iterated[]= $pair;
    }
    Assert::equals([$pairs[0], $pairs[1], $pairs[0], $pairs[1]], $iterated);
  }

  #[Test, Values(from: 'fixtures')]
  public function second_iteration_with_break_statement($fixture, $pairs) {
    $fixture->put($pairs[0]->key, $pairs[0]->value);
    $fixture->put($pairs[1]->key, $pairs[1]->value);
    $iterated= [];
    foreach ($fixture as $pair) {
      $iterated[]= $pair;
    }
    foreach ($fixture as $pair) {
      break;
    }
    Assert::equals([$pairs[0], $pairs[1]], $iterated);
  }

  #[Test]
  public function string_representation_of_empty_map() {
    Assert::equals(
      'util.collections.HashTable[0] { }',
      (new HashTable())->toString()
    );
  }

  #[Test]
  public function string_representation_of_map_with_contents() {
    $fixture= new HashTable();
    $fixture->put('hello', 'World');
    $fixture->put('hallo', 'Welt');
    Assert::equals(
      "util.collections.HashTable[2] {\n".
      "  \"hello\" => \"World\",\n".
      "  \"hallo\" => \"Welt\"\n".
      "}",
      $fixture->toString()
    );
  }

  #[Test]
  public function string_representation_of_generic_map() {
    Assert::equals(
      'util.collections.HashTable<string,util.collections.unittest.Name>[0] { }',
      create('new util.collections.HashTable<string, util.collections.unittest.Name>')->toString()
    );
  }
}