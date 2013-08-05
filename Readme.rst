Better Tables for TYPO3
=======================

This is a drop-in replacement for the default table element of `TYPO3 CMS`_. The default table element is quite old and has not been updated in years. So it's quite obvious that modern ways of integrating and maintaining content tables work differently that what this element was made for.

Basically it

* cleans up the TCA. Things like cellspacing and background color cannot be set in the content element anymore.
* replaces the Typoscript options and configuration with a new and better ones
* adjusts the flexform according to the previous two points
* uses `fluid`_ to render the frontend output
* offers a javascript based wizard for much easier and responsive input of content

The extension is available via a `git repository on Github`_ and in the `TYPO3 extension repository`_

.. _TYPO3 CMS: http://typo3.org
.. _fluid: http://docs.typo3.org/typo3cms/ExtbaseGuide/Fluid/Index.html
.. _git repository on Github: https://github.com/trenker/typo3.better_tables
.. _TYPO3 extension repository: http://typo3.org/extensions/repository/view/better_tables
