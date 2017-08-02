<?php
namespace Dfe\Moip;
use Df\API\Operation as Op;
use Df\StripeClone\W\Event as Ev;
use Dfe\Moip\Block\Info\Boleto as BlockBoleto;
use Dfe\Moip\Block\Info\Card as BlockCard;
use Magento\Sales\Model\Order\Payment\Transaction as T;
/**
 * 2017-04-11
 * @method Op chargeNew()
 * @method Settings s()
 */
final class Method extends \Df\StripeClone\Method {
	/**
	 * 2017-07-23
	 * @used-by \Dfe\Moip\Block\Info\Card::prepare()
	 * @used-by \Dfe\Moip\P\Charge::v_CardId
	 * @return int
	 */
	function dob() {return $this->iia(self::$II_DOB);}

	/**
	 * 2017-07-30
	 * @override
	 * @see \Df\Payment\Method::getInfoBlockType()
	 * @used-by \Magento\Payment\Helper\Data::getInfoBlock():
	 *		public function getInfoBlock(InfoInterface $info, LayoutInterface $layout = null) {
	 *			$layout = $layout ?: $this->_layout;
	 *			$blockType = $info->getMethodInstance()->getInfoBlockType();
	 *			$block = $layout->createBlock($blockType);
	 *			$block->setInfo($info);
	 *			return $block;
	 *		}
	 * https://github.com/magento/magento2/blob/2.2.0-RC1.6/app/code/Magento/Payment/Helper/Data.php#L182-L196
	 * @return string
	 */
	function getInfoBlockType() {return df_cc_class_uc('Dfe\Moip\Block\Info', $this->option());}

	/**
	 * 2017-07-30
	 * @return bool
	 */
	function isBoleto() {return 'boleto' === $this->option();}

	/**
	 * 2017-07-30
	 * @override
	 * @see \Df\StripeClone\Method::isCard()
	 * @used-by \Df\StripeClone\Payer::newCard()
	 * @used-by \Dfe\Moip\P\Charge::k_Capture()
	 * @used-by \Dfe\Moip\P\Charge::k_CardId()
	 * @used-by \Dfe\Moip\P\Charge::k_DSD()
	 * @used-by \Dfe\Moip\P\Charge::p()
	 * @return bool
	 */
	function isCard() {return 'card' === $this->option();}

	/**
	 * 2017-07-30
	 * @used-by isBoleto()
	 * @used-by isCard()
	 * @used-by optionTitle()
	 * @return string
	 */
	function option() {return $this->iia(self::$II_OPTION);}

	/**
	 * 2017-08-02
	 * @used-by titleF()
	 * @used-by \Dfe\Moip\Choice::title()
	 * @used-by \Dfe\Moip\ConfigProvider::config()
	 * @param string|null $o [optional]
	 * @return string|null
	 */
	function optionTitle($o = null) {return !($o = ($o ?: $this->option())) ? null : $this->s("{$o}/title");}

	/**
	 * 2017-07-15
	 * @used-by \Dfe\Moip\Block\Info\Card::prepare()
	 * @used-by \Dfe\Moip\P\Charge::p()
	 * @return int
	 */
	function plan() {return intval($this->iia(self::$II_PLAN));}

	/**
	 * 2017-07-14
	 * 2017-07-20 It is CPF: https://en.wikipedia.org/wiki/Cadastro_de_Pessoas_Físicas
	 * @used-by \Dfe\Moip\P\Charge::pTaxDocument()
	 * @return string|null
	 */
	function taxID() {return $this->iia(self::$II_TAX_ID);}

	/**
	 * 2017-04-11
	 * @override
	 * @see \Df\Payment\Method::amountLimits()
	 * @used-by \Df\Payment\Method::isAvailable()
	 * @return null
	 */
	protected function amountLimits() {return null;}

	/**
	 * 2017-07-12
	 * @override
	 * @see \Df\StripeClone\Method::iiaKeys()
	 * @used-by \Df\Payment\Method::assignData()
	 * @return string[]
	 */
	protected function iiaKeys() {return array_merge(parent::iiaKeys(), [
		self::$II_CARDHOLDER, self::$II_DOB, self::$II_OPTION, self::$II_PLAN, self::$II_TAX_ID
	]);}

	/**
	 * 2017-08-02
	 * @override
	 * @see \Df\Payment\Method::titleF()
	 * @used-by \Df\Payment\Method::getTitle()
	 * @return string
	 */
	protected function titleF() {return $this->optionTitle() ?: parent::titleF();}

	/**
	 * 2017-04-11
	 * @override
	 * @see \Df\StripeClone\Method::transUrlBase()
	 * @used-by \Df\StripeClone\Method::transUrl()
	 * @param T $t
	 * @return string
	 */
	protected function transUrlBase(T $t) {return '';}

	/**
	 * 2017-07-12 https://github.com/mage2pro/moip/blob/0.6.8/view/frontend/web/main.js#L66-L68
	 * @used-by iiaKeys()
	 */
	private static $II_CARDHOLDER = 'cardholder';

	/**
	 * 2017-07-23
	 * @used-by dob()
	 * @used-by iiaKeys()
	 */
	private static $II_DOB = 'dob';

	/**
	 * 2017-07-30
	 * @used-by iiaKeys()
	 * @used-by option()
	 */
	private static $II_OPTION = 'option';

	/**
	 * 2017-07-15 https://github.com/mage2pro/moip/blob/0.6.8/view/frontend/web/main.js#L66-L68
	 * @used-by iiaKeys()
	 * @used-by plan()
	 */
	private static $II_PLAN = 'plan';

	/**
	 * 2017-07-12 https://github.com/mage2pro/moip/blob/0.6.8/view/frontend/web/main.js#L66-L68
	 * @used-by taxID()
	 * @used-by iiaKeys()
	 */
	private static $II_TAX_ID = 'taxID';
}