<?php
namespace Dfe\Moip\Test;
use Dfe\Moip\Settings as S;
use Geocoder\Model\Address as GA;
final class Data {
	/**
	 * 2017-04-25
	 * «The Address is the set of data that represents a location:
	 * 	*) associated with the Customer as the delivery address («shippingAddress»)
	 * 	*) or associated with the Credit Card as the billing address («billingAddress»).»
	 * https://dev.moip.com.br/v2.0/reference#endereco
	 * @used-by \Dfe\Moip\Test\CaseT\Customer::pCustomer()
	 * @return array(string => mixed)
	 */
	function address():array {/** @var GA $ga */$ga = $this->ga(); return [
		'city' => self::u(df_geo_city($ga)) # 2017-04-23 «City», Required, String(32).
		,'complement' => '' # 2017-04-23 «Address complement», Conditional, String(45).
		# 2017-04-23 «Country in format ISO-alpha3, example BRA», Required, String(3).
		# 2017-04-25
		# «Today we do not support creating clients that are from other countries
		# that are not from Brazil, so this error occurs.
		# We do not have a forecast to be international.»
		# https://mage2.pro/t/3820/2
		,'country' => df_country_2_to_3('BR')
		,'district' => self::u($ga->getLocality() ?: $ga->getSubLocality()) # 2017-04-23 «Neighborhood», Required, String(45).
		,'state' => self::u(df_geo_state_code($ga)) # 2017-04-23 «State», Required, String(32).
		,'street' => self::u($ga->getStreetName()) # 2017-04-25 «Address post office», Required, String(45).
		,'streetNumber' => self::u($ga->getStreetNumber()) # 2017-04-23 «Number», Required, String(10).
		,'zipCode' => $ga->getPostalCode() # 2017-04-23 «The zip code of the billing address», Required, String(9).
	];}

	/**
	 * 2017-06-09
	 * @used-by \Dfe\Moip\Test\CaseT\Customer::pCustomer()
	 * @used-by \Dfe\Moip\Test\Payment::pFundingInstrument()
	 * @return array(string => int|string)
	 */
	function phone():array {return dfe_moip_phone('+552131398000');}

	/**
	 * 2017-06-09 «Fiscal document»
	 * @used-by \Dfe\Moip\Test\CaseT\Customer::pCustomer()
	 * @used-by \Dfe\Moip\Test\Payment::pFundingInstrument()
	 * @return array(string => int|string)
	 */
	function taxDocument():array {return [
		# 2017-04-23 «Document number»,  String(11).
		'number' => '11438374798'
		# 2017-04-23
		# «Document type. Possible values:
		# *) CPF for social security number
		# *) CNPJ for tax identification number.»
		# String(4).
		# 2017-06-13
		# CPF: Cadastro de Pessoas Físicas (an individual's ID)
		# https://en.wikipedia.org/wiki/Cadastro_de_Pessoas_Físicas
		# CNPJ: Cadastro Nacional da Pessoa Jurídica (a company's ID)
		# https://en.wikipedia.org/wiki/CNPJ
		,'type' => 'CPF'
	];}

	/**
	 * 2017-04-25
	 * @used-by self::address()
	 * @return GA
	 */
	private function ga() {return dfc($this, function() {$s = dfps($this); /** @var S $s */return
		df_geo($s->googlePrivateKey(), 'pt-BR', 'br')->p(
			'Av. Lúcio Costa, 3150 - Barra da Tijuca, Rio de Janeiro - RJ, 22630-010'
		)
	;});}

	/** @used-by \Dfe\Moip\Test\CaseT\Customer::pCustomer() */
	static function s():self {static $r; return $r ? $r : $r = new self;}

	/**
	 * 2017-04-25
	 * @used-by self::address()
	 * @param mixed $v
	 * @return string
	 */
	private static function u($v) {return $v ?: (string)__('Unknown');}
}