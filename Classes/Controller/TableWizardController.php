<?php
namespace GeorgGrossberger\BetterTables\Controller;
/*                                                                     *
 * This file is brought to you by Georg Großberger                     *
 * (c) 2013 by Georg Großberger <contact@grossberger-ge.org>           *
 *                                                                     *
 * It is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License, either version 3       *
 * of the License, or (at your option) any later version.              *
 *                                                                     */

use TYPO3\CMS\Backend\Controller\Wizard\TableController;
use TYPO3\CMS\Backend\Utility\IconUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Controller for the table wizard - extends the core wizard
 *
 * @author Georg Großberger <georg.grossberger@cyberhouse.at>
 * @license http://opensource.org/licenses/MIT MIT - License
 */
class TableWizardController extends TableController {

	/**
	 * Initialization of the class
	 *
	 * @return void
	 */
	protected function init() {
		parent::init();
		// show textareas or input fields in wizard
		// »smallFields« parameter (0 = textarea) is set in TCA, »textFields« is a wizard post value
		$this->inputStyle = (!empty($this->P['params']['smallFields']) || !empty($this->TABLECFG['textFields']))? 1 : 0;
	}

	/**
	 * Creates the HTML for the Table Wizard Module
	 *
	 * @param array $cfgArr Table config array
	 * @param array $row Current parent record array
	 * @return string HTML for the table wizard
	 */
	public function getTableHTML($cfgArr, $row) {
		// Make sure we load jQuery
		$pageRenderer = $this->doc->getPageRenderer();
		$pageRenderer->loadJquery();

		// Add our resources
		$relPath = ExtensionManagementUtility::extRelPath('better_tables') . 'Resources/Public/';
		$pageRenderer->addCssFile($relPath . 'Stylesheet/TableWizard.css');
		$pageRenderer->addJsFile($relPath . 'Javascript/TableWizard.js');

		// Generate the table markup and strip useless stuff
		$content = parent::getTableHTML($cfgArr, $row);
		$content = preg_replace('/ style="width[^"]+"/', '', $content);
		$content = preg_replace('/<td class="bgColor5">[^' . "\n" . ']+<\/td>/', '', $content);
		$content = preg_replace('/<tr class="bgColor5">[^\!]+<\/tr>/', '', $content);

		// Add "templates" for the buttons of the wizard
		$content .=
			'<div class="button-templates" style="display:none;">' .
				'<a class="wiz-delete wiz-action" title="' . $this->getLabel('delete') . '">' . IconUtility::getSpriteIcon('actions-selection-delete') . '</a>' .
				'<a class="wiz-up wiz-action" title="' . $this->getLabel('up') . '">' . IconUtility::getSpriteIcon('actions-move-up') . '</a>' .
				'<a class="wiz-down wiz-action" title="' . $this->getLabel('down') . '">' . IconUtility::getSpriteIcon('actions-move-down') . '</a>' .
				'<a class="wiz-bottom wiz-action" title="' . $this->getLabel('bottom') . '">' . IconUtility::getSpriteIcon('actions-view-go-down') . '</a>' .
				'<a class="wiz-top wiz-action" title="' . $this->getLabel('top') . '">' . IconUtility::getSpriteIcon('actions-view-go-up') . '</a>' .
				'<a class="wiz-left wiz-action" title="' . $this->getLabel('left') . '">' . IconUtility::getSpriteIcon('actions-move-left') . '</a>' .
				'<a class="wiz-right wiz-action" title="' . $this->getLabel('right') . '">' . IconUtility::getSpriteIcon('actions-move-right') . '</a>' .
				'<a class="wiz-first wiz-action" title="' . $this->getLabel('first') . '">' . IconUtility::getSpriteIcon('actions-view-go-back') . '</a>' .
				'<a class="wiz-last wiz-action" title="' . $this->getLabel('last') . '">' . IconUtility::getSpriteIcon('actions-view-go-forward') . '</a>' .
				'<a class="wiz-add wiz-action" title="' . $this->getLabel('add') . '">' . IconUtility::getSpriteIcon('actions-edit-add') . '</a>' .
			'</div>';

		return $content;
	}

	/**
	 * @param string $key
	 * @return NULL|string
	 */
	protected function getLabel($key) {
		return htmlspecialchars(LocalizationUtility::translate('wiz.' . $key, 'BetterTables'), ENT_COMPAT, 'UTF-8', FALSE);
	}
}
