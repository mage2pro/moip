<?php
namespace Dfe\Moip\T;
use DateTime as DT;
use Moip\Exceptions\UnautorizedException as leUnautorized;
use Moip\Exceptions\UnexpectedException as leUnexpected;
use Moip\Exceptions\ValidationException as leValidation;
use Moip\Moip as API;
use Moip\Resource\Customer as C;
// 2017-04-20
final class Basic extends TestCase {
	/** 2017-04-20 */
	function t01() {echo df_dump([
		$this->s()->publicKey(), $this->s()->privateToken(), $this->s()->privateKey()
	]);}

	/** @test 2017-04-20 */
	function t02() {
		/** @var API $api */
		$api = $this->api();
		/** @var C $c */
		$c = $api->customers();
		// 2017-04-22
		// https://dev.moip.com.br/reference#criar-um-cliente
		$c
			// 2017-04-22
			// «STUB»
			// STUB
			->setBirthDate(DT::createFromFormat('Y-m-d', '1982-07-08'))
			// 2017-04-22
			// «Email from the client.»
			// Required, String (45)
			->setEmail('admin@mage2.pro')
			// 2017-04-22
			// «Full name of customer.»
			// Required, String (90)
			->setFullname('Dmitry Fedyuk')
			// 2017-04-22
			// «Customer Id. External reference.»
			// Required, String (66)
			// It should be unique, otherwise you will get the error:
			// «O identificador prßprio deve ser único, j¹ existe um customer com o identificador informado»
			// («The unique identifier must be unique, there is a customer with the identified identifier»).
			->setOwnId(uniqid('df-customer-'))
			/**
			 * 2017-04-22
			 * «Customer's phone, with country code, area code and number»
			 * @param int $areaCode
			 * @param int $number
			 * @param int $countryCode [optional]
			 */
			->setPhone(11, 66778899, 55)
			// 2017-04-22
			// «STUB»
			// STUB				
			->setTaxDocument('22222222222', 'CPF')
			->addAddress(
				C::ADDRESS_SHIPPING, 'Avenida Faria Lima', '2927', 'Itaim'
				, 'Sao Paulo', 'SP', '01234000', '8'
			)
		;
		try {
			$c2 = $c->create();
			xdebug_break();
		}
		catch (\Exception $e) {
			/** @var \Exception|leUnautorized|leUnexpected|leValidation $e */
			xdebug_break();
			throw $e;
		}
	}
}