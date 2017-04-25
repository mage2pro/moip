<?php
namespace Dfe\Moip\T;
use DateTime as DT;
use Geocoder\Model\Address as GA;
use Moip\Exceptions\UnautorizedException as leUnautorized;
use Moip\Exceptions\UnexpectedException as leUnexpected;
use Moip\Exceptions\ValidationException as leValidation;
use Moip\Moip as API;
use Moip\Resource\Customer as C;
// 2017-04-20
final class Customer extends TestCase {
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
		/** @var GA $ga */
		$ga = df_geo('AIzaSyBj8bPt0PeSxcgPW8vTfNI2xKdhkHCUYuc', 'pt-BR', 'br')->geocode(
			'Av. Lúcio Costa, 3150 - Barra da Tijuca, Rio de Janeiro - RJ, 22630-010'
		)->first();
		// 2017-04-22
		// https://dev.moip.com.br/reference#criar-um-cliente
		$c
			// 2017-04-22
			// «Client's date of birth.»
			// Date (YYYY-MM-DD)
			// Optional
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
			->setOwnId(df_uid(4, 'admin@mage2.pro-'))
			/**
			 * 2017-04-23
			 * @param string $number	Document number. Character limit: (11)
			 * @param string $type		Document type. Possible values: CPF, CNPJ. Character limit: (4)
			 * Optional.
			 */
			->setTaxDocument('22222222222', 'CPF')
			/**
			 * 2017-04-23
			 * «The Address is the set of data that represents a location:
			 * 	*) associated with the Customer as the delivery address («shippingAddress»)
			 * 	*) or associated with the Credit Card as the billing address («billingAddress»).»
			 * https://dev.moip.com.br/v2.0/reference#endereco
			 * @param string $type       Address type: SHIPPING or BILLING.
			 * @param string $street     Street address.
			 * @param string $number     Number address.
			 * @param string $district   Neighborhood address.
			 * @param string $city       City address.
			 * @param string $state      State address.
			 * @param string $zip        The zip code billing address.
			 * @param string $complement Address complement.
			 * @param string $country    Country ISO-alpha3 format, BRA example.
			 */
			->addAddress(
				// 2017-04-23
				// «Address type: SHIPPING or BILLING.»
				C::ADDRESS_SHIPPING
				// 2017-04-23
				// Property: «street».
				// PHPDoc: «Street address»
				// Reference: «Address post office», Required, String (45)
				,$ga->getStreetName() ?: 'Unknown'
				// 2017-04-23
				// Property: «streetNumber».
				// PHPDoc: «Number address»
				// Reference: «Number», Required, String (10)
				,$ga->getStreetNumber() ?: 'Unknown'
				// 2017-04-23
				// Property: «district».
				// PHPDoc: «Neighborhood address»
				// Reference: «Neighborhood», Required, String (45)
				,$ga->getLocality() ?: ($ga->getSubLocality() ?: 'Unknown')
				// 2017-04-23
				// Property: «city».
				// PHPDoc: «City address»
				// Reference: «City», Required, String (32)
				,df_geo_city($ga) ?: 'Unknown'
				// 2017-04-23
				// Property: «state».
				// PHPDoc: «State address»
				// Reference: «State», Required, String (32)
				,df_geo_state_code($ga) ?: 'Unknown'
				// 2017-04-23
				// Property: «STUB».
				// PHPDoc: «The zip code billing address»
				// Reference: «The zip code of the billing address», Required, String (9)
				,$ga->getPostalCode()
				// 2017-04-23
				// Property: «complement».
				// PHPDoc: «Address complement»
				// Reference: «Address complement», Conditional, String (45)
				,''
				// 2017-04-23
				// Property: «country».
				// PHPDoc: «Country ISO-alpha3 format, BRA example.»
				// Reference: «Country in format ISO-alpha3, example BRA», Required, String (3)
				//
				// 2017-04-25
				// «Today we do not support creating clients that are from other countries
				// that are not from Brazil, so this error occurs.
				// We do not have a forecast to be international.»
				// https://mage2.pro/t/3820/2
				,df_country_2_to_3('BR')
			)
		;
		/** @var string[] $phoneA */
		$phoneA = df_phone_explode(['+552131398000', 'BR'], false);
		if ($phoneA && 2 < count($phoneA)) {
			/**
			 * 2017-04-22
			 * «Customer's phone, with country code, area code and number»
			 * Optional
			 * @param int $areaCode
			 * @param int $number
			 * @param int $countryCode [optional]
			 */
			$c->setPhone($phoneA[1], $phoneA[2], $phoneA[0]);
		}
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

	/** 2017-04-22 */
	function t03() {
		echo df_dump(df_phone_explode(['+552131398000', 'BR'], false));
	}
}