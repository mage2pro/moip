<?php
namespace Dfe\Moip\T;
use Dfe\Moip\SDK\Option;
// 2017-06-10
final class Card {
	/**
	 * 2017-06-09
	 * «Payment method»
	 * @used-by \Dfe\Moip\T\CaseT\Customer::pCustomer()
	 * @used-by \Dfe\Moip\T\CaseT\Payment::pPayment()
	 * @return array(string => mixed)
	 */
	function get() {return [
		// 2017-06-09
		// «Credit Card data. It can be:
		// *) the ID of a credit card previously saved,
		// *) an encrypted credit card hash
		// *) the whole collection of credit card attributes (in case you have PCI DSS certificate).»
		// [Moip] The test bank cards: https://mage2.pro/t/3776
		'creditCard' => $this->pFundingInstrument_creditCard()
		// 2017-06-09
		// «Method used. Possible values: CREDIT_CARD, BOLETO, ONLINE_BANK_DEBIT, WALLET»
		// Required, String.
		,'method' => Option::BANK_CARD
	];}

	/**
	 * 2017-06-09
	 * «Payment method»
	 * @used-by pFundingInstrument()
	 * @return array(string => mixed)
	 */
	private function pFundingInstrument_creditCard() {return [
		// 2017-06-09
		// «Credit card security code.»
		// Conditional, Integer.
		'cvc' => 123
		// 2017-06-09
		// «Credit card expiration month. Requires PCI certification.»
		// Conditional, Integer(2).
		,'expirationMonth' => 5
		// 2017-06-09
		// «Credit card expiration year. Requires PCI certification.»
		// Conditional, Integer(4).
		,'expirationYear' => 2018
		// 2017-06-09
		// «Encrypted credit card data»
		// Conditional, String.
		// https://dev.moip.com.br/v2.0/docs/criptografia
		//,'hash' => ''
		// 2017-06-09
		// «Do not send when the request is using credit card id»
		// Conditional, String.
		,'holder' => [
			// 2017-06-09
			// «Billing address»
			// Optional.
			'billingAddress' => Data::s()->address()
			// 2017-06-09
			// «date(AAAA-MM-DD)»
			// Required.
			,'birthdate' => '1982-07-08'
			// 2017-06-09
			// «Name of the carrier printed on the card»
			// Required, String(90).
			,'fullname' => 'DMITRY FEDYUK'
			// 2017-06-09
			// «Phone number»
			// It is required for the Protected Sales Program:
			// https://dev.moip.com.br/v2.0/docs/venda-protegida
			,'phone' => Data::s()->phone()
			// 2017-06-09 «Document»
			,'taxDocument' => Data::s()->taxDocument()
		]
		// 2017-06-09
		// «Credit card ID.
		// This ID can be used in the future to create new payments. Internal reference.»
		// Conditional, String(16).
		//,'id' => ''
		// 2017-06-09
		// «Credit Card number. Requires PCI certification.»
		// Conditional, String(19).
		,'number' => '4012001037141112'
		// 2017-06-09
		// Whether the card should be saved for future payments.
		// https://moip.com.br/blog/compra-com-um-clique
		// Default: true
		// Boolean.
		,'store' => true
	];}

	/** @return self */
	public static function s() {static $r; return $r ? $r : $r = new self;}
}