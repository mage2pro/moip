<?php
namespace Dfe\Moip\SDK;
use Moip\Exceptions\UnautorizedException as leUnautorized;
use Moip\Exceptions\UnexpectedException as leUnexpected;
use Moip\Exceptions\ValidationException as leValidation;
use Moip\Moip as API;
// 2017-04-25
final class Customer extends Entity {
	/**
	 * 2017-04-25
	 * @used-by \Dfe\Moip\Facade\Customer::create()
	 * @param API $api
	 * @param array(string => mixed) $a
	 * @return self
	 * @throws leUnautorized|leUnexpected|leValidation
	 */
	static function create(API $api, array $a) {
		/** @var Operation $op */
		$op = new Operation($api);
		$op->exec('/v2/customers/', 'POST', $a);
		return new self($op);
	}
}