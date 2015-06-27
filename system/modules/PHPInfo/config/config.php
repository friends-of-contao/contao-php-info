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
 * Backend modules
 */
$GLOBALS['BE_MOD']['system']['PHPInfo'] = array
(
	'icon'       => 'system/modules/PHPInfo/assets/icon.png',
	'callback'   => '\PHPInfo\PHPInfo'
);
