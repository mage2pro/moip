<?php
namespace Dfe\Moip\Facade;
use Dfe\Moip\SDK\Customer as C;
use Moip\Moip as API;
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
	function _get($id) {return df_try(function() use($id) {return null;});}

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
	function create(array $p) {return C::create($this->api(), $p);}

	/**
	 * 2017-04-25 «CUS-18QQ3DF4BIKY»
	 * @override
	 * @see \Df\StripeClone\Facade\Customer::id()
	 * @used-by \Df\StripeClone\Charge::newCard()
	 * @param C $c
	 * @return string
	 */
	function id($c) {return $c['id'];}

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
	 * @return API
	 */
	private function api() {return $this->m()->api();}
}