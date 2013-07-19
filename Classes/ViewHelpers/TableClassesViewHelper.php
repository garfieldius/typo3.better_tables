<?php
/*                                                                     *
 * This file is brought to you by Georg Großberger                     *
 * (c) 2013 by Georg Großberger <contact@grossberger-ge.org>           *
 *                                                                     *
 * It is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License, either version 3       *
 * of the License, or (at your option) any later version.              *
 *                                                                     */

namespace GeorgGrossberger\BetterTables\ViewHelpers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * View helper to display the css classes of a table
 *
 * @package GeorgGrossberger.BetterTables
 * @author Georg Großberger <contact@grossberger-ge.org>
 * @copyright 2013 by Georg Großberger
 * @license GPL v3 http://www.gnu.org/licenses/gpl-3.0.txt
 */
class TableClassesViewHelper extends AbstractViewHelper {

	/**
	 * Create a class attribute for the table tag
	 *
	 * @param array $settings
	 * @param array $data
	 * @return string
	 */
	public function render(array $settings, array $data) {
		$content = '';
		$classes = array();

		if ($settings['additionalCssClasses']) {
			$classes[] = 'contenttable';
			$classes[] = 'contenttable-' . intval($data['layout']);
		}

		if (!empty($settings['cssClasses'])) {
			$classes = array_merge($classes, GeneralUtility::trimExplode(' ', $settings['cssClasses'], TRUE));
		}

		if (!empty($classes)) {
			$content = ' class="' . implode(' ', $classes) . '"';
		}

		return $content;
	}
}
