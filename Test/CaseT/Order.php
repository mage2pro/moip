<?php
namespace Dfe\Moip\Test\CaseT;
use Dfe\Moip\Test\Order as tOrder;
# 2017-06-08
# https://dev.moip.com.br/page/api-reference#section-orders
# https://dev.moip.com.br/v2.0/reference#pedidos
final class Order extends \Dfe\Moip\Test\CaseT {
	/** 2017-06-08 @test */
	function t00():void {}

	/**
	 * 2017-06-08
	 * https://dev.moip.com.br/v2.0/reference#criar-pedido
	 * https://dev.moip.com.br/page/api-reference#section-create-an-order-post-
	 * [Moip] An example of a response to «POST v2/orders» https://mage2.pro/t/4045
	 */
	function t01_create():void {
		try {
			print_r((new tOrder)->create()->j());
			//echo df_json_encode($this->pOrder());
		}
		catch (\Throwable $t) {
			if (function_exists('xdebug_break')) {
				xdebug_break();
			}
			throw $t;
		}
	}
}