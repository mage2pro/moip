<?php
namespace Dfe\Moip\P;
use Dfe\Moip\API\Option;
use Geocoder\Model\Address as GA;
use Magento\Sales\Model\Order\Address as A;
/**
 * 2017-06-11
 * @method \Dfe\Moip\Method m()
 * @method \Dfe\Moip\Settings s()
 */
final class Charge extends \Df\StripeClone\P\Charge {
	/**
	 * 2017-06-11
	 * 2017-10-09 The key name of a bank card token or of a saved bank card ID.
	 * https://github.com/mage2pro/moip/blob/0.4.4/T/CaseT/Payment.php#L46-L49
	 * @override
	 * @see \Df\StripeClone\P\Charge::k_CardId()
	 * @used-by \Df\StripeClone\P\Charge::request()
	 * @return string
	 */
	function k_CardId() {return $this->m()->isCard() ? 'fundingInstrument' : null;}

	/**
	 * 2017-07-17
	 * @override
	 * @see \Df\StripeClone\P\Charge::k_Excluded()
	 * @used-by \Df\StripeClone\P\Charge::request()
	 * @return string[]
	 */
	protected function k_Excluded() {return [
		parent::K_AMOUNT, parent::K_CUSTOMER_ID, parent::K_CURRENCY, parent::K_DESCRIPTION
	];}

	/**
	 * 2017-04-25
	 * «The Address is the set of data that represents a location:
	 * 	*) associated with the Customer as the delivery address («shippingAddress»)
	 * 	*) or associated with the Credit Card as the billing address («billingAddress»).»
	 * https://dev.moip.com.br/v2.0/reference#endereco
	 * @used-by v_CardId()
	 * @used-by \Dfe\Moip\P\Reg::p()
	 * @param A $a
	 * @return array(string => mixed)
	 */
	function pAddress(A $a) {
		/** @var GA $ga */
		$ga = df_geo($this->s()->googlePrivateKey(), 'pt-BR', 'br')->p($a);
		return [
			# 2017-04-23 «City», Required, String(32).
			'city' => self::u(df_geo_city($ga))
			# 2017-04-23 «Address complement», Conditional, String(45).
			,'complement' => ''
			# 2017-04-23 «Country in format ISO-alpha3, example BRA», Required, String(3).
			# 2017-04-25
			# «Today we do not support creating clients that are from other countries
			# that are not from Brazil, so this error occurs.
			# We do not have a forecast to be international.»
			# https://mage2.pro/t/3820/2
			,'country' => df_country_2_to_3('BR')
			# 2017-04-23 «Neighborhood», Required, String(45).
			,'district' => self::u($ga->getLocality() ?: $ga->getSubLocality())
			# 2017-04-23 «State», Required, String(32).
			,'state' => self::u(df_geo_state_code($ga))
			# 2017-04-25 «Address post office», Required, String(45).
			,'street' => self::u($ga->getStreetName())
			# 2017-04-23 «Number», Required, String(10).
			,'streetNumber' => self::u($ga->getStreetNumber())
			# 2017-04-23 «The zip code of the billing address», Required, String(9).
			,'zipCode' => $ga->getPostalCode()
		];
	}

	/**
	 * 2017-06-12
	 * @see \Dfe\Moip\Test\Data::taxDocument()
	 * @used-by v_CardId()
	 * @used-by \Dfe\Moip\P\Reg::p()
	 * @return array(string => mixed)
	 */
	function pTaxDocument() {return [
		# 2017-04-23 «Document number»,  String(11).
		'number' => $this->m()->taxID()
		# 2017-04-23
		# «Document type. Possible values:
		# *) CPF for social security number
		# *) CNPJ for tax identification number.»
		# String(4).
		# 2017-06-13
		# CPF: Cadastro de Pessoas Físicas (an individual's ID)
		# https://en.wikipedia.org/wiki/Cadastro_de_Pessoas_Físicas
		# CNPJ: Cadastro Nacional da Pessoa Jurídica (a company's ID)
		# https://en.wikipedia.org/wiki/CNPJ
		,'type' => 'CPF'
	];}

	/**
	 * 2017-06-11
	 * @override
	 * @see \Df\StripeClone\P\Charge::v_CardId()
	 * @used-by \Df\StripeClone\P\Charge::request()
	 * @used-by \Dfe\Moip\P\Reg::v_CardId()
	 * @param string $id
	 * @param bool $isNew
	 * @return array(string => mixed)
	 */
	function v_CardId($id, $isNew) {return [
		# 2017-06-09
		# «Credit Card data. It can be:
		# *) the ID of a credit card previously saved,
		# *) an encrypted credit card hash
		# *) the whole collection of credit card attributes (in case you have PCI DSS certificate).»
		# [Moip] The test bank cards: https://mage2.pro/t/3776
		//
		# hash: «Encrypted credit card data»
		# Conditional, String.
		# https://dev.moip.com.br/v2.0/docs/criptografia
		//
		# id: «Credit card ID.
		# This ID can be used in the future to create new payments. Internal reference.»
		# Conditional, String(16).
		//
		# 2017-06-13
		# A hash is a very long (345 symbols) base64-encoded string.
		# http://moip.github.io/moip-sdk-js
		# A card ID looks like «CRC-M423RWG3PK7J».
		'creditCard' => [
			!$isNew ? 'id' : 'hash' => $id
			# 2017-06-09
			# «Do not send when the request is using credit card id»
			# Conditional, String.
			,'holder' => [
				# 2017-06-09 «Billing address». Optional.
				'billingAddress' => $this->pAddress($this->addressB())
				# 2017-06-09 «date(AAAA-MM-DD)». Required.
				,'birthdate' => $this->m()->dob()
				# 2017-06-09
				# «Name of the carrier printed on the card»
				# Required, String(90).
				,'fullname' => $this->customerName()
				# 2017-06-09
				# «Phone number»
				# It is required for the Protected Sales Program:
				# https://dev.moip.com.br/v2.0/docs/venda-protegida
				,'phone' => dfe_moip_phone($this->customerPhone())
				# 2017-06-09 «Document»
				,'taxDocument' => $this->pTaxDocument()
			]
			# 2017-06-09
			# Whether the card should be saved for future payments.
			# https://moip.com.br/blog/compra-com-um-clique
			# Default: true
			# Boolean.
			,'store' => true
		]
		# 2017-06-09
		# «Method used. Possible values: CREDIT_CARD, BOLETO, ONLINE_BANK_DEBIT, WALLET»
		# Required, String.
		,'method' => Option::BANK_CARD
	];}

	/**
	 * 2017-06-12
	 * @override
	 * @see \Df\StripeClone\P\Charge::inverseCapture()
	 * @used-by \Df\StripeClone\P\Charge::request()
	 * @return bool
	 */
	protected function inverseCapture() {return true;}

	/**
	 * 2017-06-12
	 * @override
	 * @see \Df\StripeClone\P\Charge::k_Capture()
	 * @used-by \Df\StripeClone\P\Charge::request()
	 * @return string
	 */
	protected function k_Capture() {return $this->m()->isCard() ? 'delayCapture' : null;}

	/**
	 * 2017-06-11 https://github.com/mage2pro/moip/blob/0.4.2/T/CaseT/Payment.php#L50-L53
	 * 2017-07-21
	 * 1) `[Moip] The «Dynamic statement descripor» feature`: https://mage2.pro/t/4203
	 * 2) `Implement the dynamic statement descripor («statementDescriptor») feature
	 * for the bank card payments` https://github.com/mage2pro/moip/issues/6
	 * @override
	 * @see \Df\StripeClone\P\Charge::k_DSD()
	 * @used-by \Df\StripeClone\P\Charge::request()
	 * @return string
	 */
	protected function k_DSD() {return $this->m()->isCard() ? 'statementDescriptor' : null;}

	/**
	 * 2017-07-15
	 * @override
	 * @see \Df\StripeClone\P\Charge::p()
	 * @used-by \Df\StripeClone\P\Charge::request()
	 * @return array(string => mixed)
	 */
	protected function p() {return $this->m()->isCard() ? [
		/**
		 * 2017-07-15
		 * «Número de parcelas.
		 * Válido para pagamentos por cartão.
		 * Se não for informado, o pagamento será realizado em 1 parcela.
		 * Mínimo 1 e Máximo 12.»
		 * https://dev.moip.com.br/v2.0/reference#criar-pagamento
		 */
		'installmentCount' => $this->m()->plan()
	] : [
		'fundingInstrument' => [
			# 2017-07-24
			# «Payment slip attributes»
			# «Dados do boleto utilizado no pagamento»
			'boleto' => [
				# 2017-07-24
				# «Payment slip expiration date»
				# «Data de expiração de um boleto»
				# Required, yyyy-mm-dd.
				'expirationDate' => df_today_add($this->s()->boleto()->waitPeriod())->toString('y-MM-dd')
				# 2017-07-24
				# «Payment slip instructions»
				# «Instruções impressas no boleto»
				,'instructionLines' => $this->pInstructionLines()
			]
			# 2017-06-09
			# «Method used. Possible values: CREDIT_CARD, BOLETO, ONLINE_BANK_DEBIT, WALLET»
			# Required, String.
			,'method' => Option::BOLETO
		]
	];}

	/**
	 * 2017-07-30
	 * @used-by p()
	 * @return array(string => string)
	 */
	private function pInstructionLines() {
		/** @var string[] $a */
		$a = array_slice(df_explode_n($this->text($this->s()->boleto()->instructions())), 0, 3);
		return array_combine(array_slice(['first', 'second', 'third'], 0, count($a)), $a);
	}

	/**
	 * 2017-04-25
	 * @used-by pShippingAddress()
	 * @param mixed $v
	 * @return string
	 */
	private static function u($v) {return $v ?: (string)__('Unknown');}
}