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

	/** @test 2017-06-08 */
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
	 * @used-by pOrder()
	 * @return array(string => mixed)
	 */
	private function pAmount() {return [
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
	];}

	/**
	 * 2017-06-08
	 * @used-by t01_create()
	 * @return array(string => mixed)
	 */
	private function pOrder() {return [
		// 2017-06-09
		// «Order values.»
		// Required, String(66).
		// My notes: the order amount is calculated automatically by Moip.
		'amount' => $this->pAmount()
		// 2017-06-09
		// «Items structure.»
		,'items' => [
			
		]
		// 2017-06-09
		// «Own id of an order. External reference.»
		// Required, String(66).
		,'ownId' => df_uid(4, 'admin@mage2.pro-')
	];}
}