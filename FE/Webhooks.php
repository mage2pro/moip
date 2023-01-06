<?php
namespace Dfe\Moip\FE;
use Df\Framework\Form\ElementI;
use Dfe\Moip\API\Facade\Notification as N;
use Magento\Framework\Data\Form\Element\AbstractElement as AE;
# 2017-08-09
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
	final function onFormInitialized():void {
		/**
		 * 2017-06-27
		 * This code removes the «[store view]» sublabel, similar to
		 * @see \Magento\MediaStorage\Block\System\Config\System\Storage\Media\Synchronize::render()
		 */
		$this->unsetData(['can_use_default_value', 'can_use_website_value', 'scope']);
		/**
		 * 2017-08-10
		 * There are 3 possible cases:
		 * Case 1) One or both the private keys are not set:
		 * 		a) The «Token» part of your Test Private Key (Chave de autenticação)
		 * 		b) The «Key» (Chave) part of your Test Private Key (Chave de autenticação)
		 * In this case we should show the message to the administrator:
		 * «Please set your Moip private keys first to the fields above.».
		 * Case 2) The both private keys are set, but there are no webhooks yet.
		 * In this case we should show the message to the administrator:
		 * «The proper webhook will be automatically set up on the config saving.
		 * Please press the `Save Config` button for it.».
		 * Case 3) The both private keys are set, but there are webhooks.
		 * In this case we just show the webhooks to the administrator.
		 */
		$p = df_b(['test', 'live'], df_bool(df_fe_sibling_v($this, 'test'))); /** @var string $p */
		$enabled = df_bool(df_fe_sibling_v($this, 'enable')); /** @var bool $enabled */
		/**
		 * 2017-10-19
		 * `The GET «https://sandbox.moip.com.br/v2/preferences/notifications» API endpoint
		 * is down today (2017-10-19):
		 * «502 Proxy Error: The proxy server received an invalid response from an upstream server».
		 * We should handle this in a proper way`: https://github.com/mage2pro/moip/issues/21
		 */
		list($down, $urls) =
			!$enabled
			|| !df_fe_sibling_v($this, "{$p}PrivateToken")
			|| !df_fe_sibling_v($this, "{$p}PrivateKey")
			?  [false, null]
			: df_try(function() {return [false, (new N)->targets()];}, function() {return [true, null];})
		; /** @var bool $down */ /** @var string[] $urls */
		df_fe_init($this, __CLASS__, [], ['down' => $down, 'enabled' => $enabled, 'urls' => $urls]);
	}
}