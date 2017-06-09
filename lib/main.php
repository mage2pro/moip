<?php
/**
 * 2017-06-09
 * @used-by \Dfe\Moip\T\Data::phone()
 * @param string $s
 * @return array(string => int|string)
 */
function dfe_moip_phone($s) {return dfcf(function($s) {/** @var array(string => string)|null $a */return
	!($a = df_phone_explode([$s, 'BR'], false)) || 3 > count($a) || 55 !== intval($a[0]) ? [] :
		array_combine([
			// 2017-04-25 «Your phone's local code (DDD)», Integer(2).
			'areaCode'
			// 2017-04-25 «ID number of the phone. Possible values: 55.», Integer(2).
			,'countryCode'
			// 2017-04-25 «Telephone number.», Integer(9).
			,'number'
		], $a)
;}, [$s]);}