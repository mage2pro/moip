<?php
namespace Dfe\Moip\Facade;
use \Df\Payment\BankCardNetworks as N;
// 2017-06-11 https://dev.moip.com.br/page/api-reference#section-credit-card
final class Card extends \Df\StripeClone\Facade\Card {
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
	 * @see \Df\StripeClone\Facade\Card::brand()
	 * @used-by \Df\StripeClone\CardFormatter::ii()
	 * @used-by \Dfe\Moip\CardFormatter::label()
	 * @return string
	 */
	function brand() {return dftr($this->brandId(), [
		self::$AMEX => 'American Express'
		,self::$DINERS => 'Diners Club'
		,self::$ELO => 'Elo'
		,self::$HIPER => 'Itaucard 2.0 (Cartão Hiper)'
		,self::$HIPERCARD => 'Hipercard'
		,self::$MASTERCARD => 'MasterCard'
		,self::$VISA => 'Visa'
	]);}

	/**
	 * 2017-06-11
	 * 2017-10-07 It should be an ISO-2 code or `null`.
	 * @override
	 * @see \Df\StripeClone\Facade\Card::country()
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
	 * @see \Df\StripeClone\Facade\Card::expMonth()
	 * @used-by \Df\StripeClone\CardFormatter::exp()
	 * @used-by \Df\StripeClone\CardFormatter::ii()
	 * @used-by \Df\StripeClone\Facade\Card::isActive()
	 * @return null
	 */
	function expMonth() {return null;}

	/**
	 * 2017-06-11
	 * 2017-07-19 Moip does not return the card's expiration date: https://mage2.pro/t/4048
	 * @override
	 * @see \Df\StripeClone\Facade\Card::expYear()
	 * @used-by \Df\StripeClone\CardFormatter::exp()
	 * @used-by \Df\StripeClone\CardFormatter::ii()
	 * @used-by \Df\StripeClone\Facade\Card::isActive()
	 * @return null
	 */
	function expYear() {return null;}

	/**
	 * 2017-07-19
	 * 2017-10-07 «First six digits of the card»
	 * Type: string.
	 * @used-by \Dfe\Moip\CardFormatter::label()
	 * @return string
	 */
	function first6() {return $this->_p['first6'];}

	/**
	 * 2017-06-11
	 * It returns a string like «CRC-3ITCTVLSEQKP»:
	 * https://github.com/mage2pro/moip/blob/0.4.1/Facade/Customer.php#L89
	 * 2017-10-07 «Credit card id»
	 * Type: string(16).
	 * @override
	 * @see \Df\StripeClone\Facade\Card::id()
	 * @used-by \Df\StripeClone\ConfigProvider::cards()
	 * @used-by \Df\StripeClone\Facade\Customer::cardIdForJustCreated()
	 * @return string
	 */
	function id() {return $this->_p['id'];}

	/**
	 * 2017-06-11
	 * 2017-10-07 «Last four digits of the card»
	 * Type: string.
	 * @override
	 * @see \Df\StripeClone\Facade\Card::last4()
	 * @used-by \Df\StripeClone\CardFormatter::ii()
	 * @used-by \Dfe\Moip\CardFormatter::label()
	 * @return string
	 */
	function last4() {return $this->_p['last4'];}

	/**
	 * 2017-07-19
	 * @used-by \Dfe\Moip\CardFormatter::label()
	 * @return string
	 */
	function logoId() {return dftr($this->brandId(), [
		self::$AMEX => N::American_Express
		,self::$DINERS => N::Diners_Club
		,self::$ELO => N::Elo
		,self::$HIPER => N::Hiper
		,self::$HIPERCARD => N::Hipercard
		,self::$MASTERCARD => N::MasterCard
		,self::$VISA => N::Visa
	]);}

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
	 * 2017-10-07
	 * `holder`: «Credit card holder». Type: structured.
	 * `fullname`: «Fullname». Type: string.
	 * @override
	 * @see \Df\StripeClone\Facade\Card::owner()
	 * @used-by \Df\StripeClone\CardFormatter::ii()
	 * @return string
	 */
	function owner() {return dfa_deep($this->_p, 'holder/fullname');}

	/**
	 * 2017-07-19
	 * 2017-10-07 «Credit card brand.
	 * Possible values: `VISA`, `MASTERCARD`, `AMEX`, `DINERS`, `ELO`, `HIPER`, `HIPERCARD`.»
	 * Type: string.
	 * @used-by brand()
	 * @used-by logoId()
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
	 * 2017-07-19
	 * @const
	 * @used-by brand()
	 * @used-by logoId()
	 * @used-by numberLength()
	 */
	private static $AMEX = 'AMEX';

	/**
	 * 2017-07-19
	 * @const
	 * @used-by brand()
	 * @used-by logoId()
	 * @used-by numberLength()
	 */
	private static $DINERS = 'DINERS';

	/**
	 * 2017-07-19
	 * @const
	 * @used-by brand()
	 * @used-by logoId()
	 */
	private static $ELO = 'ELO';

	/**
	 * 2017-07-19
	 * @const
	 * @used-by brand()
	 * @used-by logoId()
	 */
	private static $HIPER = 'HIPER';

	/**
	 * 2017-07-19
	 * @const
	 * @used-by brand()
	 * @used-by logoId()
	 */
	private static $HIPERCARD = 'HIPERCARD';

	/**
	 * 2017-07-19
	 * @const
	 * @used-by brand()
	 * @used-by logoId()
	 */
	private static $MASTERCARD = 'MASTERCARD';

	/**
	 * 2017-07-19
	 * @const
	 * @used-by brand()
	 * @used-by logoId()
	 */
	private static $VISA = 'VISA';
}