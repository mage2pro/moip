<?php
namespace Dfe\Moip\API\Facade;
use Df\API\Operation as O;
use Df\Core\Exception as DFE;
use Zend_Http_Client as Z;
/**
 * 2017-06-09
 * https://dev.moip.com.br/page/api-reference#section-payments
 * https://dev.moip.com.br/v2.0/reference#pagamentos
 * get:
 * https://dev.moip.com.br/page/api-reference#section-retrieve-a-payment-get-
 * https://dev.moip.com.br/v2.0/reference#consultar-pagamento
 * @method static Payment s()
 */
final class Payment extends \Df\API\Facade {
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
	function create2($orderId, array $a) {return $this->p($a, Z::POST, "orders/$orderId/payments");}
}