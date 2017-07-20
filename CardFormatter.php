<?php
namespace Dfe\Moip;
use Df\Payment\BankCardNetworks as N;
use Df\Sales\Plugin\Model\Order\Email\Sender\OrderSender as OS;
use Dfe\Moip\Facade\Card as C;
// 2017-07-19
/** @method C c() */
final class CardFormatter extends \Df\StripeClone\CardFormatter {
	/**
	 * 2017-07-19
	 * @override
	 * @see \Df\StripeClone\CardFormatter::label()
	 * @used-by \Df\StripeClone\Block\Info::prepare()
	 * @used-by \Df\StripeClone\ConfigProvider::cards()
	 * @return string
	 */
	function label() {$c = $this->c(); /** @var C $c */return
		df_pad($c->first6(), $c->numberLength() - 4, '·') . "{$c->last4()} " .
			(OS::is() ? "({$c->brand()})" :
				df_tag('img', N::dimensions(null, 20) + ['alt' => $c->brand(), 'src' => N::url($c->logoId())])
			)
	;}
}


