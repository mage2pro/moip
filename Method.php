<?php
namespace Dfe\Moip;
use Magento\Sales\Model\Order\Payment\Transaction as T;
// 2017-04-11
/** @method Settings s() */
final class Method extends \Df\StripeClone\Method {
	/**
	 * 2017-07-15
	 * @used-by \Dfe\Moip\Block\Info::prepare()
	 * @used-by \Dfe\Moip\P\Charge::p()
	 * @return int
	 */
	function plan() {return intval($this->iia(self::$II_PLAN));}

	/**
	 * 2017-07-14
	 * 2017-07-20 It is CPF: https://en.wikipedia.org/wiki/Cadastro_de_Pessoas_Físicas
	 * @used-by \Dfe\Moip\P\Charge::pTaxDocument()
	 * @return string|null
	 */
	function taxID() {return $this->iia(self::$II_TAX_ID);}

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
		self::$II_CARDHOLDER, self::$II_PLAN, self::$II_TAX_ID
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
	 * 2017-07-12 https://github.com/mage2pro/moip/blob/0.6.8/view/frontend/web/main.js#L66-L68
	 * @used-by iiaKeys()
	 */
	private static $II_CARDHOLDER = 'cardholder';

	/**
	 * 2017-07-15 https://github.com/mage2pro/moip/blob/0.6.8/view/frontend/web/main.js#L66-L68
	 * @used-by iiaKeys()
	 */
	private static $II_PLAN = 'plan';

	/**
	 * 2017-07-12 https://github.com/mage2pro/moip/blob/0.6.8/view/frontend/web/main.js#L66-L68
	 * @used-by taxID()
	 * @used-by iiaKeys()
	 */
	private static $II_TAX_ID = 'taxID';
}