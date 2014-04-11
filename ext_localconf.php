<?php
/*                                                                       *
 * Copyright 2014 Georg Großberger <contact@grossberger-ge.org           *
 *                                                                       *
 * This is free software; you can redistribute it and/or modify it under *
 * the terms of the MIT- / X11 - License                                 *
 *                                                                       */

// Load our own controller
$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\CMS\Backend\Controller\Wizard\TableController']['className'] =
	'GeorgGrossberger\BetterTables\Controller\TableWizardController';
