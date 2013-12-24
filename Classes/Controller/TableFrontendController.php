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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Plugin\AbstractPlugin;

/**
 * Renderer for the table in the frontend
 *
 * @package GeorgGrossberger.BetterTables
 * @author Georg Großberger <contact@grossberger-ge.org>
 * @copyright 2013 by Georg Großberger
 * @license GPL v3 http://www.gnu.org/licenses/gpl-3.0.txt
 */
class TableFrontendController extends AbstractPlugin {

	/**
	 * Render the table HTML
	 *
	 * @param string $content
	 * @param array $conf
	 * @return string
	 */
	public function renderTable($content, $conf) {
		$config = $this->mergeConfigurations($conf['defaults.']);

		$template = GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager')->get('TYPO3\CMS\Install\View\StandaloneView');
		$template->setTemplatePathAndFilename( GeneralUtility::getFileAbsFileName($conf['view.']['template']) );
		$template->setPartialRootPath( GeneralUtility::getFileAbsFileName($conf['view.']['partials']) );
		$template->setLayoutRootPath( GeneralUtility::getFileAbsFileName($conf['view.']['layouts']) );

		$rows = $this->makeRows($config);
		$header = array();
		$footer = array();

		if ($config['headerPosition'] == 'top') {
			$header = array_shift($rows);
			if ($config['footer']) {
				$footer = $header;
			}
		}

		$template->assign('settings', $config);
		$template->assign('rows', $rows);
		$template->assign('header', $header);
		$template->assign('footer', $footer);
		$template->assign('data', $this->cObj->data);
		unset($rows, $header, $footer, $config, $content, $conf);

		$content = $template->render();

		if (!empty($conf['stdWrap.'])) {
			$content = $this->cObj->stdWrap($content, $conf['stdWrap.']);
		}
		return $content;
	}

	/**
	 * Explode the CSV data into a two-dimensional array
	 *
	 * @param array $config
	 * @return array
	 */
	protected function makeRows(array $config) {
		$rows = array();
		$countColumns = 0;
		$padShortLines = FALSE;

		$content = str_replace("\r", '', $this->cObj->data['bodytext']);
		$rowDelimiter = '\s*' . preg_quote(LF, '/') . '\s*';
		$fieldWrap = preg_quote($config['fieldWrap'], '/');
		$columnDelimiter = $config['fieldDelimiter'];

		if (!empty($fieldWrap)) {
			$rowDelimiter = $fieldWrap . $rowDelimiter . $fieldWrap;
			$columnDelimiter = $fieldWrap . '\s*' . $columnDelimiter . '\s*' . $fieldWrap;
			$content = trim($content, $config['fieldWrap']);
		}

		$columnDelimiter = '/' . $columnDelimiter . '/i';
		$lines = preg_split('/' . $rowDelimiter . '/i', $content);

		foreach ($lines as $line) {
			$line = preg_split($columnDelimiter, $line);
			if (!$countColumns) {
				$countColumns = count($line);
			} elseif ($countColumns != count($line)) {
				$countColumns = max($countColumns, count($line));
				$padShortLines = TRUE;
			}
			$rows[] = $line;
		}
		unset($lines, $line);

		if ($padShortLines) {
			foreach ($rows as &$row) {
				if (count($row) < $countColumns) {
					$row = array_pad($row, $countColumns, '');
				}
			}
		}

		return $rows;
	}

	/**
	 * Merge Typoscript configuration and settings in the content element
	 *
	 * @param array $baseConf
	 * @return array
	 */
	protected function mergeConfigurations(array $baseConf) {
		$config = $baseConf;
		$flexformData = GeneralUtility::xml2array($this->cObj->data['pi_flexform']);

		$config['caption'] = $this->pi_getFFvalue($flexformData, 'acctables_caption');
		$config['summary'] = $this->pi_getFFvalue($flexformData, 'acctables_summary');

		$fields = array(
			'footer' => array('acctables_tfoot', 'sDEF'),
			'headerPosition' => array('acctables_headerpos', 'sDEF'),
			'cssClasses' => array('acctables_tableclass', 'sDEF'),
			'additionalCssClasses' => array('acctables_nostyles', 'sDEF'),
			'fieldWrap' => array('tableparsing_quote', 's_parsing'),
			'fieldDelimiter' => array('tableparsing_delimiter', 's_parsing'),
			'trimFields' => array('tableparsing_trimfields', 's_parsing'),
			'cellParseFunc' => array('tableparsing_cellParseFunc', 's_parsing'),
		);

		foreach ($fields as $configField => $flexformPosition) {
			list($flexformField, $flexformSheet) = $flexformPosition;
			$value = $this->pi_getFFvalue($flexformData, $flexformField, $flexformSheet);

			$value = $this->charNumberToChar($value);
			$config[$configField] = $this->charNumberToChar($config[$configField]);

			if (NULL !== $value) {
				$config[$configField] = $value;
			}
		}

		return $config;
	}

	/**
	 * Under some circumstances a setting contains an integer
	 * that is the ASCII number of a needed character
	 *
	 * @param $value
	 * @return null|string
	 */
	protected function charNumberToChar($value) {
		if (is_numeric($value)) {
			$value = (int) $value;
			if ($value > 5 && $value < 255) {
				$value = chr($value);
			}
		}

		if ($value === 'no') {
			$value = ' ';
		}

		if (trim($value) !== '' || $value === "\t") {
			return $value;
		} elseif ($value === ' ') {
			return '';
		}

		return NULL;
	}
}
