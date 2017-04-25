<?php
namespace Dfe\Moip\T;
use Dfe\Moip\Method as M;
use Moip\Moip as API;
/**
 * 2017-04-20
 * @see \Dfe\Moip\T\Customer
 * @method M m()
 * @method \Dfe\Moip\Settings s()
 */
abstract class TestCase extends \Df\Payment\TestCase {
	/**
	 * 2017-04-20
	 * @return API
	 */
	final protected function api() {return $this->m()->api();}
}