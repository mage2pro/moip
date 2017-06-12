<?php
namespace Dfe\Moip\Facade;
use Dfe\Moip\SDK\Order as O;
use Dfe\Moip\SDK\Payment as C;
use Magento\Sales\Model\Order\Creditmemo as CM;
use Magento\Sales\Model\Order\Payment as OP;
// 2017-06-11
/** @method O preorderGet() */
final class Charge extends \Df\StripeClone\Facade\Charge {
	/**
	 * 2017-06-11
	 * @override
	 * @see \Df\StripeClone\Facade\Charge::capturePreauthorized()
	 * @used-by \Df\StripeClone\Method::charge()
	 * @param string $id
	 * @param int|float $a
	 * The $a value is already converted to the PSP currency and formatted according to the PSP requirements.
	 * @return C
	 */
	function capturePreauthorized($id, $a) {return null;}

	/**
	 * 2017-06-12
	 * [Moip] An example of a response to «POST v2/customers/<customer ID>/fundinginstruments»
	 * https://mage2.pro/t/4050
	 * A card identifier looks like «CRC-M423RWG3PK7J».
	 * https://github.com/mage2pro/moip/blob/0.4.6/Facade/Card.php#L10
	 * @override
	 * @see \Df\StripeClone\Facade\Charge::cardIdPrefix()
	 * @used-by \Df\StripeClone\Payer::usePreviousCard()
	 * @return string
	 */
	function cardIdPrefix() {return 'CRC-';}

	/**
	 * 2017-06-13
	 * [Moip] An example of a response to «POST v2/orders/<order ID>/payments» https://mage2.pro/t/4048
	 * @override
	 * @see \Df\StripeClone\Facade\Charge::create()
	 * @used-by \Df\StripeClone\Method::chargeNew()
	 * @param array(string => mixed) $p
	 * @return C
	 */
	function create(array $p) {return C::create($this->preorderGet()['id'], $p);}

	/**
	 * 2017-06-13
	 * [Moip] An example of a response to «POST v2/orders/<order ID>/payments» https://mage2.pro/t/4048
	 * @override
	 * @see \Df\StripeClone\Facade\Charge::id()
	 * @used-by \Df\StripeClone\Method::chargeNew()
	 * @param C $c
	 * @return string «PAY-9R8XPLW1OJGK»
	 */
	function id($c) {return $c['id'];}

	/**
	 * 2017-06-12
	 * @override
	 * @see \Df\StripeClone\Facade\Charge::needPreorder()
	 * @used-by \Df\StripeClone\Method::chargeNew()
	 * @return bool
	 */
	function needPreorder() {return true;}

	/**
	 * 2017-06-13
	 * Returns the path to the bank card information
	 * in a charge converted to an array by @see \Dfe\Stripe\Facade\O::toArray()
	 * [Moip] An example of a response to «POST v2/orders/<order ID>/payments» https://mage2.pro/t/4048
	 * @override
	 * @see \Df\StripeClone\Facade\Charge::pathToCard()
	 * @used-by \Df\StripeClone\Block\Info::prepare()
	 * @return string
	 */
	function pathToCard() {return 'fundingInstrument/creditCard';}

	/**
	 * 2017-06-11
	 * @override
	 * @see \Df\StripeClone\Facade\Charge::refund()
	 * @used-by void
	 * @used-by \Df\StripeClone\Method::_refund()
	 * @param string $id
	 * @param float $a
	 * В формате и валюте платёжной системы.
	 * Значение готово для применения в запросе API.
	 * @return null
	 */
	function refund($id, $a) {return null;}

	/**
	 * 2017-06-11
	 * @override
	 * @see \Df\StripeClone\Facade\Charge::void()
	 * @used-by \Df\StripeClone\Method::_refund()
	 * @param string $id
	 * @return null
	 */
	function void($id) {return null;}

	/**
	 * 2017-06-11
	 * Информация о банковской карте.
	 * @override
	 * @see \Df\StripeClone\Facade\Charge::cardData()
	 * @used-by \Df\StripeClone\Facade\Charge::card()
	 * @param C $c
	 * @return \Stripe\Card
	 * @see \Dfe\Stripe\Facade\Customer::cardsData()
	 */
	protected function cardData($c) {return null;}
}