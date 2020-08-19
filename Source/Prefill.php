<?php
namespace Dfe\Moip\Source;
# 2017-06-13
final class Prefill extends \Df\Config\Source {
	/**
	 * 2017-06-13 [Moip] The test bank cards: https://mage2.pro/t/3776
	 * @override
	 * @see \Df\Config\Source::map()
	 * @used-by \Df\Config\Source::toOptionArray()
	 * @return array(string => string)
	 */
	protected function map() {return [
		0 => 'No'
		,'376449047333005' => 'American Express'
		,'36490102462661' => 'Diners Club International'
		,'6362970000457013' => 'Elo'
		,'6062825624254001' => 'Hipercard'
		,'6370950000000005' => 'Itaucard 2.0 (Cartão Hiper)'
		,'5555666677778884' => 'MasterCard'
		,'4012001037141112' => 'Visa'
	];}
}