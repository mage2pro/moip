<?php
namespace Dfe\Moip\P;
// 2017-06-11
/** @method Charge charge() */
final class Reg extends \Df\StripeClone\P\Reg {
	/**
	 * 2017-06-10
	 * This option is undocumented in the Portuguese documentation:
	 * But it is mentioned in the English documentation:
	 * https://dev.moip.com.br/page/api-reference#section-create-a-customer-post-
	 * 2017-06-11
	 * Ключ, значением которого является токен банковской карты.
	 * Этот ключ передаётся как параметр в запросе на сохранение банковской карты
	 * для будущего повторного использования при регистрации нового покупателя.
	 * https://github.com/mage2pro/moip/blob/0.4.5/T/CaseT/Customer.php#L106-L110
	 * @override
	 * @see \Df\StripeClone\P\Reg::k_CardId()
	 * @used-by \Df\StripeClone\P\Reg::request()
	 * @return string
	 */
	protected function k_CardId() {return 'fundingInstruments';}

	/**
	 * 2017-06-11 https://github.com/mage2pro/moip/blob/0.4.4/T/CaseT/Customer.php#L106-L110
	 * @override
	 * @see \Df\StripeClone\P\Reg::v_CardId()
	 * @used-by \Df\StripeClone\P\Reg::request()
	 * @param string $id
	 * @return array(array(string => mixed))
	 */
	protected function v_CardId($id) {return [$this->charge()->v_CardId($id)];}
}