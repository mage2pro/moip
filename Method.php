<?php
namespace Dfe\Moip;
use Magento\Sales\Model\Order\Payment\Transaction as T;
use Moip\Auth\BasicAuth as Auth;
use Moip\Moip as API;
// 2017-04-11
/** @method Settings s() */
final class Method extends \Df\StripeClone\Method {
	/**
	 * 2017-04-25
	 * @used-by \Dfe\Moip\SDK\Operation::__construct()
	 * @return API
	 */
	function api() {return dfc($this, function() {$s = $this->s(); return new API(
		new Auth($s->privateToken(), $s->privateKey())
		,$this->test(API::ENDPOINT_SANDBOX, API::ENDPOINT_PRODUCTION)
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
	 * 2017-07-12
	 * @override
	 * @see \Df\StripeClone\Method::iiaKeys()
	 * @used-by \Df\Payment\Method::assignData()
	 * @return string[]
	 */
	protected function iiaKeys() {return array_merge(parent::iiaKeys(), [
		self::$II_CARDHOLDER, self::$II_TAX_ID
	]);}

	/**
	 * 2017-04-11
	 * @override
	 * @see \Df\StripeClone\Method::transUrlBase()
	 * @used-by \Df\StripeClone\Method::transUrl()
	 * @param T $t
	 * @return string
	 */
	protected function transUrlBase(T $t) {return '';}

	/**
	 * 2017-07-12
	 * https://github.com/mage2pro/moip/blob/0.5.7/view/frontend/web/main.js#L17-L19
	 * @used-by iiaKeys()
	 */
	private static $II_CARDHOLDER = 'cardholder';

	/**
	 * 2017-07-12
	 * https://github.com/mage2pro/moip/blob/0.5.7/view/frontend/web/main.js#L17-L19
	 * @used-by iiaKeys()
	 */
	private static $II_TAX_ID = 'taxID';
}