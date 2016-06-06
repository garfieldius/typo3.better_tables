<?php

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Better tables',
	'description' => 'Overrides the default table element with a better, easier to use and modern plugin. Features a JS based wizard, a fluid template and more useable settings.',
	'category' => 'plugin',
	'version' => '0.1.0',
	'state' => 'beta',
	'uploadfolder' => 0,
	'createDirs' => '',
	'clearCacheOnLoad' => 1,
	'author' => 'Georg Großberger',
	'author_email' => 'contact@grossberger-ge.org',
	'author_company' => '',
	'constraints' => array(
		'depends' => array(
			'typo3' => '6.1.0-6.2.99',
			'php' => '5.3.0-5.5.99'
		),
		'conflicts' => array(
		),
		'suggests' => array(
		)
	),
);

?>