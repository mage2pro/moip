<?php
// 2017-04-11
namespace Dfe\Moip;
/** @method static Settings s() */
final class Settings extends \Df\StripeClone\Settings {
	/**
	 * 2017-04-20 «The «Token» part of your Test Private Key (Chave de autenticação)»
	 * @return string
	 */
	function privateToken() {return $this->testableP();}
}