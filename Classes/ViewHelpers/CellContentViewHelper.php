<?php
namespace GeorgGrossberger\BetterTables\ViewHelpers;
/*                                                                     *
 * This file is brought to you by Georg Großberger                     *
 * (c) 2013 by Georg Großberger <contact@grossberger-ge.org>           *
 *                                                                     *
 * It is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License, either version 3       *
 * of the License, or (at your option) any later version.              *
 *                                                                     */

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Process the contents of a cell as configured
 *
 * @package GeorgGrossberger.BetterTables
 * @author Georg Großberger <contact@grossberger-ge.org>
 * @copyright 2013 by Georg Großberger
 * @license GPL v3 http://www.gnu.org/licenses/gpl-3.0.txt
 */
class CellContentViewHelper extends AbstractViewHelper {

	/**
	 * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
	 */
	protected $configurationManager;

	/**
	 * @param \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager
	 * @return void
	 */
	public function injectConfigurationManager(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface $configurationManager) {
		$this->configurationManager = $configurationManager;
	}

	/**
	 * Convert or escape the given content
	 *
	 * @param string $content
	 * @param string $configuration
	 * @return string
	 */
	public function render($content = NULL, $configuration = NULL) {

		if (is_null($content)) {
			$content = $this->renderChildren();
		}

		$configuration = (int) $configuration;

		if ($configuration == 2) {
			return $this->configurationManager->getContentObject()->parseFunc($content, array(), '< lib.parseFunc_RTE');
		} elseif ($configuration == 1) {
			return nl2br($this->hsc($content));
		} else {
			return $this->hsc($content);
		}
	}

	/**
	 * Helper for faster access
	 *
	 * @param $content
	 * @return string
	 */
	protected function hsc($content) {
		return htmlspecialchars($content, ENT_COMPAT, 'UTF-8', FALSE);
	}
}
