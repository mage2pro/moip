<?php
namespace Dfe\Moip\Block;
use Dfe\Moip\Method as M;
/**
 * 2017-07-20
 * @final Unable to use the PHP «final» keyword here because of the M2 code generation.
 * @method M m()
 */
class Info extends \Df\StripeClone\Block\Info {
	/**
	 * 2017-07-20
	 * Note 1.
	 * It solves the tasks:
	 * 1.1) `Show the chosen installment plan in the «Payment Information» / «Forma de pagamento» blocks
	 * (frontend, backend, emails)`: https://github.com/mage2pro/moip/issues/3
	 * 1.2) `Show the cardholder's CPF (tax ID) in the «Payment Information» backend block`
	 * https://github.com/mage2pro/moip/issues/5
	 * Note 2.
	 * See a similar implementation for the «歐付寶 allPay» extension:
	 * https://github.com/mage2pro/allpay/blob/1.6.7/Block/Info/BankCard.php#L54
	 * @override
	 * @see \Df\StripeClone\Block\Info::prepare()
	 * @used-by \Df\Payment\Block\Info::_prepareSpecificInformation()
	 */
	final protected function prepare() {
		parent::prepare();
		$m = $this->m(); /** @var M $m */
		$this->siEx(['Date of Birth' => $m->dob(), 'Tax ID' => $m->taxID()]);
		if (1 !== ($p = $m->plan()) /** @var int $p */) {
			$this->si('Installments', $p);
		}
	}
}