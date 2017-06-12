<?php
namespace Dfe\Moip\SDK;
use Moip\Exceptions\UnautorizedException as leUnautorized;
use Moip\Exceptions\UnexpectedException as leUnexpected;
use Moip\Exceptions\ValidationException as leValidation;
// 2017-06-09
// https://dev.moip.com.br/page/api-reference#section-payments
// https://dev.moip.com.br/v2.0/reference#pagamentos
final class Payment extends Entity {
	/**
	 * 2017-06-09
	 * https://dev.moip.com.br/page/api-reference#section-create-a-payment-post-
	 * https://dev.moip.com.br/v2.0/reference#criar-pagamento
	 * @used-by \Dfe\Moip\Facade\Charge::create()
	 * @used-by \Dfe\Moip\T\CaseT\Payment::t01_create()
	 * @param string $orderId
	 * @param array(string => mixed) $a
	 * @return self
	 * @throws leUnautorized|leUnexpected|leValidation
	 */
	static function create($orderId, array $a) {
		/** @var Operation $op */
		$op = new Operation;
		$op->exec("/v2/orders/$orderId/payments", 'POST', $a);
		return new self($op);
	}

	/**
	 * 2017-06-09
	 * https://dev.moip.com.br/page/api-reference#section-retrieve-a-payment-get-
	 * https://dev.moip.com.br/v2.0/reference#consultar-pagamento
	 * @param string $id
	 * @return self
	 * @throws leUnautorized|leUnexpected|leValidation
	 */
	static function get($id) {
		/** @var Operation $op */
		$op = new Operation;
		$op->exec("/v2/payments/$id", 'GET');
		return new self($op);
	}
}