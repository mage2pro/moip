<?php
namespace Dfe\Moip\T;
use Moip\Moip as API;
// 2017-04-20
final class Basic extends TestCase {
	/** 2017-04-20 */
	function t01() {echo df_dump([
		$this->s()->publicKey(), $this->s()->privateToken(), $this->s()->privateKey()
	]);}

	/** @test 2017-04-20 */
	function t02() {echo get_class($this->api());}
}