<?php
namespace Dfe\Moip\P;
// 2017-06-11
/** @method Charge charge() */
final class Reg extends \Df\StripeClone\P\Reg {
	/**
	 * 2017-06-10
	 * This option is undocumented in the Portuguese documentation:
	 * But it is mentioned in the English documentation:
	 * https://dev.moip.com.br/page/api-reference#section-create-a-customer-post-
	 * 2017-06-11
	 * Ключ, значением которого является токен банковской карты.
	 * Этот ключ передаётся как параметр в запросе на сохранение банковской карты
	 * для будущего повторного использования при регистрации нового покупателя.
	 * https://github.com/mage2pro/moip/blob/0.4.5/T/CaseT/Customer.php#L106-L110
	 * @override
	 * @see \Df\StripeClone\P\Reg::k_CardId()
	 * @used-by \Df\StripeClone\P\Reg::request()
	 * @return string
	 */
	protected function k_CardId() {return 'fundingInstruments';}

	/**
	 * 2017-06-12
	 * @override
	 * @see \Df\StripeClone\P\Reg::p()
	 * @used-by \Df\StripeClone\P\Reg::request()
	 * @return array(string => mixed)
	 */
	protected function p() {return df_clean([
		// 2017-04-22 «Client's date of birth», Date (YYYY-MM-DD), Optional.
		'birthDate' => '1982-07-08'
		// 2017-04-22 «Email from the client», Required, String(45).
		,'email' => $this->customerEmail()
		// 2017-04-22 «Full name of customer», Required, String(90).
		,'fullname' => 'Dmitry Fedyuk'
		// 2017-06-10
		// This option is undocumented in the Portuguese documentation:
		// But it is mentioned in the English documentation:
		// https://dev.moip.com.br/page/api-reference#section-create-a-customer-post-
		,'fundingInstruments' => [$this->pFundingInstrument()]
		// 2017-04-22
		// «Customer Id. External reference.»
		// Required, String(66).
		// It should be unique, otherwise you will get the error:
		// «O identificador prßprio deve ser único, j¹ existe um customer com o identificador informado»
		// («The unique identifier must be unique, there is a customer with the identified identifier»).
		,'ownId' => !in_array($r = $this->customerEmail(), ['admin@mage2.pro', 'dfeduuk@gmail.com']) ? $r :
			df_uid(4, "$r-")
		// 2017-04-23
		// «The Address is the set of data that represents a location:
		// *) associated with the Customer as the delivery address («shippingAddress»)
		// 	*) or associated with the Credit Card as the billing address («billingAddress»).»
		// https://dev.moip.com.br/v2.0/reference#endereco
		,'shippingAddress' => $this->pShippingAddress()
		// 2017-04-25 «Fiscal document», Optional, Structured.
		,'taxDocument' => $this->pTaxDocument()
	// 2017-04-22 «Customer's phone number», Optional, Structured.
	// 2017-04-25
	// «Today we do not support creating clients that are from other countries
	// that are not from Brazil, so this error occurs.
	// We do not have a forecast to be international.»
	// https://mage2.pro/t/3820/2
	]) + dfe_moip_phone('+552131398000');}
	/**
	 * 2017-06-11 https://github.com/mage2pro/moip/blob/0.4.4/T/CaseT/Customer.php#L106-L110
	 * @override
	 * @see \Df\StripeClone\P\Reg::v_CardId()
	 * @used-by \Df\StripeClone\P\Reg::request()
	 * @param string $id
	 * @return array(array(string => mixed))
	 */
	protected function v_CardId($id) {return [$this->charge()->v_CardId($id)];}

	/**
	 * 2017-06-12
	 * @used-by p()
	 * @return array(string => mixed)
	 */
	private function pFundingInstrument() {return [];}

	/**
	 * 2017-06-12
	 * @used-by p()
	 * @return array(string => mixed)
	 */
	private function pShippingAddress() {return [];}

	/**
	 * 2017-06-12
	 * @used-by p()
	 * @return array(string => mixed)
	 */
	private function pTaxDocument() {return [];}
}