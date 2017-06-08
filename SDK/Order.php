<?php
namespace Dfe\Moip\SDK;
use Moip\Exceptions\UnautorizedException as leUnautorized;
use Moip\Exceptions\UnexpectedException as leUnexpected;
use Moip\Exceptions\ValidationException as leValidation;
// 2017-06-08
// https://dev.moip.com.br/page/api-reference#section-orders
// https://dev.moip.com.br/v2.0/reference#pedidos
final class Order extends Entity {
	/**
	 * 2017-06-08
	 * https://dev.moip.com.br/page/api-reference#section-create-an-order-post-
	 * https://dev.moip.com.br/v2.0/reference#criar-pedido
	 * @param array(string => mixed) $a
	 * @return self
	 * @throws leUnautorized|leUnexpected|leValidation
	 */
	static function create(array $a) {return self::exec('POST', $a);}

	/**
	 * 2017-06-08
	 * https://dev.moip.com.br/page/api-reference#section-retrieve-an-order-get-
	 * https://dev.moip.com.br/v2.0/reference#consultar-pedido
	 * @param string $id
	 * @return self
	 * @throws leUnautorized|leUnexpected|leValidation
	 */
	static function get($id) {return self::exec('GET', $id);}

	/**
	 * 2017-06-08
	 * @used-by create()
	 * @used-by get()
	 * @param string $verb
	 * @param string|array(string => mixed) $data
	 * @return self
	 */
	private static function exec($verb, $data) {
		/** @var Operation $op */
		$op = new Operation;
		/** @var string|null $id */
		list($id, $data) = is_array($data) ? [null, $data] : [$data, null];
		$op->exec("/v2/orders/$id", $verb, $data);
		return new self($op);
	}
}