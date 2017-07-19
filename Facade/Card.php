<?php
namespace Dfe\Moip\Facade;
// 2017-06-11
// https://dev.moip.com.br/page/api-reference#section-credit-card
final class Card implements \Df\StripeClone\Facade\ICard {
	/**
	 * 2017-06-11
	 * $p is an array like:
	 *	{
	 *		"id": "CRC-M423RWG3PK7J",
	 *		"brand": "MASTERCARD",
	 *		"first6": "555566",
	 *		"last4": "8884",
	 *		"store": true
	 *	}
	 * 2017-06-13
	 * [Moip] An example of a response to «POST v2/orders/<order ID>/payments» https://mage2.pro/t/4048
	 *	{
	 *		"id": "CRC-3ITCTVLSEQKP",
	 *		"brand": "VISA",
	 *		"first6": "401200",
	 *		"last4": "1112",
	 *		"store": true,
	 *		"holder": {
	 * 			"birthdate": "1982-07-08",
	 *			"birthDate": "1982-07-08",
	 *			"taxDocument": {
	 *				"type": "CPF",
	 *				"number": "22222222222"
	 *			},
	 *			"billingAddress": {
	 *				"street": "Avenida Lúcio Costa",
	 *				"streetNumber": "3150",
	 *				"complement": "",
	 *				"district": "Barra da Tijuca",
	 *				"city": "Rio de Janeiro",
	 *				"state": "RJ",
	 *				"country": "BRA",
	 *				"zipCode": "22630-010"
	 *			},
	 *			"fullname": "DMITRY FEDYUK"
	 *		}
	 * @see \Dfe\Moip\Facade\Customer::cardAdd()
	 * https://github.com/mage2pro/moip/blob/0.4.1/Facade/Customer.php#L88-L94
	 * @used-by \Df\StripeClone\Facade\Card::create()
	 * @param array(string => string) $p
	 */
	function __construct($p) {$this->_p = $p;}

	/**
	 * 2017-06-11
	 * https://dev.moip.com.br/page/api-reference#section-credit-card
	 * https://mage2.pro/t/3776
	 * https://github.com/mage2pro/moip/blob/0.4.1/Facade/Customer.php#L90
	 * @override
	 * @see \Df\StripeClone\Facade\ICard::brand()
	 * @used-by \Df\StripeClone\CardFormatter::ii()
	 * @used-by \Dfe\Moip\CardFormatter::label()
	 * @return string
	 */
	function brand() {return dftr($this->brandId(), [
		self::$AMEX => 'American Express'
		,self::$DINERS => 'Diners Club'
		,'ELO' => 'Elo'
		,'HIPER' => 'Itaucard 2.0 (Cartão Hiper)'
		,'HIPERCARD' => 'Hipercard'
		,'MASTERCARD' => 'MasterCard'
		,'VISA' => 'Visa'
	]);}

	/**
	 * 2017-06-11
	 * @override
	 * @see \Df\StripeClone\Facade\ICard::country()
	 * @used-by \Df\StripeClone\CardFormatter::country()
	 * @return string|null
	 */
	function country() {return in_array($this->_p['brand'], ['ELO', 'HIPER', 'HIPERCARD']) ? 'BR' :
		(!($iso3 = dfa_deep($this->_p, 'holder/billingAddress/country')) ? null :
			df_country_3_to_2($iso3)
		)
	;}

	/**
	 * 2017-06-11
	 * 2017-07-19 Moip does not return the expiration date: https://mage2.pro/t/4048
	 * @override
	 * @see \Df\StripeClone\Facade\ICard::expMonth()
	 * @used-by \Df\StripeClone\CardFormatter::exp()
	 * @used-by \Df\StripeClone\CardFormatter::ii()
	 * @return null
	 */
	function expMonth() {return null;}

	/**
	 * 2017-06-11
	 * 2017-07-19 Moip does not return the card's expiration date: https://mage2.pro/t/4048
	 * @override
	 * @see \Df\StripeClone\Facade\ICard::expYear()
	 * @used-by \Df\StripeClone\CardFormatter::exp()
	 * @used-by \Df\StripeClone\CardFormatter::ii()
	 * @return null
	 */
	function expYear() {return null;}

	/**
	 * 2017-07-19
	 * @used-by \Dfe\Moip\CardFormatter::label()
	 * @return string
	 */
	function first6() {return $this->_p['first6'];}

	/**
	 * 2017-06-11
	 * It returns a string like «CRC-3ITCTVLSEQKP»:
	 * https://github.com/mage2pro/moip/blob/0.4.1/Facade/Customer.php#L89
	 * @override
	 * @see \Df\StripeClone\Facade\ICard::id()
	 * @used-by \Df\StripeClone\ConfigProvider::cards()
	 * @used-by \Df\StripeClone\Facade\Customer::cardIdForJustCreated()
	 * @return string
	 */
	function id() {return $this->_p['id'];}

	/**
	 * 2017-06-11
	 * @override
	 * @see \Df\StripeClone\Facade\ICard::last4()
	 * @used-by \Df\StripeClone\CardFormatter::ii()
	 * @used-by \Dfe\Moip\CardFormatter::label()
	 * @return string
	 */
	function last4() {return $this->_p['last4'];}

	/**
	 * 2017-07-19
	 * The Brazilian bank card numbers have the following lengths:
	 * 	*) 15: (Diners Club International), 16 or 17 digits:
	 * 	*) 16: (American Express)
	 *	*) 17: All the others (Visa, MasterCard, Elo, Itaucard 2.0 (Cartão Hiper), Hipercard).
	 * https://mage2.pro/t/3776
	 * @used-by \Dfe\Moip\CardFormatter::label()
	 * @return int
	 */
	function numberLength() {/** @var string $b */ $b = $this->brandId(); return
		($r = dftr($b, [self::$AMEX => 16, self::$DINERS => 15])) === $b ? 17 : $r
	;}

	/**
	 * 2017-06-13
	 * @override
	 * @see \Df\StripeClone\Facade\ICard::owner()
	 * @used-by \Df\StripeClone\CardFormatter::ii()
	 * @return string
	 */
	function owner() {return dfa_deep($this->_p, 'holder/fullname');}

	/**
	 * 2017-07-17
	 * @used-by brand()
	 * @used-by numberLength()
	 * @return string
	 */
	private function brandId() {return $this->_p['brand'];}

	/**
	 * 2017-06-11
	 * @var array(string => string)
	 */
	private $_p;

	/**
	 * 2017-07-17
	 * @const
	 * @used-by brand()
	 * @used-by numberLength()
	 */
	private static $AMEX = 'AMEX';
	/**
	 * 2017-07-17
	 * @const
	 * @used-by brand()
	 * @used-by numberLength()
	 */
	private static $DINERS = 'DINERS';
}