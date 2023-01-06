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
 * @method Settings s($k = null, $s = null, $d = null)
 */
final class Method extends \Df\StripeClone\Method {
	/**
	 * 2017-07-23
	 * @used-by \Dfe\Moip\Block\Info\Card::prepare()
	 * @used-by \Dfe\Moip\P\Charge::v_CardId
	 */
	function dob():int {return $this->iia(self::$II_DOB);}

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
	 */
	function getInfoBlockType():string {return df_cc_class_uc('Dfe\Moip\Block\Info', $this->option());}

	/**
	 * 2017-07-30
	 * @used-by \Dfe\Moip\Block\Info\Boleto::msgCheckoutSuccess()
	 */
	function isBoleto():bool {return 'boleto' === $this->option();}

	/**
	 * 2017-07-30
	 * @override
	 * @see \Df\StripeClone\Method::isCard()
	 * @used-by \Df\StripeClone\Payer::newCard()
	 * @used-by \Dfe\Moip\P\Charge::k_Capture()
	 * @used-by \Dfe\Moip\P\Charge::k_CardId()
	 * @used-by \Dfe\Moip\P\Charge::k_DSD()
	 * @used-by \Dfe\Moip\P\Charge::p()
	 */
	function isCard():bool {return 'card' === $this->option();}

	/**
	 * 2017-07-30
	 * @used-by self::isBoleto()
	 * @used-by self::isCard()
	 * @used-by self::optionTitle()
	 */
	function option():string {return $this->iia(self::$II_OPTION);}

	/**
	 * 2017-08-02
	 * @used-by self::titleF()
	 * @used-by \Dfe\Moip\Choice::title()
	 * @used-by \Dfe\Moip\ConfigProvider::config()
	 * @param string|null $o [optional]
	 */
	function optionTitle($o = null):string {return !($o = ($o ?: $this->option())) ? '' : $this->s("$o/title");}

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
	protected function iiaKeys():array {return array_merge(parent::iiaKeys(), [
		self::$II_CARDHOLDER, self::$II_DOB, self::$II_OPTION, self::$II_PLAN, self::$II_TAX_ID
	]);}

	/**
	 * 2017-08-02
	 * @override
	 * @see \Df\Payment\Method::titleF()
	 * @used-by \Df\Payment\Method::getTitle()
	 */
	protected function titleF():string {return $this->optionTitle() ?: parent::titleF();}

	/**
	 * 2017-04-11
	 * @override
	 * @see \Df\StripeClone\Method::transUrlBase()
	 * @used-by \Df\StripeClone\Method::transUrl()
	 * @param T $t
	 */
	protected function transUrlBase(T $t):string {return '';}

	/**
	 * 2017-07-12 https://github.com/mage2pro/moip/blob/0.6.8/view/frontend/web/main.js#L66-L68
	 * @used-by self::iiaKeys()
	 */
	private static $II_CARDHOLDER = 'cardholder';

	/**
	 * 2017-07-23
	 * @used-by self::dob()
	 * @used-by self::iiaKeys()
	 */
	private static $II_DOB = 'dob';

	/**
	 * 2017-07-30 https://github.com/mage2pro/core/blob/2.12.17/Payment/view/frontend/web/withOptions.js#L56-L72
	 * @used-by self::iiaKeys()
	 * @used-by self::option()
	 */
	private static $II_OPTION = 'option';

	/**
	 * 2017-07-15 https://github.com/mage2pro/moip/blob/0.6.8/view/frontend/web/main.js#L66-L68
	 * @used-by self::iiaKeys()
	 * @used-by self::plan()
	 */
	private static $II_PLAN = 'plan';

	/**
	 * 2017-07-12 https://github.com/mage2pro/moip/blob/0.6.8/view/frontend/web/main.js#L66-L68
	 * @used-by self::taxID()
	 * @used-by self::iiaKeys()
	 */
	private static $II_TAX_ID = 'taxID';
}