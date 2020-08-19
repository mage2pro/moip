<?php
namespace Dfe\Moip;
use Magento\Framework\Phrase;
# 2017-08-02
/** @method \Dfe\Moip\Method m() */
final class Choice extends \Df\Payment\Choice {
	/**
	 * 2017-08-02
	 * @override
	 * @see \Df\Payment\Choice::title()
	 * @used-by \Df\Payment\Block\Info::choiceT()
	 * @used-by \Df\Payment\Observer\DataProvider\SearchResult::execute()
	 * @return Phrase|string|null
	 */
	function title() {return $this->m()->optionTitle();}
}