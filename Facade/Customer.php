<?php
namespace Dfe\Moip\Facade;
use Dfe\Moip\SDK\Customer as C;
use Dfe\Moip\SDK\Option;
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
	function _get($id) {return df_try(function() use($id) {return C::get($id);});}

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
	function create(array $p) {return C::create($p);}

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
	 * 2017-06-10
	 * The «fundingInstruments» key contains an array like:
	 *	"fundingInstruments": [
	 *		{
	 *			"creditCard": {
	 *				"id": "CRC-3ITCTVLSEQKP",
	 *				"brand": "VISA",
	 *				"first6": "401200",
	 *				"last4": "1112",
	 *				"store": true
	 *			},
	 *			"method": "CREDIT_CARD"
	 *		}
	 *	]
	 * [Moip] An example of a response to «GET v2/customers/<customer ID>» https://mage2.pro/t/4049
	 * The «fundingInstruments» key can be absent: https://mage2.pro/t/3813
	 * The method returns an array like:
	 * [
	 * 		[
	 *			"id": "CRC-3ITCTVLSEQKP",
	 *			"brand": "VISA",
	 *			"first6": "401200",
	 *			"last4": "1112",
	 *			"store": true
	 * 		]
	 * ]
	 * @override
	 * @see \Df\StripeClone\Facade\Customer::cardsData()
	 * @used-by \Df\StripeClone\Facade\Customer::cards()
	 * @param C $c
	 * @return \Stripe\Card[]
	 * @see \Dfe\Stripe\Facade\Charge::cardData()
	 */
	protected function cardsData($c) {return array_map(
		function(array $i) {return $i['creditCard'];}
		,array_filter(
			df_eta($c['fundingInstruments'])
			,function(array $i) {return Option::BANK_CARD === $i['method'];}
		)
	);}
}