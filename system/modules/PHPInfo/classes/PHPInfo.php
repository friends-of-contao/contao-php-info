<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @copyright  Cliff Parnitzky 2014
 * @author     Cliff Parnitzky
 * @author     Christoph Krebs
 * @package    PHPInfo
 * @license    LGPL-3.0+
 * @filesource [phpinfo] by Christian Steurer (Russe)
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace PHPInfo;


/**
 * Class PHPInfo
 *
 * Call phpinfo in the template.
 * @copyright  Cliff Parnitzky 2014
 * @author     Cliff Parnitzky
 * @package    Controller
 */
class PHPInfo extends \BackendModule
{
	protected $strTemplate = 'be_PHPInfo';

	public function compile()
	{
		// check if phpinfo() is disabled
		$this->Template->disableFunctions = $this->isDisabled('disable_functions');
		$this->Template->suhosinBlacklist = $this->isDisabled('suhosin.executor.func.blacklist');

		if (!$this->Template->disableFunctions && !$this->Template->suhosinBlacklist)
		{
			ob_start();
			phpinfo();
			$pinfo = ob_get_clean();

			// get content of phpinfo only
			$pinfo = preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', $pinfo);

			if (version_compare(PHP_VERSION, '5.6.0', '<'))
			{
				// adjust table layout
				$pinfo = str_replace('<table border="0" cellpadding="3" width="600">', '<table>', $pinfo);
			}

			// remove blank at end of table data
			$pinfo = str_replace(' </td>', '</td>', $pinfo);

			// remove a-tags from h2
			$pinfo = preg_replace('%<h2><a .*>(.*)</a></h2>%', '<h2>$1</h2>', $pinfo);

			// add div container to cell content because of overflow=auto
			$pinfo = preg_replace('%<td class="([ev])">(.*?)</td>%', '<td class="$1"><div class="scroll">$2</div></td>', $pinfo);

			$this->Template->pinfo = $pinfo;
		}

		$this->Template->class = 'v'.PHP_MAJOR_VERSION.PHP_MINOR_VERSION;
	}


	/**
	 * Check if phpinfo() is disabled
	 * @param string
	 * @return boolean
	 */
	public function isDisabled($directive)
	{
		$strValues = ini_get($directive);
		if (in_array('phpinfo', preg_split('%,\s*%', $strValues)))
		{
			return true;
		}
		return false;
	}
}
