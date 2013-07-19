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
 * View helper to display the css classes of a cell of a table
 *
 * @package GeorgGrossberger.BetterTables
 * @author Georg Großberger <contact@grossberger-ge.org>
 * @copyright 2013 by Georg Großberger
 * @license GPL v3 http://www.gnu.org/licenses/gpl-3.0.txt
 */
class CellClassesViewHelper extends AbstractViewHelper {

	/**
	 * Create a class attribute for a td tag
	 *
	 * @param array $settings
	 * @param array $iteration
	 * @return string
	 */
	public function render(array $settings, array $iteration) {
		$content = '';
		$classes = array();

		if ($settings['additionalCssClasses']) {
			$classes[] = $iteration['isOdd'] ? 'td-odd' : 'td-even';
			$classes[] = 'td-' . $iteration['index'];

			if ($iteration['isFirst']) {
				$classes[] = 'td-first';
			} elseif ($iteration['isLast']) {
				$classes[] = 'td-last';
			}
		}

		if (!empty($classes)) {
			$content = ' class="' . implode(' ', $classes) . '"';
		}

		return $content;
	}
}
