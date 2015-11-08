<?php namespace util\collections\unittest;
 
use util\collections\MD5HexHashImplementation;


/**
 * Test MD5Hex
 *
 * @see  xp://util.collections.MD5HexHashImplementation
 */
class MD5HexHashImplementationTest extends AbstractHashImplementationTest {

  /**
   * Creates new fixture
   *
   * @return  util.collections.HashImplementation
   */
  protected function newFixture() {
    return new MD5HexHashImplementation();
  }

  /**
   * Tests hashOf()
   */
  #[@test]
  public function hashof_empty() {
    $this->assertEquals(0xd41d8cd98f00b204e9800998ecf8427e, $this->fixture->hashOf(''));
  }

  /**
   * Tests hashOf()
   */
  #[@test]
  public function hashof_test() {
    $this->assertEquals(0x098f6bcd4621d373cade4e832627b4f6, $this->fixture->hashOf('test'));
  }
}
