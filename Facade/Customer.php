<?php
namespace Dfe\Moip\Facade;
use Dfe\Moip\SDK\Customer as C;
// 2017-04-25
/** @method \Dfe\Moip\Method m() */
final class Customer extends \Df\StripeClone\Facade\Customer {
	/**
	 * 2017-04-25
	 * @override
	 * @see \Df\StripeClone\Facade\Customer::get()
	 * @used-by \Df\StripeClone\Facade\Customer::get()
	 * @param int $id
	 * @return C|null
	 */
	function _get($id) {return df_try(function() use($id) {return $this->api()->get($id);});}

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
	function create(array $p) {return $this->api()->createA($p);}

	/**
	 * 2017-04-25
	 * @override
	 * @see \Df\StripeClone\Facade\Customer::id()
	 * @used-by \Df\StripeClone\Charge::newCard()
	 * @param C $c
	 * @return string
	 */
	function id($c) {return $c->getId();}

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

	/**
	 * 2017-04-25
	 * @return C
	 */
	private function api() {return dfc($this, function() {return new C($this->m()->api());});}
}