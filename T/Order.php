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
	 * https://dev.moip.com.br/page/api-reference#section-create-a-customer-post-
	 * https://dev.moip.com.br/v2.0/reference#criar-um-cliente
	 * @used-by t01_create()
	 * @return array(string => mixed)
	 */
	private function pOrder() {return [
		// 2017-06-09
		// «Order values.»
		// Required, String(66).
		'amount' => [
			// 2017-06-09
			// «Currency used in the order. Possible values: BRL. Default value BRL.»
			// Optional, String.
			'currency' => 'BRL'
			// 2017-06-09
			// «Structure of additional order values.»
			// Optional, String.
			,'subtotals' => [
				// 2017-06-09
				// «Addition amount. It will be added to the items amount.»
				// Optional, Integer(12).
				'addition' => ''
				// 2017-06-09
				// «Discount amount. This value will be deducted from the total amount.»
				// Optional, Integer(12).
				,'discount' => ''
				// 2017-06-09
				// «Shipping cost. It will be added to the items amount.»
				// Optional, Integer(12).
				,'shipping' => ''
			]
		]
		// 2017-06-09
		// «Own id of an order. External reference.»
		// Required, String(66).
		,'ownId' => df_uid(4, 'admin@mage2.pro-')
	];}
}