<?php
namespace Dfe\Moip;
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
		df_pad($c->first6(), $c->numberLength() - 4, '·') . "{$c->last4()} ({$c->brand()})"
	;}
}

