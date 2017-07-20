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
	 * It solves the task:
	 * `Show the chosen installment plan in the «Payment Information» / «Forma de pagamento» blocks
	 * (frontend, backend, emails)`: https://github.com/mage2pro/moip/issues/3
	 * Note 2.
	 * See a similar implementation for the «歐付寶 allPay» extension:
	 * https://github.com/mage2pro/allpay/blob/1.6.7/Block/Info/BankCard.php#L54
	 * @override
	 * @see \Df\StripeClone\Block\Info::prepare()
	 * @used-by \Df\Payment\Block\Info::_prepareSpecificInformation()
	 */
	final protected function prepare() {
		parent::prepare();
		if (1 !== ($p = $this->m()->plan()) /** @var int $p */) {
			$this->si('Installments', $p);
		}
	}
}