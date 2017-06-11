<?php
namespace Dfe\Moip\Facade;
use Dfe\Moip\SDK\Payment as C;
use Magento\Sales\Model\Order\Creditmemo as CM;
use Magento\Sales\Model\Order\Payment as OP;
// 2017-06-11
final class Charge extends \Df\StripeClone\Facade\Charge {
	/**
	 * 2017-06-11
	 * @override
	 * @see \Df\StripeClone\Facade\Charge::capturePreauthorized()
	 * @used-by \Df\StripeClone\Method::charge()
	 * @param string $id
	 * @param int|float $a
	 * The $a value is already converted to the payment service provider currency
	 * and formatted according to the payment service provider requirements.
	 * @return C
	 */
	function capturePreauthorized($id, $a) {return null;}

	/**
	 * 2017-06-11
	 * @override
	 * @see \Df\StripeClone\Facade\Charge::create()
	 * @used-by \Df\StripeClone\Method::chargeNew()
	 * @param array(string => mixed) $p
	 * @return C
	 */
	function create(array $p) {return null;}

	/**
	 * 2017-06-11
	 * @override
	 * @see \Df\StripeClone\Facade\Charge::id()
	 * @used-by \Df\StripeClone\Method::chargeNew()
	 * @param C $c
	 * @return string
	 */
	function id($c) {return null;}

	/**
	 * 2017-06-11
	 * Returns the path to the bank card information
	 * in a charge converted to an array by @see \Dfe\Stripe\Facade\O::toArray()
	 * @override
	 * @see \Df\StripeClone\Facade\Charge::pathToCard()
	 * @used-by \Df\StripeClone\Block\Info::prepare()
	 * @return string
	 */
	function pathToCard() {return null;}

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