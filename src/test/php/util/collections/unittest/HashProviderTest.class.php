<?php namespace util\collections\unittest;
 
use unittest\TestCase;
use util\collections\HashProvider;
use util\collections\HashImplementation;

/**
 * Test HashProvider class
 *
 * @deprecated
 * @see  xp://util.collections.HashProvider
 */
class HashProviderTest extends TestCase {
  protected $fixture;

  /** @return void */
  public function setUp() {
    $this->fixture= HashProvider::getInstance();
  }

  #[@test]
  public function implementation_accessors() {
    $impl= newinstance(HashImplementation::class, [], [
      'hashOf' => function($str) { /* Intentionally empty */ }
    ]);

    $backup= $this->fixture->getImplementation();    // Backup
    $this->fixture->setImplementation($impl);
    $cmp= $this->fixture->getImplementation();
    $this->fixture->setImplementation($backup);      // Restore

    $this->assertEquals($impl, $cmp);
  }

  #[@test]
  public function hashof_uses_implementations_hashof() {
    $this->assertEquals(
      $this->fixture->getImplementation()->hashOf('Test'),
      HashProvider::hashOf('Test')
    );
  }
}
