<?php
namespace Dfe\Moip\T;
final class Data {
	/**
	 * 2017-06-09
	 * @used-by \Dfe\Moip\T\Customer::pCustomer()
	 * @used-by \Dfe\Moip\T\Payment::pFundingInstrument()
	 * @return array(string => int|string)
	 */
	static function phone() {return dfe_moip_phone('+552131398000');}

	/**
	 * 2017-06-09 «Fiscal document»
	 * @used-by \Dfe\Moip\T\Customer::pCustomer()
	 * @used-by \Dfe\Moip\T\Payment::pFundingInstrument()
	 * @return array(string => int|string)
	 */
	static function taxDocument() {return [
		// 2017-04-23 «Document number»,  String(11).
		'number' => '22222222222'
		// 2017-04-23
		// «Document type. Possible values:
		// *) CPF for social security number
		// *) CNPJ for tax identification number.»
		// String(4).
		,'type' => 'CPF'
	];}
}