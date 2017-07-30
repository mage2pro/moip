<?php
namespace Dfe\Moip\Init;
/**   
 * 2017-07-30
 * @method \Dfe\Moip\Method m()
 * @method \Dfe\Moip\Settings s()
 */
final class Action extends \Df\Payment\Init\Action {
	/**
	 * 2017-07-30
	 * @override
	 * @see \Df\Payment\Init\Action::redirectUrl()
	 * @used-by \Df\Payment\Init\Action::action()
	 * @return string|null
	 * An example of result: https://checkout-sandbox.moip.com.br/boleto/PAY-6ZOT75ZXSG16
	 */
	protected function redirectUrl() {return !$this->m()->isBoleto() ? null :
		$this->m()->chargeNew($this->preconfiguredToCapture())->a(self::PATH)
	;}

	/**
	 * 2017-07-30
	 * @used-by redirectUrl()
	 * @used-by \Dfe\Moip\Method::redirectNeeded()
	 */
	const PATH = '_links/payBoleto/redirectHref';
}