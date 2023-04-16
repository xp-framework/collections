<?php namespace util\collections\unittest;

use test\Assert;
use test\{Test, TestCase};
use util\collections\HashImplementation;


/**
 * Base class for all HashImplementation tests
 *
 * @see  xp://util.collections.HashImplementation
 */
abstract class AbstractHashImplementationTest {
  protected $fixture;

  /**
   * Initializes fixture
   */
  #[Before]
  public function setUp() {
    $this->fixture= $this->newFixture();
  }

  /**
   * Creates new fixture
   *
   * @return  util.collections.HashImplementation
   */
  protected abstract function newFixture();

  /**
   * Tests hashOf()
   */
  #[Test]
  public function hashof_returns_non_empty_string_for_empty_input() {
    Assert::notEquals('', $this->fixture->hashOf(''));
  }

  /**
   * Tests hashOf()
   */
  #[Test]
  public function hashof_returns_non_empty_string_for_non_empty_input() {
    Assert::notEquals('', $this->fixture->hashOf('Test'));
  }
}