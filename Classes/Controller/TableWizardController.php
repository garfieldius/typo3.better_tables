<?php
/*                                                                     *
 * This file is brought to you by Georg Großberger                     *
 * (c) 2013 by Georg Großberger <contact@grossberger-ge.org>           *
 *                                                                     *
 * It is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License, either version 3       *
 * of the License, or (at your option) any later version.              *
 *                                                                     */

namespace GeorgGrossberger\BetterTables\Controller;

use TYPO3\CMS\Backend\Controller\Wizard\TableController;
use TYPO3\CMS\Backend\Utility\IconUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Controller for the table wizard
 *
 * @package GeorgGrossberger.BetterTables
 * @author Georg Großberger <contact@grossberger-ge.org>
 * @copyright 2013 by Georg Großberger
 * @license GPL v3 http://www.gnu.org/licenses/gpl-3.0.txt
 */
class TableWizardController extends TableController {

	/**
	 * @param array $cfgArr
	 * @param array $row
	 * @return string
	 */
	public function getTableHTML($cfgArr, $row) {

		// Make sure we load jQuery
		$pageRenderer = $this->doc->getPageRenderer();
		$pageRenderer->loadJquery();

		// Add our resources
		$relPath = ExtensionManagementUtility::extRelPath('better_tables') . 'Resources/Public/';
		$pageRenderer->addCssFile($relPath . 'Stylesheet/TableWizard.css');
		$pageRenderer->addJsFile($relPath . 'Javascript/TableWizard.js');

		// Generate the table and strip useless stuff
		$content = parent::getTableHTML($cfgArr, $row);
		$content = preg_replace('/ style="width[^"]+"/', '', $content);
		$content = preg_replace('/<td class="bgColor5">[^' . "\n" . ']+<\/td>/', '', $content);
		$content = preg_replace('/<tr class="bgColor5">[^\!]+<\/tr>/', '', $content);

		// Add "templates" for the buttons of the wizard
		$content .=
			'<div class="button-templates" style="display:none;">' .
				'<a class="wiz-delete wiz-action">' . IconUtility::getSpriteIcon('actions-selection-delete') . '</a>' .
				'<a class="wiz-up wiz-action">' . IconUtility::getSpriteIcon('actions-move-up') . '</a>' .
				'<a class="wiz-down wiz-action">' . IconUtility::getSpriteIcon('actions-move-down') . '</a>' .
				'<a class="wiz-bottom wiz-action">' . IconUtility::getSpriteIcon('actions-view-go-down') . '</a>' .
				'<a class="wiz-top wiz-action">' . IconUtility::getSpriteIcon('actions-view-go-up') . '</a>' .
				'<a class="wiz-left wiz-action">' . IconUtility::getSpriteIcon('actions-move-left') . '</a>' .
				'<a class="wiz-right wiz-action">' . IconUtility::getSpriteIcon('actions-move-right') . '</a>' .
				'<a class="wiz-first wiz-action">' . IconUtility::getSpriteIcon('actions-view-go-back') . '</a>' .
				'<a class="wiz-last wiz-action">' . IconUtility::getSpriteIcon('actions-view-go-forward') . '</a>' .
				'<a class="wiz-add wiz-action">' . IconUtility::getSpriteIcon('actions-edit-add') . '</a>' .
			'</div>';

		return $content;
	}
}
