<?php
namespace Dfe\Moip\T;
use Moip\Exceptions\UnautorizedException as leUnautorized;
use Moip\Exceptions\UnexpectedException as leUnexpected;
use Moip\Exceptions\ValidationException as leValidation;
// 2017-06-08
final class Order extends TestCase {
	/** 2017-06-08 */
	function t00() {}

	/** @test 2017-06-08 https://documentao-moip.readme.io/v2.0/reference#criar-pedido */
	function t01_add() {
		try {
			echo 'OK';
		}
		catch (\Exception $e) {
			/** @var \Exception|leUnautorized|leUnexpected|leValidation $e */
			xdebug_break();
			throw $e;
		}
	}
}