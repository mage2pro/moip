<?php
namespace Dfe\Moip\T;
use Dfe\Moip\SDK\Order as lO;
use Magento\Sales\Model\Order as O;
use Magento\Sales\Model\Order\Item as OI;
use Moip\Exceptions\UnautorizedException as leUnautorized;
use Moip\Exceptions\UnexpectedException as leUnexpected;
use Moip\Exceptions\ValidationException as leValidation;
// 2017-06-08
// https://dev.moip.com.br/page/api-reference#section-orders
// https://dev.moip.com.br/v2.0/reference#pedidos
final class Order extends TestCase {
	/** 2017-06-08 */
	function t00() {}

	/** @test 2017-06-08 */
	function t01_create() {
		try {
			echo lO::create($this->pOrder())->j();
			//echo df_json_encode_pretty($this->pOrder());
		}
		catch (\Exception $e) {
			/** @var \Exception|leUnautorized|leUnexpected|leValidation $e */
			xdebug_break();
			throw $e;
		}
	}

	/**
	 * 2017-06-09
	 * @param float $v
	 * @return int
	 */
	private function amount($v) {return round(100 * df_currency_convert(
		$v, df_oq_currency($this->o())->getCode(), 'BRL'
	));}

	/**
	 * 2017-06-09
	 * A positive result is treated as the surcharge.
	 * A negative result is treated as a discount.
	 * @return int
	 */
	private function amountMargin() {return dfc($this, function() {return
		$this->amount($this->o()->getGrandTotal())
		- array_sum(array_map(function(array $i) {return $i['quantity'] * $i['price'];}, $this->pItems()))
		- $this->amountShipping()
	;});}

	/**
	 * 2017-06-09
	 * @return int
	 */
	private function amountShipping() {return dfc($this, function() {return $this->amount(
		df_oq_shipping_amount($this->o())
	);});}

	/**
	 * 2017-06-09
	 * @return O
	 */
	private function o() {return dfc($this, function() {return df_order(539);});}

	/**
	 * 2017-06-09
	 * «Order values»
	 * My notes: the order amount is calculated automatically by Moip.
	 * @used-by pOrder()
	 * @return array(string => mixed)
	 */
	private function pAmount() {/** @var int $m */$m = $this->amountMargin(); return [
		// 2017-06-09
		// «Currency used in the order. Possible values: BRL. Default value BRL.»
		// Optional, String.
		'currency' => 'BRL'
		// 2017-06-09
		// «Structure of additional order values.»
		// Optional, String.
		,'subtotals' => [
			// 2017-06-09
			// «Addition amount. It will be added to the items amount. In cents.»
			// Optional, Integer(12).
			'addition' => max(0, $m)
			// 2017-06-09
			// «Discount amount. This value will be deducted from the total amount. In cents.»
			// Optional, Integer(12).
			,'discount' => -min(0, $m)
			// 2017-06-09
			// «Shipping cost. It will be added to the items amount. In cents.»
			// Optional, Integer(12).
			,'shipping' => $this->amount(df_oq_shipping_amount($this->o()))
		]
	];}

	/**
	 * 2017-06-09
	 * «Checkout setup»
	 * @used-by pOrder()
	 * @return array(string => mixed)
	 */
	private function pCheckoutPreferences() {return [
		// 2017-06-09 «Installments setup»
		//'installments' => [$this->pInstallment()],
		// 2017-06-09 «Redirect URLs»
		'redirectUrls' => [
			// 2017-06-09
			// «Redirect URL for failed payments»
			// Optional, Link.
			'urlFailure' => dfp_url_customer_return_remote($this->m())
			// 2017-06-09
			// «Redirect URL for successful payments»
			// Optional, Link.
			,'urlSuccess' => dfp_url_customer_return_remote($this->m())
		]
	];}

	/**
	 * 2017-06-09
	 * «Customer.
	 * It can be an ID for a customer previously created
	 * or the collection of attributes to create a new one.»
	 * @used-by pOrder()
	 * @return array(string => mixed)
	 */
	private function pCustomer() {return [
		// 2017-06-09
		// «If you use an existing client, pass the client's moip ID here.
		// To create a new client, see the format of the object in Client».
		// Optional.
		// My notes: An example of the value: «CUS-UKXT2RQ2TULX».
		'id' => 'CUS-UKXT2RQ2TULX'
	];}

	/**
	 * 2017-06-09
	 * @used-by pCheckoutPreferences()
	 * @return array(string => mixed)
	 */
	private function pInstallment() {return [
		// 2017-06-09
		// «Addition for installments number»
		// Optional, Integer.
		'addition' => ''
		// 2017-06-09
		// «Discount for installments number»
		// Optional, Integer.
		,'discount' => ''
		// 2017-06-09
		// «Delimiters for installments. Example: [1, 3];»
		// Optional, Array of integers.
		,'quantity' => []
	];}

	/**
	 * 2017-06-09
	 * My notes: All the fields below are required for the Protected Sales Program:
	 * https://dev.moip.com.br/v2.0/docs/venda-protegida
	 * @used-by pOrder()
	 * @return array(string => mixed)
	 */
	private function pItems() {return dfc($this, function() {return
		df_oqi_leafs($this->o(), function($i) {/** @var OI $i */ return [
			// 2017-06-09
			// «Description»
			// Optional, String(250).
			'detail' => df_oqi_desc($i, 250)
			// 2017-06-09
			// «Price of 1 product. (The value is multiplied according to the number of products.).
			// In cents.»
			// Required, Integer(12).
			,'price' => $this->amount(df_oqi_price($i, true))
			// 2017-06-09
			// «Product name»
			// Required, String(256).
			,'product' => $i->getName()
			// 2017-06-09
			// «Quantity of products»
			// Required, Integer(12).
			,'quantity' => df_oqi_qty($i)
		];})
	;});}

	/**
	 * 2017-06-08
	 * @used-by t01_create()
	 * @return array(string => mixed)
	 */
	private function pOrder() {return [
		// 2017-06-09
		// «Order values»
		// My notes: the order amount is calculated automatically by Moip.
		'amount' => $this->pAmount()
		// 2017-06-09 «Checkout setup»
		,'checkoutPreferences' => $this->pCheckoutPreferences()
		// 2017-06-09
		// «Customer.
		// It can be an ID for a customer previously created
		// or the collection of attributes to create a new one.»
		// Required.
		,'customer' => $this->pCustomer()
		// 2017-06-09 «Items structure»
		,'items' => $this->pItems()
		// 2017-06-09
		// «Own id of an order. External reference.»
		// Required, String(66).
		,'ownId' => df_uid(4, 'admin@mage2.pro-')
		// 2017-06-09
		// «Structure of recipients of payments.
		// Used to define commissioning on Marketplaces deployments.»
		//,'receivers' => [$this->pReceiver()]
	];}

	/**
	 * 2017-06-09
	 * @used-by pOrder()
	 * @return array(string => mixed)
	 */
	private function pReceiver() {return [
		// 2017-06-09
		// «Flag to set whether the recipient is the Moip rate payer.
		// Possible values: true, false.
		// If the feePayor is not informed, the recipient type PRIMARY will be the Moip rate payer.
		// If there is more than one SECONDARY type receiver,
		// only one can be the payer of the rate.»
		// Boolean.
		'feePayor' => ''
		// 2017-06-09
		// «Moip Account Receiving Payment»
		,'moipAccount' => [
			// 2017-06-09 «Structure of the amount to be received»
			'amount' => [
				// 2017-06-09
				// «Fixed amount to be sent to a receiver»
				// Optional, Integer(12).
				'fixed' => ''
				// 2017-06-09
				// «Percentual amount to be sent to a receiver»
				// Optional, Integer(12).
				,'percentual' => ''
			]
			// 2017-06-09
			// «Account ID»
			// Optional, String(16).
			,'id' => ''
		]
		// 2017-06-09
		// «Receiver type. Possible values: PRIMARY, SECONDARY.»
		// Conditional, String.
		,'type' => 'PRIMARY'
	];}
}