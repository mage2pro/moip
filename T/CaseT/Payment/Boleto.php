<?php
namespace Dfe\Moip\T\CaseT\Payment;
use Dfe\Moip\API\Facade\Payment as lP;
use Dfe\Moip\API\Option;
use Dfe\Moip\T\Order as tOrder;
// 2017-07-24
// https://dev.moip.com.br/page/api-reference#section-payments
// https://dev.moip.com.br/v2.0/reference#pagamentos
// `[Moip] The available payment options`: https://mage2.pro/t/3851
final class Boleto extends \Dfe\Moip\T\CaseT {
	/** 2017-07-24 */
	function t00() {}

	/**
	 * @test 2017-07-24
	 * https://dev.moip.com.br/v2.0/reference#criar-pagamento
	 * https://dev.moip.com.br/page/api-reference#section-create-a-payment-post-
	 * [Moip] An example of a response to «POST v2/orders/<order ID>/payments» https://mage2.pro/t/4048
	 */
	function t01_create() {
		try {
			echo lP::s()->create2((new tOrder)->create()['id'], $this->pPayment())->j();
			//echo df_json_encode($this->pPayment());
		}
		catch (\Exception $e) {
			if (function_exists('xdebug_break')) {
				xdebug_break();
			}
			throw $e;
		}
	}

	/**
	 * 2017-07-24
	 * @used-by t01_create()
	 * @return array(string => mixed)
	 */
	private function pPayment() {return [
		// 2017-06-09
		// «Payment method»
		// Required
		'fundingInstrument' => [
			// 2017-07-24
			// «Payment slip attributes»
			// «Dados do boleto utilizado no pagamento»
			'boleto' => [
				// 2017-07-24
				// «Payment slip expiration date»
				// «Data de expiração de um boleto»
				// Required, yyyy-mm-dd.
				'expirationDate' => df_today_add(7)->toString('y-MM-dd')
				// 2017-07-24
				// «Payment slip instructions»
				// «Instruções impressas no boleto»
				,'instructionLines' => [
					// 2017-07-24
					// «Payment slip instructions, line 1»
					// «Primeira linha de instrução»
					'first' => 'First line'
					// 2017-07-24
					// «Payment slip instructions, line 2»
					// «Segunda linha de instrução»
					,'second' => 'Second line'
					// 2017-07-24
					// «Payment slip instructions, line 3»
					// «Terceira linha de instrução»
					,'third' => 'Third line'
				]
				// 2017-07-24
				// «Endereço de uma imagem com o logotipo a ser impresso no boleto.
				// Ainda não disponível nesta versão da API.»
				// Google Translate:
				// As I understand, it is an URL of a logotype to be printed on the boleto,
				// and it is not yet supported by the current API version.
				// Optional, link.
				,'logoUri' => 'https://avatars3.githubusercontent.com/u/23271789?v=4&s=200'
			]
			// 2017-06-09
			// «Method used. Possible values: CREDIT_CARD, BOLETO, ONLINE_BANK_DEBIT, WALLET»
			// Required, String.
			,'method' => Option::BOLETO
		]
	];}
}