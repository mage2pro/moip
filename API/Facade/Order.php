<?php
namespace Dfe\Moip\API\Facade;
use Df\API\Operation as O;
use Df\Core\Exception as DFE;
use Zend_Http_Client as Z;
/**
 * 2017-06-08
 * https://dev.moip.com.br/page/api-reference#section-orders
 * https://dev.moip.com.br/v2.0/reference#pedidos
 *
 * 2017-06-08 create:
 * https://dev.moip.com.br/page/api-reference#section-create-an-order-post-
 * https://dev.moip.com.br/v2.0/reference#criar-pedido
 * 2017-06-13 [Moip] An example of a response to «POST v2/orders» https://mage2.pro/t/4045
 *
 * 2017-06-08 get:
 * https://dev.moip.com.br/page/api-reference#section-retrieve-an-order-get-
 * https://dev.moip.com.br/v2.0/reference#consultar-pedido  
 * 
 * @method static Order s()
 */
final class Order extends \Df\API\Facade {
	/**
	 * 2017-06-09
	 * https://dev.moip.com.br/page/api-reference#section-create-a-payment-post-
	 * https://dev.moip.com.br/v2.0/reference#criar-pagamento
	 * @used-by \Dfe\Moip\Facade\Charge::create()
	 * @used-by \Dfe\Moip\T\CaseT\Payment\Boleto::t01_create()
	 * @used-by \Dfe\Moip\T\CaseT\Payment\Card::t01_create()
	 * @used-by \Dfe\Moip\T\CaseT\Payment\OnlineBanking::t01_create()
	 * @param string $orderId
	 * @param array(string => mixed) $a
	 * @return O
	 * @throws DFE
	 */
	function payment($orderId, array $a) {return $this->p([$orderId, $a], Z::POST, 'payments');}
}