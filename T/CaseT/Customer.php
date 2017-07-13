<?php
namespace Dfe\Moip\T\CaseT;
use Dfe\Moip\SDK\Customer as C;
use Dfe\Moip\T\Card as tCard;
use Dfe\Moip\T\Data;
use Moip\Exceptions\UnautorizedException as leUnautorized;
use Moip\Exceptions\UnexpectedException as leUnexpected;
use Moip\Exceptions\ValidationException as leValidation;
// 2017-04-20
// https://dev.moip.com.br/page/api-reference#section-customers
// https://dev.moip.com.br/v2.0/reference#clientes
final class Customer extends \Dfe\Moip\T\CaseT {
	/** @test 2017-04-26 */
	function t00() {}

	/**
	 * 2017-04-20
	 * https://dev.moip.com.br/page/api-reference#section-create-a-customer-post-
	 * https://dev.moip.com.br/v2.0/reference#criar-um-cliente
	 * [Moip] An example of a response to «POST v2/customers» https://mage2.pro/t/3813
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
			if (function_exists('xdebug_break')) {
				xdebug_break();
			}
			/** @var \Exception|leUnautorized|leUnexpected|leValidation $e */
			throw $e;
		}
	}

	/**
	 * 2017-04-25
	 * https://dev.moip.com.br/page/api-reference#section-retrieve-a-customer-get-
	 * https://dev.moip.com.br/v2.0/reference#consultar-um-cliente
	 * [Moip] An example of a response to «GET v2/customers/<customer ID>» https://mage2.pro/t/4049
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
		// 2017-06-10
		// This option is undocumented in the Portuguese documentation:
		// But it is mentioned in the English documentation:
		// https://dev.moip.com.br/page/api-reference#section-create-a-customer-post-
		,'fundingInstruments' => [tCard::s()->get('hash')]
		// 2017-04-22
		// «Customer Id. External reference.»
		// Required, String(66).
		// It should be unique, otherwise you will get the error:
		// «O identificador prßprio deve ser único, j¹ existe um customer com o identificador informado»
		// («The unique identifier must be unique, there is a customer with the identified identifier»).
		,'ownId' => df_uid(6, 'admin@mage2.pro-')
		// 2017-04-23
		// «The Address is the set of data that represents a location:
		// *) associated with the Customer as the delivery address («shippingAddress»)
		// 	*) or associated with the Credit Card as the billing address («billingAddress»).»
		// https://dev.moip.com.br/v2.0/reference#endereco
		,'shippingAddress' => Data::s()->address()
		// 2017-04-25 «Fiscal document», Optional, Structured.
		,'taxDocument' => Data::s()->taxDocument()
	// 2017-04-22 «Customer's phone number», Optional, Structured.
	// 2017-04-25
	// «Today we do not support creating clients that are from other countries
	// that are not from Brazil, so this error occurs.
	// We do not have a forecast to be international.»
	// https://mage2.pro/t/3820/2
	] + Data::s()->phone();}
}