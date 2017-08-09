<?php
namespace Dfe\Moip\FE;
use Df\Framework\Form\ElementI;
use Magento\Framework\Data\Form\Element\AbstractElement as AE;
// 2017-08-09
/** @final Unable to use the PHP «final» keyword here because of the M2 code generation. */
class Webhooks extends AE implements ElementI {
	/**
	 * 2017-08-09
	 * @final Unable to use the PHP «final» keyword here because of the M2 code generation.
	 * 'id' => $this->getId() нужно для совместимости с 2.0.6,
	 * иначе там сбой в выражении inputs = $(idTo).up(this._config.levels_up)
	 * https://mail.google.com/mail/u/0/#search/maged%40wrapco.com.au/15510135c446afdb
	 * @override
	 * @see \Magento\Framework\Data\Form\Element\AbstractElement::getElementHtml()
	 * @used-by \Magento\Framework\Data\Form\Element\AbstractElement::getDefaultHtml():
	 *		public function getDefaultHtml() {
	 *			$html = $this->getData('default_html');
	 *			if ($html === null) {
	 *				$html = $this->getNoSpan() === true ? '' : '<div class="admin__field">' . "\n";
	 *				$html .= $this->getLabelHtml();
	 *				$html .= $this->getElementHtml();
	 *				$html .= $this->getNoSpan() === true ? '' : '</div>' . "\n";
	 *			}
	 *			return $html;
	 *		}
	 * https://github.com/magento/magento2/blob/2.2.0-RC1.8/lib/internal/Magento/Framework/Data/Form/Element/AbstractElement.php#L426-L441
	 * @return string
	 */
	function getElementHtml() {return df_tag('div', ['id' => $this->getHtmlId()]);}

	/**
	 * 2017-08-09
	 * @override
	 * @see \Df\Framework\Form\ElementI::onFormInitialized()
	 * @used-by \Df\Framework\Plugin\Data\Form\Element\AbstractElement::afterSetForm()
	 */
	final function onFormInitialized() {
		/**
		 * 2017-06-27
		 * This code removes the «[store view]» sublabel, similar to
		 * @see \Magento\MediaStorage\Block\System\Config\System\Storage\Media\Synchronize::render()
		 */
		$this->_data = dfa_unset($this->_data, 'scope', 'can_use_website_value', 'can_use_default_value');
		df_fe_init($this, __CLASS__, [], [
			'urls' => ['https://yandex.ru', 'https://www.google.com', 'https://rambler.ru']
		]);
	}
}