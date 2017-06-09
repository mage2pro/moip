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
}