<?php
namespace Dfe\Moip\P;
use Df\StripeClone\Payer;
use Magento\Sales\Model\Order\Item as OI;
# 2017-06-12
final class Preorder extends \Df\StripeClone\P\Preorder {
	/**
	 * 2017-06-12
	 * @override
	 * @see \Df\StripeClone\P\Preorder::p()
	 * @used-by \Df\StripeClone\P\Preorder::request()
	 * @return array(string => mixed)
	 */
	protected function p():array {return [
		# 2017-06-09
		# «Order values»
		# My notes: the order amount is calculated automatically by Moip.
		'amount' => $this->pAmount()
		# 2017-06-09 «Checkout setup»
		,'checkoutPreferences' => $this->pCheckoutPreferences()
		# 2017-06-09
		# «Customer.
		# It can be an ID for a customer previously created
		# or the collection of attributes to create a new one.»
		# Required.
		# «If you use an existing client, pass the client's moip ID here.
		# To create a new client, see the format of the object in Client».
		# Optional.
		# My notes: An example of the value: «CUS-UKXT2RQ2TULX».
		,'customer' => ['id' => Payer::s($this->m())->customerId()]
		# 2017-06-09 «Items structure»
		,'items' => $this->pItems()
		# 2017-06-09
		# «Own id of an order. External reference.»
		# Required, String(66).
		,'ownId' => $this->id()
	];}

	/**
	 * 2017-06-09
	 * A positive result is treated as the surcharge.
	 * A negative result is treated as a discount.
	 * @used-by self::pAmount()
	 * @return int
	 */
	private function amountMargin():int {return
		$this->amountFormat($this->o()->getGrandTotal())
		- array_sum(array_map(function(array $i) {return $i['quantity'] * $i['price'];}, $this->pItems()))
		- $this->amountShipping()
	;}

	/**
	 * 2017-06-09
	 * @used-by self::amountMargin()
	 */
	private function amountShipping():int {return $this->amountFormat(df_oq_shipping_amount($this->o()));}

	/**
	 * 2017-06-09
	 * «Order values»
	 * My notes: the order amount is calculated automatically by Moip.
	 * @used-by self::p()
	 * @return array(string => mixed)
	 */
	private function pAmount() {/** @var int $m */$m = $this->amountMargin(); return [
		# 2017-06-09
		# «Currency used in the order. Possible values: BRL. Default value BRL.»
		# Optional, String.
		# 2017-06-12 https://github.com/mage2pro/moip/blob/0.4.7/etc/config.xml#L20
		'currency' => $this->currencyC()
		# 2017-06-09
		# «Structure of additional order values.»
		# Optional, String.
		,'subtotals' => [
			# 2017-06-09
			# «Addition amount. It will be added to the items amount. In cents.»
			# Optional, Integer(12).
			'addition' => max(0, $m)
			# 2017-06-09
			# «Discount amount. This value will be deducted from the total amount. In cents.»
			# Optional, Integer(12).
			,'discount' => -min(0, $m)
			# 2017-06-09
			# «Shipping cost. It will be added to the items amount. In cents.»
			# Optional, Integer(12).
			,'shipping' => $this->amountFormat(df_oq_shipping_amount($this->o()))
		]
	];}

	/**
	 * 2017-06-09 «Checkout setup»
	 * @used-by self::p()
	 * @return array(string => mixed)
	 */
	private function pCheckoutPreferences() {return ['redirectUrls' => array_fill_keys(
		# 2017-06-09
		# «Redirect URL for failed payments»
		# «Redirect URL for successful payments»
		# Optional, Link.
		['urlFailure', 'urlSuccess'], $this->customerReturnRemote()
	)];}

	/**
	 * 2017-06-09
	 * All the fields below are required for the Protected Sales Program:
	 * https://dev.moip.com.br/v2.0/docs/venda-protegida
	 * @used-by self::amountMargin()
	 * @used-by self::p()
	 * @return array(string => mixed)
	 */
	private function pItems() {return dfc($this, function() {return $this->oiLeafs(function(OI $i) {return [
		# 2017-06-09
		# «Description»
		# Optional, String(250).
		'detail' => df_oqi_desc($i, 250)
		# 2017-06-09
		# «Price of 1 product. (The value is multiplied according to the number of products.).
		# In cents.»
		# Required, Integer(12).
		,'price' => $this->amountFormat(df_oqi_price($i, true))
		# 2017-06-09
		# «Product name»
		# Required, String(256).
		,'product' => $i->getName()
		# 2017-06-09
		# «Quantity of products»
		# Required, Integer(12).
		,'quantity' => df_oqi_qty($i)
	];});});}
}