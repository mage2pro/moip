<?php
namespace Dfe\Moip\Facade;
use Df\API\Operation;
use Dfe\Moip\API\Facade\Customer as C;
use Dfe\Moip\API\Option;
use Dfe\Moip\Facade\Card;
# 2017-04-25
final class Customer extends \Df\StripeClone\Facade\Customer {
	/**
	 * 2017-04-25 A result: «CRC-M423RWG3PK7J».
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
	 * 2017-07-16
	 * Unable to use a card hash here:
	 * `A «POST /v2/customers/<customer ID>/fundinginstruments» request
	 * with a bank card hash as a «fundingInstruments» parameter
	 * leads to an undocumented «{"ERROR": "Ops... We were not waiting for it"}» response
	 * with «500 Internal Server Error» HTTP code`: https://mage2.pro/t/4175
	 * So we just return a token, like Spryng:
	 * @see \Dfe\Spryng\Facade\Customer::cardAdd()
	 * https://github.com/mage2pro/spryng/blob/1.1.10/Facade/Customer.php#L18-L27
	 * The previous version of the method:
	 * https://github.com/mage2pro/moip/blob/0.7.1/Facade/Customer.php#L44-L61
	 * 2022-12-19 We can not declare the $c argument type because it is undeclared in the overriden method.
	 * @override
	 * @see \Df\StripeClone\Facade\Customer::cardAdd()
	 * @used-by \Df\StripeClone\Payer::newCard()
	 * @param Operation $c
	 */
	function cardAdd($c, string $token):string {return $token;}

	/**
	 * 2017-04-25
	 * @override
	 * @see \Df\StripeClone\Facade\Customer::create()
	 * @used-by \Df\StripeClone\Payer::newCard()
	 * @param array(string => mixed) $p
	 */
	function create(array $p):Operation {return C::s()->create($p);}

	/**
	 * 2017-04-25 «CUS-18QQ3DF4BIKY»
	 * @override
	 * @see \Df\StripeClone\Facade\Customer::id()
	 * @used-by \Df\StripeClone\Payer::newCard()
	 * @param Operation $c
	 */
	function id($c):string {return $c['id'];}

	/**
	 * 2017-04-25
	 * @override
	 * @see \Df\StripeClone\Facade\Customer::_get()
	 * @used-by \Df\StripeClone\Facade\Customer::get()
	 * @param string $id
	 * @return Operation|null
	 */
	protected function _get($id) {return df_try(function() use($id) {return C::s()->get($id);});}

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
	 * @return Card[]
	 * @see \Dfe\Stripe\Facade\Charge::cardData()
	 */
	protected function cardsData($c) {return array_map(
		function(array $i) {return $i['creditCard'];}
		,array_filter(
			df_eta($c['fundingInstruments'])
			, function(array $i) {return Option::BANK_CARD === $i['method'];}
		)
	);}
}