<?php
/*                                                                       *
 * Copyright 2014 Georg Großberger <contact@grossberger-ge.org           *
 *                                                                       *
 * This is free software; you can redistribute it and/or modify it under *
 * the terms of the MIT- / X11 - License                                 *
 *                                                                       */

// Overwrite table flexform with our own
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue('*', 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/plugin_table.xml', 'table');

// TypoScript
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript/', 'Better Tables');

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
