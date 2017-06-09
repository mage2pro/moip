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

	/** 2017-06-08 */
	function t01_create() {
		try {
			echo (new tOrder)->create()->j();
			//echo df_json_encode_pretty($this->pOrder());
		}
		catch (\Exception $e) {
			/** @var \Exception|leUnautorized|leUnexpected|leValidation $e */
			xdebug_break();
			throw $e;
		}
	}
}