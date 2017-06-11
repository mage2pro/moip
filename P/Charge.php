<?php
namespace Dfe\Moip\P;
use Dfe\Moip\SDK\Option;
// 2017-06-11
final class Charge extends \Df\StripeClone\P\Charge {
	/**
	 * 2017-06-11 Ключ, значением которого является токен банковской карты.
	 * https://github.com/mage2pro/moip/blob/0.4.4/T/CaseT/Payment.php#L46-L49
	 * @override
	 * @see \Df\StripeClone\P\Charge::k_CardId()
	 * @used-by \Df\StripeClone\P\Charge::request()
	 * @return string
	 */
	function k_CardId() {return 'fundingInstrument';}

	/**
	 * 2017-06-11
	 * @override
	 * @see \Df\StripeClone\P\Charge::v_CardId()
	 * @used-by \Dfe\Moip\P\Reg::v_CardId()
	 * @used-by \Df\StripeClone\P\Charge::request()
	 * @param string $id
	 * @param bool $isPrevious [optional]
	 * @return array(string => mixed)
	 */
	function v_CardId($id, $isPrevious = false) {return [
		// 2017-06-09
		// «Credit Card data. It can be:
		// *) the ID of a credit card previously saved,
		// *) an encrypted credit card hash
		// *) the whole collection of credit card attributes (in case you have PCI DSS certificate).»
		// [Moip] The test bank cards: https://mage2.pro/t/3776
		//
		// hash: «Encrypted credit card data»
		// Conditional, String.
		// https://dev.moip.com.br/v2.0/docs/criptografia
		//
		// id: «Credit card ID.
		// This ID can be used in the future to create new payments. Internal reference.»
		// Conditional, String(16).
		'creditCard' => [$isPrevious ? 'id' : 'hash' => $id]
		// 2017-06-09
		// «Method used. Possible values: CREDIT_CARD, BOLETO, ONLINE_BANK_DEBIT, WALLET»
		// Required, String.
		,'method' => Option::BANK_CARD
	];}

	/**
	 * 2017-06-11
	 * @override
	 * @see \Df\StripeClone\P\Charge::cardIdPrefix()
	 * @used-by \Df\StripeClone\P\Charge::usePreviousCard()
	 * @return string
	 */
	protected function cardIdPrefix() {return null;}

	/**
	 * 2017-06-11
	 * @override
	 * @see \Df\StripeClone\P\Charge::p()
	 * @used-by \Df\StripeClone\P\Charge::request()
	 * @return array(string => mixed)
	 */
	protected function p() {return [];}

	/**
	 * 2017-06-11
	 * https://github.com/mage2pro/moip/blob/0.4.2/T/CaseT/Payment.php#L50-L53
	 * @override
	 * @see \Df\StripeClone\P\Charge::k_DSD()
	 * @used-by \Df\StripeClone\P\Charge::request()
	 * @return string
	 */
	protected function k_DSD() {return 'statementDescriptor';}
}