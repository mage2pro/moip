<?php
namespace Dfe\Moip\Test;
use Dfe\Moip\API\Option;
// 2017-06-10
final class Card {
	/**
	 * 2017-06-09
	 * «Payment method»
	 * @used-by \Dfe\Moip\Test\CaseT\Customer::pCustomer()
	 * @used-by \Dfe\Moip\Test\CaseT\Payment\Card::pPayment()
	 * @param int|string $index [optional]
	 * @return array(string => mixed)
	 */
	function get($index = 0) {return [
		// 2017-06-09
		// «Credit Card data. It can be:
		// *) the ID of a credit card previously saved,
		// *) an encrypted credit card hash
		// *) the whole collection of credit card attributes (in case you have PCI DSS certificate).»
		// [Moip] The test bank cards: https://mage2.pro/t/3776
		// 2017-06-13
		// A hash is a very long (345 symbols) base64-encoded string,
		// so it is very distinguishable from a card ID.
		// http://moip.github.io/moip-sdk-js
		// A card ID looks like «CRC-M423RWG3PK7J».
		'creditCard' => $this->card($index)
		// 2017-06-09
		// «Method used. Possible values: CREDIT_CARD, BOLETO, ONLINE_BANK_DEBIT, WALLET»
		// Required, String.
		,'method' => Option::BANK_CARD
	];}

	/**
	 * 2017-06-09
	 * «Payment method»
	 * @used-by pFundingInstrument()
	 * @param int|string $index
	 * @return array(string => mixed)
	 */
	private function card($index) {return df_clean([
		// 2017-06-09
		// «Do not send when the request is using credit card id»
		// Conditional, String.
		'holder' => [
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
		/**
		 * 2017-06-09
		 * «Credit card ID.
		 * This ID can be used in the future to create new payments. Internal reference.»
		 * Conditional, String(16).
		 * 2017-07-13
		 * Unable to pass a self-generated card ID here: 'id' => df_uid(6, 'admin@mage2.pro-')
		 * It will lead to the following response (which means «the credit card is not found»):
		 * 		{"errors":[{"code":"PAY-999","path":"","description":"Cartão de crédito não foi encontrado"}]}
		 * Instead of passing a self-generated ID you can get the Moip-generated ID from the response:
		 *	{
		 *		"id": "PAY-IVA2ASM6GTOC",
		 *		<...>
		 *		"fundingInstrument": {
		 *			"creditCard": {
		 *				"id": "CRC-3ITCTVLSEQKP",
		 *				"brand": "VISA",
		 *				"first6": "401200",
		 *				"last4": "1112",
		 *				"store": true,
		 *				"holder": <...>
		 *			},
		 *			"method": "CREDIT_CARD"
		 *		},
		 *		<...>
		 *	}
		 * https://mage2.pro/t/4048
		 */
		,'id' => null
		// 2017-06-09
		// Whether the card should be saved for future payments.
		// https://moip.com.br/blog/compra-com-um-clique
		// Default: true
		// Boolean.
		,'store' => true
	] + ('hash' === $index ? [
		// 2017-06-09
		// «Encrypted credit card data»
		// Conditional, String.
		// https://dev.moip.com.br/v2.0/docs/criptografia
		// 2017-07-14 You can generate a hash here: http://moip.github.io/moip-sdk-js
		'hash' => 'Q2qMJoavpsNCkF7FSA9pqg3lFFd1QTDWj7yA2tYRcwTbaFG9vWzU7lJcNyAkPKQ7BaSXhveZmNzNTbk7AcQ/nUlxqK8lt66HeLQhNyfy0f6wCf088Ys5IutbB/g/WK7hUDU3y3Ytn8q+h3QLg8NlbKCsveoaMncgqOXDj0If33WorzJB+yfSyCyEHb+dqwO+dJ8fX4fIGzMVMipJ902AbE+Cy/kuxA/ThBzgP247dXrwu3fjFdWRTRsCLO37X3dvZOVe+qjc/qUCvK1pEPQtW3jjCgYmCNX2jYdcu6h/EqXiCJvMnOJ3dXr1G/2Z0fdN2TcnJhhkRj61Me4LcMet3Q=='
	] : [
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
		// «Credit Card number. Requires PCI certification.»
		// Conditional, String(19).
		,'number' => self::$numbers[$index]
	]));}
	                                                    
	/** @return self */
	static function s() {static $r; return $r ? $r : $r = new self;}

	/**
	 * 2017-06-10 [Moip] The test bank cards https://mage2.pro/t/3776
	 * @var string[]
	 */
	private static $numbers = ['4012001037141112' , '5555666677778884', '376449047333005'
		,'36490102462661', '6362970000457013', '6370950000000005', '6062825624254001'
	];
}