<?php
namespace Dfe\Moip\Facade;
use Df\API\Operation;
use Dfe\Moip\API\Facade\Order as O;
# 2017-06-11
/** @method O preorderGet() */
final class Charge extends \Df\StripeClone\Facade\Charge {
	/**
	 * 2017-06-11
	 * @override
	 * @see \Df\StripeClone\Facade\Charge::capturePreauthorized()
	 * @used-by \Df\StripeClone\Method::charge()
	 * @param int|float $a
	 * The $a value is already converted to the PSP currency and formatted according to the PSP requirements.
	 * @return null
	 */
	function capturePreauthorized(string $id, $a) {return null;}

	/**
	 * 2017-06-13 [Moip] An example of a response to «POST v2/orders/<order ID>/payments» https://mage2.pro/t/4048
	 * @override
	 * @see \Df\StripeClone\Facade\Charge::create()
	 * @used-by \Df\StripeClone\Method::chargeNew()
	 * @param array(string => mixed) $p
	 */
	function create(array $p):Operation {return O::s()->payment($this->preorderGet()['id'], $p);}

	/**
	 * 2017-06-13
	 * [Moip] An example of a response to «POST v2/orders/<order ID>/payments» https://mage2.pro/t/4048
	 * A result: «PAY-9R8XPLW1OJGK».
	 * 2022-12-19 We can not declare the argument's type because it is undeclared in the overriden method
	 * @override
	 * @see \Df\StripeClone\Facade\Charge::id()
	 * @used-by \Df\StripeClone\Method::chargeNew()
	 * @param Operation $c
	 */
	function id($c):string {return $c['id'];}

	/**
	 * 2017-06-12
	 * @override
	 * @see \Df\StripeClone\Facade\Charge::needPreorder()
	 * @used-by \Df\StripeClone\Method::chargeNew()
	 */
	function needPreorder():bool {return true;}

	/**
	 * 2017-06-13
	 * Returns the path to the bank card information
	 * in a charge converted to an array by @see \Dfe\Stripe\Facade\O::toArray()
	 * [Moip] An example of a response to «POST v2/orders/<order ID>/payments» https://mage2.pro/t/4048
	 * @override
	 * @see \Df\StripeClone\Facade\Charge::pathToCard()
	 * @used-by \Df\StripeClone\Block\Info::cardDataFromChargeResponse()
	 * @used-by \Df\StripeClone\Facade\Charge::cardData()
	 */
	function pathToCard():string {return 'fundingInstrument/creditCard';}

	/**
	 * 2017-06-11
	 * 2022-12-19 The $a value is already converted to the PSP currency and formatted according to the PSP requirements.
	 * @override
	 * @see \Df\StripeClone\Facade\Charge::refund()
	 * @used-by \Df\StripeClone\Method::_refund()
	 * @return null
	 */
	function refund(string $id, int $a) {return null;}

	/**
	 * 2017-06-11
	 * @override
	 * @see \Df\StripeClone\Facade\Charge::void()
	 * @used-by \Df\StripeClone\Method::_refund()
	 * @return null
	 */
	function void(string $id) {return null;}

	/**
	 * 2017-06-12
	 * [Moip] An example of a response to «POST v2/customers/<customer ID>/fundinginstruments»
	 * https://mage2.pro/t/4050
	 * A card ID looks like «CRC-M423RWG3PK7J».
	 * https://github.com/mage2pro/moip/blob/0.4.6/Facade/Card.php#L10
	 * 2017-06-13
	 * A hash is a very long (345 symbols) base64-encoded string,
	 * so it is very distinguishable from a card ID.
	 * http://moip.github.io/moip-sdk-js
	 * @override
	 * @see \Df\StripeClone\Facade\Charge::cardIdPrefix()
	 * @used-by \Df\StripeClone\Payer::tokenIsNew()
	 */
	protected function cardIdPrefix():string {return 'CRC-';}
}