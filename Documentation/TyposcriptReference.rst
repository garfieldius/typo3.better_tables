====================
Typoscript Reference
====================

The Typoscript template **Better Tables** must be included for this extension to work and the following options to be available.

Please note: If editors choose »default« in the table settings of the content element, then the given TypoScript values are used. You are required to set/check some defaults like »fieldDelimiter«.

Options
-------

.. ..................................
.. container:: table-row

	Property
		cssClasses

	Data type
		string

	Description
		CSS class to add to the table tag.

	Default
		*None*

.. ..................................
.. container:: table-row

	Property
		additionalCssClasses

	Data type
		boolean

	Description
		If enabled, additional CSS classes will be added to the table, tr and td tags.

	Default
		0

.. ..................................
.. container:: table-row

	Property
		cellParseFunc

	Data type
		integer

	Description
		Key for the processing function to use on the content of every cell generated. The following keys are available:
		0 = No processing
		1 = PHPs htmlspecialchars
		2 = use lib.parseFunc_RTE

	Default
		1 (htmlSpecialChars)

.. ..................................
.. container:: table-row

	Property
		fieldDelimiter

	Data type
		string

	Description
		The character which specifies to boundary between separate cells in each line of text

	Default
		| (Pipe)

.. ..................................
.. container:: table-row

	Property
		fieldWrap

	Data type
		string

	Description
		Wrapper around the content of a single column. Required if the cell content includes uses special characters.

	Default
		*None*

.. ..................................
.. container:: table-row

	Property
		trimFields

	Data type
		boolean

	Description
		Trim the content of a cell of spaces before adding them.

	Default
		0

.. ..................................
.. container:: table-row

	Property
		headerPosition

	Data type
		string

	Description
		Determines if a header should be generated for the table. Possible values are:
		top = Use the first row as header
		left = Use the first column as header
		Any other value, like the default empty one, disables the header generation.

	Default
		*None*

.. ..................................
.. container:: table-row

	Property
		footer

	Data type
		boolean

	Description
		If enabled, a top header will also be added as footer.
		Has no effect if *headerPosition* is set to an other value than *top*

	Default
		0

Constants
---------

All above options are set inside *tt_content.table.20.defaults*. They are all configurable via constants as well, that reside in the namespace *styles.content.table* and have the same names as the actual Typoscript options.

The constants can also be set via the constants editor. They have according wizards set.


Fluid
-----

Inside the namespace *tt_content.table.20.view* is a common extbase configuration for a fluid standalone template. Overriding those options offers custom templating options.
