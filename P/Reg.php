<?php
namespace Dfe\Moip\P;
use Dfe\Moip\Method as M;
use Dfe\Moip\Settings as S;
use Geocoder\Model\Address as GA;
use Magento\Sales\Model\Order\Address as A;
/**
 * 2017-06-11
 * @method Charge charge()
 * @method M m()
 * @method S s()
 */
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
	 * 2017-07-16
	 * Note 1.
	 * I was unable to get it to work:
	 * `A «POST /v2/customers» request with a bank card hash as a «fundingInstruments» parameter
	 * leads to an undocumented «{"ERROR": "Ops... We were not waiting for it"}» response`:
	 * https://mage2.pro/t/4174
	 * https://suporte.moip.com.br/hc/pt-br/requests/1458451
	 * @see \Dfe\Moip\T\CaseT\Customer::pCustomer()
	 * https://github.com/mage2pro/moip/blob/0.7.0/T/CaseT/Customer.php#L94-#L106
	 * @see \Df\StripeClone\Payer::newCard()
	 * https://github.com/mage2pro/core/blob/2.8.19/StripeClone/Payer.php#L103-L109
	 * Note 2.
	 * There is a similar error on `POST /v2/customers/<customer ID>/fundinginstruments`:
	 * @see \Dfe\Moip\T\CaseT\Card::t01_add()
	 * https://github.com/mage2pro/moip/blob/0.7.1/T/CaseT/Card.php#L17-L23
	 * @override
	 * @see \Df\StripeClone\P\Reg::k_CardId()
	 * @used-by \Df\StripeClone\P\Reg::request()
	 * @return string
	 */
	protected function k_CardId() {return null; /* 'fundingInstruments' */}

	/**
	 * 2017-06-12
	 * @override
	 * @see \Df\StripeClone\P\Reg::p()
	 * @used-by \Df\StripeClone\P\Reg::request()
	 * @return array(string => mixed)
	 */
	protected function p() {return df_clean([
		// 2017-04-22 «Client's date of birth», Date (YYYY-MM-DD), Optional.
		'birthDate' => $this->customerDobS()
		// 2017-04-22 «Email from the client», Required, String(45).
		,'email' => $this->customerEmail()
		// 2017-04-22 «Full name of customer», Required, String(90).
		,'fullname' => $this->customerName()
		// 2017-04-22
		// «Customer Id. External reference.»
		// Required, String(66).
		// It should be unique, otherwise you will get the error:
		// «O identificador prßprio deve ser único, j¹ existe um customer com o identificador informado»
		// («The unique identifier must be unique, there is a customer with the identified identifier»).
		,'ownId' => !in_array($r = $this->customerEmail(), ['admin@mage2.pro', 'dfediuk@gmail.com']) ? $r :
			df_uid(6, "$r-")
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
	]) + dfe_moip_phone($this->addressBS()->getTelephone());}

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
	 * 2017-04-25
	 * @used-by pShippingAddress()
	 * @return GA
	 */
	private function ga() {return dfc($this, function() {/** @var A $a */$a = $this->addressS(); return
		df_geo($this->s()->googlePrivateKey(), 'pt-BR', 'br')->geocode(df_csv_pretty(
			$a->getStreet(), $a->getCity(), $a->getRegion() ,$a->getPostcode()
		))->first()
	;});}

	/**
	 * 2017-04-25
	 * «The Address is the set of data that represents a location:
	 * 	*) associated with the Customer as the delivery address («shippingAddress»)
	 * 	*) or associated with the Credit Card as the billing address («billingAddress»).»
	 * https://dev.moip.com.br/v2.0/reference#endereco
	 * @used-by p()
	 * @return array(string => mixed)
	 */
	private function pShippingAddress() {/** @var GA $ga */$ga = $this->ga(); return [
		// 2017-04-23 «City», Required, String(32).
		'city' => self::u(df_geo_city($ga))
		// 2017-04-23 «Address complement», Conditional, String(45).
		,'complement' => ''
		// 2017-04-23 «Country in format ISO-alpha3, example BRA», Required, String(3).
		// 2017-04-25
		// «Today we do not support creating clients that are from other countries
		// that are not from Brazil, so this error occurs.
		// We do not have a forecast to be international.»
		// https://mage2.pro/t/3820/2
		,'country' => df_country_2_to_3('BR')
		// 2017-04-23 «Neighborhood», Required, String(45).
		,'district' => self::u($ga->getLocality() ?: $ga->getSubLocality())
		// 2017-04-23 «State», Required, String(32).
		,'state' => self::u(df_geo_state_code($ga))
		// 2017-04-25 «Address post office», Required, String(45).
		,'street' => self::u($ga->getStreetName())
		// 2017-04-23 «Number», Required, String(10).
		,'streetNumber' => self::u($ga->getStreetNumber())
		// 2017-04-23 «The zip code of the billing address», Required, String(9).
		,'zipCode' => $ga->getPostalCode()
	];}

	/**
	 * 2017-06-12
	 * @see \Dfe\Moip\T\Data::taxDocument()
	 * @used-by p()
	 * @return array(string => mixed)
	 */
	private function pTaxDocument() {return [
		// 2017-04-23 «Document number»,  String(11).
		'number' => $this->m()->taxID()
		// 2017-04-23
		// «Document type. Possible values:
		// *) CPF for social security number
		// *) CNPJ for tax identification number.»
		// String(4).
		// 2017-06-13
		// CPF: Cadastro de Pessoas Físicas (an individual's ID)
		// https://en.wikipedia.org/wiki/Cadastro_de_Pessoas_Físicas
		// CNPJ: Cadastro Nacional da Pessoa Jurídica (a company's ID)
		// https://en.wikipedia.org/wiki/CNPJ
		,'type' => 'CPF'
	];}

	/**
	 * 2017-04-25
	 * @used-by pShippingAddress()
	 * @param mixed $v
	 * @return string
	 */
	private static function u($v) {return $v ?: (string)__('Unknown');}
}