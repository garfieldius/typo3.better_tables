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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * View helper to display the css classes of a row of a table
 *
 * @package GeorgGrossberger.BetterTables
 * @author Georg Großberger <contact@grossberger-ge.org>
 * @copyright 2013 by Georg Großberger
 * @license GPL v3 http://www.gnu.org/licenses/gpl-3.0.txt
 */
class RowClassesViewHelper extends AbstractViewHelper {

	/**
	 * Create a class attribute for a tr tag
	 *
	 * @param array $settings
	 * @param array $iteration
	 * @return string
	 */
	public function render(array $settings, array $iteration) {
		$content = '';
		$classes = array();

		if ($settings['additionalCssClasses']) {
			$classes[] = $iteration['isOdd'] ? 'tr-odd' : 'tr-even';
			$classes[] = 'tr-' . $iteration['index'];

			if ($iteration['isFirst']) {
				$classes[] = 'tr-first';
			} elseif ($iteration['isLast']) {
				$classes[] = 'tr-last';
			}
		}

		if (!empty($classes)) {
			$content = ' class="' . implode(' ', $classes) . '"';
		}

		return $content;
	}
}
