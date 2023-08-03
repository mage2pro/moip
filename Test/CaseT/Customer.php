<?php
namespace Dfe\Moip\Test\CaseT;
use Dfe\Moip\API\Facade\Customer as C;
use Dfe\Moip\Test\Data;
# 2017-04-20
# https://dev.moip.com.br/page/api-reference#section-customers
# https://dev.moip.com.br/v2.0/reference#clientes
final class Customer extends \Dfe\Moip\Test\CaseT {
	/** 2017-04-26 @test */
	function t00():void {}

	/**
	 * 2017-04-20
	 * https://dev.moip.com.br/page/api-reference#section-create-a-customer-post-
	 * https://dev.moip.com.br/v2.0/reference#criar-um-cliente
	 * [Moip] An example of a response to «POST v2/customers» https://mage2.pro/t/3813
	 */
	function t01_create():void {
		try {
			# 2017-04-22 https://dev.moip.com.br/reference#criar-um-cliente
			print_r(C::s()->create($this->pCustomer())->j());
		}
		catch (\Throwable $t) {
			if (function_exists('xdebug_break')) {
				xdebug_break();
			}
			throw $t;
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
	 *		"fullname": "Dmitrii Fediuk",
	 *		"createdAt": "2017-04-25T04:38:31.000-03",
	 *		<...>
	 *	}
	 */
	function t02_get():void {
		$id = 'CUS-UKXT2RQ2TULX'; /** @var string $id */
		try {
			print_r(C::s()->get($id)->j());
		}
		catch (\Throwable $t) {
			if (function_exists('xdebug_break')) {
				xdebug_break();
			}
			throw $t;
		}
	}

	/**
	 * 2017-04-25 https://dev.moip.com.br/reference#criar-um-cliente
	 * @used-by self::t01_create()
	 * @return array(string => mixed)
	 */
	private function pCustomer():array {return df_clean([
		'birthDate' => '1982-07-08' # 2017-04-22 «Client's date of birth», Date (YYYY-MM-DD), Optional.
		,'email' => 'admin@mage2.pro' # 2017-04-22 «Email from the client», Required, String(45).
		,'fullname' => 'Dmitrii Fediuk' # 2017-04-22 «Full name of customer», Required, String(90).
		/**    
		 * 2017-06-10
		 * This option is undocumented in the Portuguese documentation:
		 * But it is mentioned in the English documentation:
		 * https://dev.moip.com.br/page/api-reference#section-create-a-customer-post-
		 * 2017-07-16
		 * Note 1.
		 * I was unable to get it to work: 'fundingInstruments' => [\Dfe\Moip\Test\Card::s()->get('hash')]
		 * `A «POST /v2/customers» request with a bank card hash as a «fundingInstruments» parameter
		 * leads to an undocumented «{"ERROR": "Ops... We were not waiting for it"}» response`:
		 * https://mage2.pro/t/4174
		 * https://suporte.moip.com.br/hc/pt-br/requests/1458451
		 * @see \Dfe\Moip\P\Reg::k_CardId()
		 * https://github.com/mage2pro/moip/blob/0.7.0/P/Reg.php#L24-L29
		 * @see \Df\StripeClone\Payer::newCard()
		 * https://github.com/mage2pro/core/blob/2.8.19/StripeClone/Payer.php#L103-L109
		 * Note 2.
		 * There is a similar error on `POST /v2/customers/<customer ID>/fundinginstruments`:
		 * @see \Dfe\Moip\Test\CaseT\Card::t01_add()
		 * https://github.com/mage2pro/moip/blob/0.7.1/T/CaseT/Card.php#L17-L23
		 */
		,'fundingInstruments' => null
		# 2017-04-22
		# «Customer Id. External reference.»
		# Required, String(66).
		# It should be unique, otherwise you will get the error:
		# «O identificador prßprio deve ser único, j¹ existe um customer com o identificador informado»
		# («The unique identifier must be unique, there is a customer with the identified identifier»).
		,'ownId' => df_uid(6, 'admin@mage2.pro-')
		# 2017-04-23
		# «The Address is the set of data that represents a location:
		# *) associated with the Customer as the delivery address («shippingAddress»)
		# 	*) or associated with the Credit Card as the billing address («billingAddress»).»
		# https://dev.moip.com.br/v2.0/reference#endereco
		,'shippingAddress' => Data::s()->address()
		# 2017-04-25 «Fiscal document», Optional, Structured.
		,'taxDocument' => Data::s()->taxDocument()
	# 2017-04-22 «Customer's phone number», Optional, Structured.
	# 2017-04-25
	# «Today we do not support creating clients that are from other countries
	# that are not from Brazil, so this error occurs.
	# We do not have a forecast to be international.»
	# https://mage2.pro/t/3820/2
	]) + Data::s()->phone();}
}