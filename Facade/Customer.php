<?php
namespace Dfe\Moip\Facade;
use Moip\Resource\Customer as C;
// 2017-04-25
final class Customer extends \Df\StripeClone\Facade\Customer {
	/**
	 * 2017-04-25
	 * @override
	 * @see \Df\StripeClone\Facade\Customer::get()
	 * @used-by \Df\StripeClone\Facade\Customer::get()
	 * @param int $id
	 * @return C|null
	 */
	function _get($id) {/** @var C $c */return null;}

	/**
	 * 2017-04-25
	 * @override
	 * @see \Df\StripeClone\Facade\Customer::cardAdd()
	 * @used-by \Df\StripeClone\Charge::newCard()
	 * @param C $c
	 * @param string $token
	 * @return string
	 */
	function cardAdd($c, $token) {return null;}

	/**
	 * 2017-04-25
	 * @override
	 * @see \Df\StripeClone\Facade\Customer::create()
	 * @used-by \Df\StripeClone\Charge::newCard()
	 * @param array(string => mixed) $p
	 * @return C
	 */
	function create(array $p) {return null;}

	/**
	 * 2017-04-25
	 * @override
	 * @see \Df\StripeClone\Facade\Customer::id()
	 * @used-by \Df\StripeClone\Charge::newCard()
	 * @param C $c
	 * @return string
	 */
	function id($c) {return null;}

	/**
	 * 2017-04-25
	 * @override
	 * @see \Df\StripeClone\Facade\Customer::cardsData()
	 * @used-by \Df\StripeClone\Facade\Customer::cards()
	 * @param C $c
	 * @return \Stripe\Card[]
	 * @see \Dfe\Stripe\Facade\Charge::cardData()
	 */
	protected function cardsData($c) {return null;}
}