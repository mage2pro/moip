<?php
namespace Dfe\Moip;
// 2017-04-11
/** @method static Settings s() */
final class Settings extends \Df\StripeClone\Settings {
	/**
	 * 2017-07-14 «Private Key for Google Maps Geocoding API»
	 * @used-by \Dfe\Moip\P\Reg::ga()
	 * @used-by \Dfe\Moip\T\Data::ga()
	 * @return string
	 */
	function googlePrivateKey() {return $this->p();}

	/**
	 * 2017-04-20 «The «Token» part of your Test Private Key (Chave de autenticação)»
	 * @return string
	 */
	function privateToken() {return $this->testableP();}
}