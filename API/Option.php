<?php
namespace Dfe\Moip\API;
// 2017-06-10
// Possible values: CREDIT_CARD, BOLETO, ONLINE_BANK_DEBIT, WALLET»
// https://dev.moip.com.br/page/api-reference#section-payments
// https://dev.moip.com.br/v2.0/reference#criar-pagamento
// https://dev.moip.com.br/v2.0/reference#pedidos
// 2017-07-23 `[Moip] The available payment options`: https://mage2.pro/t/3851
final class Option {
	/**
	 * 2017-07-23 «Boleto Bancário»: https://github.com/mage2pro/moip/issues/14
	 * @used-by \Dfe\Moip\Test\CaseT\Payment\Boleto::pPayment()
	 */
	const BOLETO = 'BOLETO';

	/**
	 * 2017-06-10
	 * @used-by \Dfe\Moip\P\Charge::v_CardId()
	 * @used-by \Dfe\Moip\Facade\Customer::cardsData()
	 * @used-by \Dfe\Moip\Test\CaseT\Payment\Card::pFundingInstrument()
	 */
	const BANK_CARD = 'CREDIT_CARD';

	/**
	 * 2017-07-21 «Transferência Bancária»: https://github.com/mage2pro/moip/issues/7
	 * @used-by \Dfe\Moip\Test\CaseT\Payment\OnlineBanking::pPayment()
	 */
	const ONLINE_BANKING = 'ONLINE_BANK_DEBIT';
}