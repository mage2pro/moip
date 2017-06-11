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
	 * @used-by \Df\StripeClone\CardFormatter::label()
	 * @return string
	 */
	function brand() {return dftr($this->_p['brand'], [
		'AMEX' => 'American Express'
		,'DINERS' => 'Diners Club'
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
	function country() {return in_array($this->_p['brand'], ['ELO', 'HIPER', 'HIPERCARD']) ? 'BR' : null;}

	/**
	 * 2017-06-11
	 * @override
	 * @see \Df\StripeClone\Facade\ICard::expMonth()
	 * @used-by \Df\StripeClone\CardFormatter::exp()
	 * @used-by \Df\StripeClone\CardFormatter::ii()
	 * @return null
	 */
	function expMonth() {return null;}

	/**
	 * 2017-06-11
	 * @override
	 * @see \Df\StripeClone\Facade\ICard::expYear()
	 * @used-by \Df\StripeClone\CardFormatter::exp()
	 * @used-by \Df\StripeClone\CardFormatter::ii()
	 * @return null
	 */
	function expYear() {return null;}

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
	 * @used-by \Df\StripeClone\CardFormatter::label()
	 * @return string
	 */
	function last4() {return $this->_p['last4'];}

	/**
	 * 2017-06-11
	 * 2017-02-16: https://github.com/mage2pro/stripe/issues/2
	 * @override
	 * @see \Df\StripeClone\Facade\ICard::owner()
	 * @used-by \Df\StripeClone\CardFormatter::ii()
	 * @return null
	 */
	function owner() {return null;}

	/**
	 * 2017-06-11
	 * @var array(string => string)
	 */
	private $_p;
}