<?php
namespace Dfe\Moip\T;
use Dfe\Moip\SDK\Order as O;
use Moip\Exceptions\UnautorizedException as leUnautorized;
use Moip\Exceptions\UnexpectedException as leUnexpected;
use Moip\Exceptions\ValidationException as leValidation;
// 2017-06-08
// https://dev.moip.com.br/page/api-reference#section-orders
// https://dev.moip.com.br/v2.0/reference#pedidos
final class Order extends TestCase {
	/** 2017-06-08 */
	function t00() {}

	/**
	 * @test
	 * 2017-06-08
	 * https://dev.moip.com.br/page/api-reference#section-create-an-order-post-
	 * https://dev.moip.com.br/v2.0/reference#criar-pedido
	 */
	function t01_create() {
		try {
			echo O::create($this->pOrder())->j();
		}
		catch (\Exception $e) {
			/** @var \Exception|leUnautorized|leUnexpected|leValidation $e */
			xdebug_break();
			throw $e;
		}
	}

	/**
	 * 2017-06-08
	 * @used-by t01_create()
	 * @return array(string => mixed)
	 */
	private function pOrder() {return [
		// 2017-06-08
		// «Customer Id. External reference.»
		// Required, String(66).
		// It should be unique, otherwise you will get the error:
		// «O identificador prßprio deve ser único, j¹ existe um customer com o identificador informado»
		// («The unique identifier must be unique, there is a customer with the identified identifier»).
		'ownId' => df_uid(4, 'admin@mage2.pro-')
	];}
}