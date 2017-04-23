<?php namespace util\collections;

/**
 * MD5 implementation that uses hexdec() on md5() to calculate the
 * numeric value instead of relying on addition taking care of this.
 *
 * Bug this works around:
 * ```sh
 * $ php -r '$o= 0; $o+= "0x12195d4e54299a3cc1bde564c5de04b6"; var_dump($o);'
 *
 * // 5.2.0 : int(0)
 * // 5.2.10: float(2.4057803815529E+37)
 * ```
 *
 * @deprecated
 * @see   php://md5
 * @see   php://hexdec
 * @see   xp://util.collections.HashProvider
 * @test  xp://net.xp_framework.unittest.util.collections.MD5HexHashImplementationTest:
 */
class MD5HexHashImplementation extends \lang\Object implements HashImplementation {

  /**
   * Retrieve hash code for a given string
   *
   * @param   string str
   * @return  int hashcode
   */
  public function hashOf($str) {
    return hexdec(md5($str));
  }
} 
