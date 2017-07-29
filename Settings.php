<?php
namespace Dfe\Moip;
// 2017-04-11
/** @method static Settings s() */
final class Settings extends \Df\StripeClone\Settings {
	/**
	 * 2017-07-14
	 * «Private Key for Google Maps Geocoding API»
	 * «How to generate a key for the Google Maps Geocoding API?» https://mage2.pro/t/3828
	 * My key usage restrictions: https://console.developers.google.com/apis/credentials/key/65?project=mage2-pro
	 * My key usage statistics: https://console.developers.google.com/apis/api/geocoding-backend.googleapis.com/overview?project=mage2-pro&duration=P30D
	 * @used-by \Dfe\Moip\P\Charge::pAddress()
	 * @used-by \Dfe\Moip\T\Data::ga()
	 * @return string
	 */
	function googlePrivateKey() {return $this->p();}

	/**
	 * 2017-07-14 «Installments»
	 * @return int[]
	 */
	function installments() {return dfc($this, function() {return df_sort(array_unique(
		array_merge([1], array_filter(df_int($this->csv('card/installments')), function($i) {return
			$i >= 1 && $i <= 12
		;}))
	));});}

	/**
	 * 2017-04-20 «The «Token» part of your Test Private Key (Chave de autenticação)»
	 * @return string
	 */
	function privateToken() {return $this->testableP();}
}