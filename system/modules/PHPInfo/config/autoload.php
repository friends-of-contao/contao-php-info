<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package PHPInfo
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'PHPInfo',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'PHPInfo\PHPInfo' => 'system/modules/PHPInfo/classes/PHPInfo.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'be_PHPInfo' => 'system/modules/PHPInfo/templates',
));
