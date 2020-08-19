<?php
namespace Dfe\Moip\W;
# 2017-07-30
final class Event extends \Df\StripeClone\W\Event {
	/**
	 * 2017-07-30 The type of the current transaction.
	 * @override
	 * @see \Df\StripeClone\W\Event::ttCurrent()
	 * @used-by \Df\StripeClone\W\Nav::id()
	 * @used-by \Df\Payment\W\Strategy\ConfirmPending::_handle()
	 * @return string
	 */
	function ttCurrent() {return null;}

	/**
	 * 2017-07-30 Тип родительской транзакции
	 * @override
	 * @see \Df\StripeClone\W\Event::ttParent()
	 * @used-by \Df\StripeClone\W\Nav::pidAdapt()
	 * @return string
	 */
	function ttParent() {return null;}

	/**
	 * 2017-07-30
	 * @override
	 * @see \Df\StripeClone\W\Event::roPath()
	 * @used-by \Df\StripeClone\W\Event::k_pid()
	 * @used-by \Df\StripeClone\W\Event::ro()
	 * @return string|null
	 */
	protected function roPath() {return null;}
}


