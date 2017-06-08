<?php
namespace Dfe\Moip\T;
use Dfe\Moip\SDK\Customer as C;
use Geocoder\Model\Address as GA;
use Moip\Exceptions\UnautorizedException as leUnautorized;
use Moip\Exceptions\UnexpectedException as leUnexpected;
use Moip\Exceptions\ValidationException as leValidation;
// 2017-04-20
// https://dev.moip.com.br/page/api-reference#section-customers
// https://dev.moip.com.br/v2.0/reference#clientes
final class Customer extends TestCase {
	/** @test 2017-04-26 */
	function t00() {}

	/**
	 * 2017-04-20
	 * https://dev.moip.com.br/page/api-reference#section-create-a-customer-post-
	 * https://dev.moip.com.br/v2.0/reference#criar-um-cliente
	 */
	function t01_create() {
		try {
			/**
			 * 2017-04-25
			 * @see \Moip\Resource\Customer::populate() clones the current object instance
			 * and returns the clone:
			 * 		$customer = clone $this;
			 * 		<...>
			 * 		return $customer;
			 * https://github.com/moip/moip-sdk-php/blob/v1.1.2/src/Resource/Customer.php#L233-L267
			 */
			// 2017-04-22
			// https://dev.moip.com.br/reference#criar-um-cliente
			echo C::create($this->pCustomer())->j();
		}
		catch (\Exception $e) {
			/** @var \Exception|leUnautorized|leUnexpected|leValidation $e */
			throw $e;
		}
	}

	/**
	 * @test
	 * 2017-04-25
	 * https://dev.moip.com.br/page/api-reference#section-retrieve-a-customer-get-
	 * https://dev.moip.com.br/v2.0/reference#consultar-um-cliente
	 * В качестве параметра «customer_id» этого запроса допустим только идентификатор покупателя в Moip
	 * (значение поля «id», оно имеет вид «CUS-UKXT2RQ2TULX»).
	 * Значение поля «ownId» тут недопустимо.
	 *	{
	 *		"id": "CUS-UKXT2RQ2TULX",
	 *		"ownId": "admin@mage2.pro",
	 *		"fullname": "Dmitry Fedyuk",
	 *		"createdAt": "2017-04-25T04:38:31.000-03",
	 *		<...>
	 *	}
	 */
	function t02_get() {
		/** @var string $id */
		$id = 'CUS-UKXT2RQ2TULX';
		try {
			/**
			 * 2017-04-25
			 * @see \Moip\Resource\Customer::populate() clones the current object instance
			 * and returns the clone:
			 * 		$customer = clone $this;
			 * 		<...>
			 * 		return $customer;
			 * https://github.com/moip/moip-sdk-php/blob/v1.1.2/src/Resource/Customer.php#L233-L267
			 * CUS-UKXT2RQ2TULX
			 */
			echo C::get($id)->j();
		}
		catch (leValidation $e) {
			/**
			 * 2017-04-25
			 * @see \Moip\Exceptions\Error::parseErrors() returns no message
			 * if a requested resource is not found: https://github.com/moip/moip-sdk-php/issues/104
			 */
			/** @var \Exception|leUnautorized|leUnexpected|leValidation $e */
			if (404 === $e->getStatusCode()) {
				echo "The customer with the requested ID ($id) is absent in the Moip database.";
			}
			else {
				throw $e;
			}
		}
	}

	/**
	 * 2017-04-25
	 * @used-by pAddress()
	 * @return GA
	 */
	private function ga() {return dfc($this, function() {return
		df_geo('AIzaSyBj8bPt0PeSxcgPW8vTfNI2xKdhkHCUYuc', 'pt-BR', 'br')->geocode(
			'Av. Lúcio Costa, 3150 - Barra da Tijuca, Rio de Janeiro - RJ, 22630-010'
		)->first()
	;});}

	/**
	 * 2017-04-25
	 * «The Address is the set of data that represents a location:
	 * 	*) associated with the Customer as the delivery address («shippingAddress»)
	 * 	*) or associated with the Credit Card as the billing address («billingAddress»).»
	 * https://dev.moip.com.br/v2.0/reference#endereco
	 * @used-by pCustomer()
	 * @return array(string => mixed)
	 */
	private function pAddress() {/** @var GA $ga */$ga = $this->ga(); return [
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
	 * 2017-04-25 https://dev.moip.com.br/reference#criar-um-cliente
	 * @used-by t01_create()
	 * @return array(string => mixed)
	 */
	private function pCustomer() {return [
		// 2017-04-22 «Client's date of birth», Date (YYYY-MM-DD), Optional.
		'birthDate' => '1982-07-08'
		// 2017-04-22 «Email from the client», Required, String(45).
		,'email' => 'admin@mage2.pro'
		// 2017-04-22 «Full name of customer», Required, String(90).
		,'fullname' => 'Dmitry Fedyuk'
		// 2017-04-22
		// «Customer Id. External reference.»
		// Required, String(66).
		// It should be unique, otherwise you will get the error:
		// «O identificador prßprio deve ser único, j¹ existe um customer com o identificador informado»
		// («The unique identifier must be unique, there is a customer with the identified identifier»).
		,'ownId' => df_uid(4, 'admin@mage2.pro-')
		// 2017-04-23
		// «The Address is the set of data that represents a location:
		// *) associated with the Customer as the delivery address («shippingAddress»)
		// 	*) or associated with the Credit Card as the billing address («billingAddress»).»
		// https://dev.moip.com.br/v2.0/reference#endereco
		,'shippingAddress' => $this->pAddress()
		// 2017-04-25 «Fiscal document», Optional, Structured.
		,'taxDocument' => [
			// 2017-04-23 «Document number»,  String(11).
			'number' => '22222222222'
			// 2017-04-23 «Document type. Possible values: CPF, CNPJ.», String(4).
			,'type' => 'CPF'
		]
	// 2017-04-22 «Customer's phone number», Optional, Structured.
	// 2017-04-25
	// «Today we do not support creating clients that are from other countries
	// that are not from Brazil, so this error occurs.
	// We do not have a forecast to be international.»
	// https://mage2.pro/t/3820/2
	] + (!($p = $this->phoneA()) || 3 > count($p) || 55 !== intval($p[1]) ? [] : array_combine([
		// 2017-04-25 «Your phone's local code (DDD)», Integer(2).
		'areaCode'
		// 2017-04-25 «ID number of the phone. Possible values: 55.», Integer(2).
		,'countryCode'
		// 2017-04-25 «Telephone number.», Integer(9).
		,'number'
	], $p));}

	/**
	 * 2017-04-25
	 * @used-by pCustomer()
	 * @return string[]|null
	 */
	private function phoneA() {return dfc($this, function() {return df_phone_explode(
		['+552131398000', 'BR'], false
	);});}

	/**
	 * 2017-04-25
	 * @used-by pAddress()
	 * @param mixed $v
	 * @return string
	 */
	private static function u($v) {return $v ?: (string)__('Unknown');}
}