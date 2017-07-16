<?php
namespace Dfe\Moip\Facade;
use Df\API\Operation;
use Dfe\Moip\API\Facade\Customer as C;
use Dfe\Moip\API\Option;
// 2017-04-25
final class Customer extends \Df\StripeClone\Facade\Customer {
	/**
	 * 2017-04-25
	 * @override
	 * @see \Df\StripeClone\Facade\Customer::get()
	 * @used-by \Df\StripeClone\Facade\Customer::get()
	 * @param int $id
	 * @return Operation|null
	 */
	function _get($id) {return df_try(function() use($id) {return C::s()->get($id);});}

	/**
	 * 2017-04-25
	 * 2017-06-10
	 * [Moip] An example of a response to «POST v2/customers/<customer ID>/fundinginstruments»
	 * https://mage2.pro/t/4050
	 *	{
	 *		"creditCard": {
	 *			"id": "CRC-M423RWG3PK7J",
	 *			"brand": "MASTERCARD",
	 *			"first6": "555566",
	 *			"last4": "8884",
	 *			"store": true
	 *		},
	 *		"card": {
	 *			"brand": "MASTERCARD",
	 *			"store": true
	 *		},
	 *		"method": "CREDIT_CARD"
	 *	}
	 * @override
	 * @see \Df\StripeClone\Facade\Customer::cardAdd()
	 * @used-by \Df\StripeClone\Payer::newCard()
	 * @param Operation $c
	 * @param string $token
	 * @return string	An example: «CRC-M423RWG3PK7J».
	 */
	function cardAdd($c, $token) {return C::s()->addCard($this->id($c), [
		// 2017-06-09
		// «Credit Card data. It can be:
		// *) the ID of a credit card previously saved,
		// *) an encrypted credit card hash
		// *) the whole collection of credit card attributes (in case you have PCI DSS certificate).»
		// [Moip] The test bank cards: https://mage2.pro/t/3776
		'creditCard' => [
			// 2017-06-10
			// «Encrypted credit card data»
			// Conditional, String.
			'hash' => $token
		]
		// 2017-06-09
		// «Method used. Possible values: CREDIT_CARD, BOLETO, ONLINE_BANK_DEBIT, WALLET»
		// Required, String.
		,'method' => Option::BANK_CARD
	])['creditCard/id'];}

	/**
	 * 2017-04-25
	 * @override
	 * @see \Df\StripeClone\Facade\Customer::create()
	 * @used-by \Df\StripeClone\Payer::newCard()
	 * @param array(string => mixed) $p
	 * @return Operation
	 */
	function create(array $p) {return C::s()->create($p);}

	/**
	 * 2017-04-25 «CUS-18QQ3DF4BIKY»
	 * @override
	 * @see \Df\StripeClone\Facade\Customer::id()
	 * @used-by \Df\StripeClone\Payer::newCard()
	 * @param Operation $c
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