<?php
namespace Dfe\Moip\Block\Info;
use Dfe\Moip\Method as M;
/**
 * 2017-07-30
 * @final Unable to use the PHP «final» keyword here because of the M2 code generation.
 * @used-by \Dfe\Moip\Method::getInfoBlockType()
 * @method M m()
 */
class Boleto extends \Df\Payment\Block\Info {
	/**
	 * 2017-07-30
	 * @override
	 * @see \Df\Payment\Block\Info::prepare()
	 * @used-by \Df\Payment\Block\Info::_prepareSpecificInformation()
	 * @used-by \Dfe\Moip\Block\Info\Card::prepare()
	 */
	final protected function prepare() {
		$res0 = $this->tm()->res0(); /** @var array(string => mixed) */
		$url = $res0['_links']['payBoleto']['redirectHref']; /** @var string $url */
		if ($this->extended()) {
			$this->si([
				'Payment Option' => 'Boleto bancário'
				,'Payment Slip' => df_tag_ab($res0['id'], $url)
			]);
		}
		else {
			$this->si(null, df_tag_ab(__('Print the boleto'), "$url/print"));
		}
	}
}