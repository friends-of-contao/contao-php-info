<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2014 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Cliff Parnitzky 2014
 * @author     Cliff Parnitzky
 * @package    PHPInfo
 * @license    LGPL
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
		$GLOBALS['TL_CSS'][] = 'system/modules/PHPInfo/assets/backend.css';

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

			// adapt table layout
			$pinfo = str_replace('<table border="0" cellpadding="3" width="600">', '<table border="1" cellpadding="3">', $pinfo);

			// remove blank at end of table data
			$pinfo = str_replace(' </td>', '</td>', $pinfo);

			// remove a-tags from h2
			$pinfo = preg_replace('%<h2><a .*>(.*)</a></h2>%', '<h2>$1</h2>', $pinfo);

			// add div container to cell content because of overflow=auto
			$pinfo = preg_replace('%<td class="v">(.*?)</td>%', '<td class="v"><div class="scroll">$1</div></td>', $pinfo);
			$pinfo = preg_replace('%<td class="e">(.*?)</td>%', '<td class="v"><div class="scroll">$1</div></td>', $pinfo);

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
?>