<?php
namespace Dfe\Moip\SDK;
// 2017-06-10
// Possible values: CREDIT_CARD, BOLETO, ONLINE_BANK_DEBIT, WALLET»
// https://dev.moip.com.br/page/api-reference#section-payments
// https://dev.moip.com.br/v2.0/reference#pedidos
final class Option {
	/**
	 * 2017-06-10
	 * @used-by \Dfe\Moip\Facade\Customer::cardsData()
	 * @used-by \Dfe\Moip\T\CaseT\Payment::pFundingInstrument()
	 */
	const BANK_CARD = 'CREDIT_CARD';
}