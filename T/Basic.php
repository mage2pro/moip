<?php
namespace Dfe\Moip\T;
// 2017-04-12
final class Basic extends TestCase {
	/** @test 2017-04-12 */
	function t01() {echo df_dump([
		$this->s()->publicKey(), $this->s()->privateToken(), $this->s()->privateKey()
	]);}
}