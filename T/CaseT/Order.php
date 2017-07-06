<?php
namespace Dfe\Moip\T\CaseT;
use Dfe\Moip\T\Order as tOrder;
use Moip\Exceptions\UnautorizedException as leUnautorized;
use Moip\Exceptions\UnexpectedException as leUnexpected;
use Moip\Exceptions\ValidationException as leValidation;
// 2017-06-08
// https://dev.moip.com.br/page/api-reference#section-orders
// https://dev.moip.com.br/v2.0/reference#pedidos
final class Order extends \Dfe\Moip\T\CaseT {
	/** @test 2017-06-08 */
	function t00() {}

	/**
	 * 2017-06-08
	 * https://dev.moip.com.br/v2.0/reference#criar-pedido
	 * https://dev.moip.com.br/page/api-reference#section-create-an-order-post-
	 * [Moip] An example of a response to «POST v2/orders» https://mage2.pro/t/4045
	 */
	function t01_create() {
		try {
			echo (new tOrder)->create()->j();
			//echo df_json_encode($this->pOrder());
		}
		catch (\Exception $e) {
			if (function_exists('xdebug_break')) {
				xdebug_break();
			}
			/** @var \Exception|leUnautorized|leUnexpected|leValidation $e */
			throw $e;
		}
	}
}