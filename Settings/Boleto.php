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
	 */
	function instructions():string {return $this->v();}

	/**
	 * 2017-07-30
	 * @used-by \Dfe\Moip\P\Charge::p()
	 */
	function waitPeriod():int {return WaitPeriodType::calculate($this);}

	/**
	 * 2017-07-30
	 * @override
	 * @see \Df\Payment\Settings::prefix()
	 * @used-by \Df\Config\Settings::v()
	 */
	protected function prefix():string {return dfc($this, function() {return parent::prefix() . '/boleto';});}
}