<?php
namespace Dfe\Moip\Backend;
use Dfe\Moip\Settings as S;
// 2017-08-07
/** @final Unable to use the PHP «final» keyword here because of the M2 code generation. */
class Enable extends \Df\Config\Backend\Checkbox {
	/**
	 * 2017-08-07
	 * @override
	 * @see \Df\Config\Backend::dfSaveAfter()
	 * @used-by \Df\Config\Backend::save()
	 */
	final protected function dfSaveAfter() {
		parent::dfSaveAfter();
		//df_cache_clean();
		//$s = dfps($this); /** @var S $s */
		// 2017-08-07 @todo We can register a webhook here.
	}
}