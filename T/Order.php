<?php
namespace Dfe\Moip\T;
use Moip\Exceptions\UnautorizedException as leUnautorized;
use Moip\Exceptions\UnexpectedException as leUnexpected;
use Moip\Exceptions\ValidationException as leValidation;
use Moip\Moip as API;
// 2017-06-08
final class Order extends TestCase {
	/** 2017-06-08 */
	function t00() {}

	/** @test 2017-06-08 https://documentao-moip.readme.io/v2.0/reference#criar-pedido */
	function t01_create() {
		/** @var API $api */
		$api = $this->m()->api();
		try {
			$order = $api->orders()->setOwnId(uniqid())
			->addItem('bicicleta 1',1, 'sku1', 10000)
			->addItem('bicicleta 2',1, 'sku2', 11000)
			->addItem('bicicleta 3',1, 'sku3', 12000)
			->addItem('bicicleta 4',1, 'sku4', 13000)
			->addItem('bicicleta 5',1, 'sku5', 14000)
			->addItem('bicicleta 6',1, 'sku6', 15000)
			->addItem('bicicleta 7',1, 'sku7', 16000)
			->addItem('bicicleta 8',1, 'sku8', 17000)
			->addItem('bicicleta 9',1, 'sku9', 18000)
			->addItem('bicicleta 10',1, 'sku10', 19000)
			->setShippingAmount(3000)->setAddition(1000)->setDiscount(5000)
			->setCustomer(null)
			->create();
		}
		catch (\Exception $e) {
			/** @var \Exception|leUnautorized|leUnexpected|leValidation $e */
			xdebug_break();
			throw $e;
		}
	}
}