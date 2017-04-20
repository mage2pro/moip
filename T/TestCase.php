<?php
namespace Dfe\Moip\T;
use Moip\Moip as API;
use Moip\MoipBasicAuth;
/**
 * 2017-04-20
 * @see \Dfe\Moip\T\Basic
 * @method \Dfe\Moip\Settings s()
 */
abstract class TestCase extends \Df\Payment\TestCase {
	/**
	 * 2017-04-20
	 * @return API
	 */
	final protected function api() {return dfc($this, function() {$s = $this->s(); xdebug_break(); return new API(
		new MoipBasicAuth($s->privateToken(), $s->privateKey())
		,$this->s()->test() ? API::ENDPOINT_SANDBOX : API::ENDPOINT_PRODUCTION
	);});}
}