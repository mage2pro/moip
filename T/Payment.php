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
	 * «Payment method»
	 * @used-by pPayment()
	 * @return array(string => mixed)
	 */
	private function pFundingInstrument() {return [
		// 2017-06-09
		// «Credit Card data. It can be:
		// *) the ID of a credit card previously saved,
		// *) an encrypted credit card hash
		// *) the whole collection of credit card attributes (in case you have PCI DSS certificate).»
		'creditCard' => [
			// 2017-06-09
			// «Encrypted credit card data»
			// Conditional, String.
			// https://dev.moip.com.br/v2.0/docs/criptografia
			'hash' => ''
			// 2017-06-09
			// «Credit card ID.
			// This ID can be used in the future to create new payments. Internal reference.»
			// Conditional, String(16).
			,'id' => ''
		]
		// 2017-06-09
		// «Method used. Possible values: CREDIT_CARD, BOLETO, ONLINE_BANK_DEBIT, WALLET»
		// Required, String.
		,'method' => 'CREDIT_CARD'
	];}

	/**
	 * 2017-06-09
	 * @used-by t01_create()
	 * @return array(string => mixed)
	 */
	private function pPayment() {return [
		// 2017-06-09
		// «Used if you need to pre-capture a payment. Only available for credit cards.»
		// Optional, Boolean.
		'delayCapture' => ''
		// 2017-06-09
		// «Payment method»
		// Required
		,'fundingInstrument' => $this->pFundingInstrument()
		// 2017-06-09
		// «Identification of your store on the buyer's credit card invoice»
		// Optional, String(13).
		,'statementDescriptor' => ''
	];}
}