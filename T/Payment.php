<?php
namespace Dfe\Moip\T;
use Dfe\Moip\SDK\Payment as lP;
use Moip\Exceptions\UnautorizedException as leUnautorized;
use Moip\Exceptions\UnexpectedException as leUnexpected;
use Moip\Exceptions\ValidationException as leValidation;
// 2017-06-09
// https://dev.moip.com.br/page/api-reference#section-payments
// https://dev.moip.com.br/v2.0/reference#pagamentos
final class Payment extends TestCase {
	/** 2017-06-09 */
	function t00() {}

	/** @test 2017-06-09 */
	function t01_create() {
		try {
			//echo lP::create('ORD-TKZ1BQOQL69J', $this->pPayment())->j();
			echo df_json_encode_pretty($this->pPayment());
		}
		catch (\Exception $e) {
			/** @var \Exception|leUnautorized|leUnexpected|leValidation $e */
			xdebug_break();
			throw $e;
		}
	}

	/**
	 * 2017-06-09
	 * @used-by t01_create()
	 * @return array(string => mixed)
	 */
	private function pPayment() {return [
		// 2017-06-09
		// «Identification of your store on the buyer's credit card invoice»
		// Optional, String(13).
		'statementDescriptor' => ''
	];}
}