<?php
/*                                                                     *
 * This file is brought to you by Georg Großberger                     *
 * (c) 2013 by Georg Großberger <contact@grossberger-ge.org>           *
 *                                                                     *
 * It is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License, either version 3       *
 * of the License, or (at your option) any later version.              *
 *                                                                     */

// Insert our own flexform
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('*', 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/plugin_table.xml', 'table');

// Typoscript overrides
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/Typoscript/', 'Better Tables');

// Remove obsolete items from tt_content, eg cellspacing
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('
	TCEFORM.tt_content {
		cols.types.table.disabled = 1
		table_bgColor.types.table.disabled = 1
		table_border.types.table.disabled = 1
		table_cellspacing.types.table.disabled = 1
		table_cellpadding.types.table.disabled = 1
	}
');
