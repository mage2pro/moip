<?php
namespace Dfe\Moip\Settings;
use Df\Config\Source\WaitPeriodType;
/**
 * 2017-07-30
 * @used-by \Dfe\Moip\Settings::boleto()
 * @method static Boleto s()
 */
final class Boleto extends \Df\Payment\Settings {
	/**
	 * 2017-07-30 «Instruções impressas no boleto»
	 * @used-by \Dfe\Moip\P\Charge::pInstructionLines()
	 * @return string
	 */
	function instructions() {return $this->v();}

	/**
	 * 2017-07-30
	 * @used-by \Dfe\Moip\P\Charge::p()
	 * @return int
	 */
	function waitPeriod() {return WaitPeriodType::calculate($this);}

	/**
	 * 2017-07-30
	 * @override
	 * @see \Df\Payment\Settings::prefix()
	 * @used-by \Df\Config\Settings::v()
	 * @return string
	 */
	protected function prefix() {return dfc($this, function() {return parent::prefix() . '/boleto';});}
}