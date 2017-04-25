<?php
// 2017-04-11
namespace Dfe\Moip;
use Magento\Sales\Model\Order\Payment\Transaction as T;
use Moip\Moip as API;
use Moip\MoipBasicAuth;
/** @method Settings s() */
final class Method extends \Df\StripeClone\Method {
	/**
	 * 2017-04-25
	 * @used-by \Dfe\Moip\Facade\Customer::api()
	 * @used-by \Dfe\Moip\T\TestCase::api()
	 * @return API
	 */
	final function api() {return dfc($this, function() {$s = $this->s(); return new API(
		new MoipBasicAuth($s->privateToken(), $s->privateKey())
		,$s->test() ? API::ENDPOINT_SANDBOX : API::ENDPOINT_PRODUCTION
	);});}

	/**
	 * 2017-04-11
	 * @override
	 * @see \Df\Payment\Method::amountLimits()
	 * @used-by \Df\Payment\Method::isAvailable()
	 * @return null
	 */
	protected function amountLimits() {return null;}

	/**
	 * 2017-04-11
	 * @override
	 * @see \Df\StripeClone\Method::transUrlBase()
	 * @used-by \Df\StripeClone\Method::transUrl()
	 * @param T $t
	 * @return string
	 */
	protected function transUrlBase(T $t) {return '';}
}