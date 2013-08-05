/*                                                                     *
 * This file is brought to you by Georg Großberger                     *
 * (c) 2013 by Georg Großberger <contact@grossberger-ge.org>           *
 *                                                                     *
 * It is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License, either version 3       *
 * of the License, or (at your option) any later version.              *
 *                                                                     */

TYPO3.jQuery(function($) {
	"use strict";

	var root = $("#typo3-tablewizard"),
		isSmall = document.getElementById("textFields").checked,
		newInput = '<input type="text" />',
		newText = '<textarea />',
		containerId = 'wiz-button-container',

		/**
		 * Get a button object by name
		 */
		getButton = function(name) {
			return $(".button-templates > .wiz-" + name + "").clone();
		},

		/**
		 * Assign names to the input fields, according to the current sorting
		 */
		reassignNames = function() {
			clearButtons();
			var row = 0;
			root.find('tr').each(function() {
				var column = 0;
				row += 2;

				$(this).find("input,textarea").each(function() {
					column += 2;
					this.name = 'TABLE[c][' + row + '][' + column + ']';
				});
			});
			makeButtons();
		},

		/**
		 * Remove all buttons
		 */
		clearButtons = function() {
			root.find('.' + containerId).remove();
		},

		/**
		 * Get all data rows of the table
		 */
		findRows = function() {
			return root.find(' > tbody > tr').not('.' + containerId);
		},

		/**
		 * Make the buttons for a rows and columns
		 */
		makeButtons = function() {
			var trs  = findRows(),
				len  = trs.length - 1,
				cols = trs.first().children().length,
				colButtons,
				i = 0,
				col = $('<tr />').addClass('bgColor4').addClass(containerId).append( $('<td />').addClass('invisible').html('&nbsp;') );

			trs.each(function(i) {

				var buttons = [getButton('delete')];

				if (!i) {
					buttons.push(getButton('bottom'))
				} else {
					buttons.push(getButton('up'))
				}

				if (i == len) {
					buttons.push(getButton('top'))
				} else {
					buttons.push(getButton('down'))
				}

				buttons.push(getButton('add'));

				$(this).prepend(
					$('<td />').addClass(containerId).append(buttons)
				)
			});

			for (i; i < cols; i++) {
				colButtons = [getButton('delete'), getButton('add'), $('<br />')];

				if (!i) {
					colButtons.push(getButton('last'));
				} else {
					colButtons.push(getButton('left'));
				}

				if (i == cols - 1) {
					colButtons.push(getButton('first'));
				} else {
					colButtons.push(getButton('right'));
				}
				col.append($('<td />').append(colButtons));
			}
			root.prepend(col);
		},

		/**
		 * Wrapper for accessing all rows or a column, meaning one cell of each row
		 */
		rowOrColumn = function(row, columnCallback, rowCallback) {
			if ($.isFunction(row)) {
				findRows().each(row);
			} else if (row.hasClass(containerId)) {
				findRows().each(columnCallback);
			} else {
				rowCallback();
			}
		},

		/**
		 * Create a new data cell
		 */
		makeCell = function () {
			return $('<td />').html(isSmall ? newInput : newText);
		};

	$("#textFields").click(function(ev) {
		isSmall = this.checked;
		root.find("input,textarea").each(function() {
			var val = $(this).val();
			$(this).replaceWith($(isSmall ? newInput : newText).val(val))
		});
		ev.stopImmediatePropagation();
	});

	// Event delegation to have only one listener for the whole thing
	$(document).on("click", '.wiz-action', function() {

			var col = $(this).parent(),
				row = col.parent(),
				colNum = col.prevAll().length;

			// Class determines the action
			switch(this.className.split(' ').shift().split('-').pop()) {
				case 'add':
					rowOrColumn(
						row,
						function() {
							$(this).children().eq(colNum).after(makeCell());
						},
						function() {

							var i = 0,
								cols = row.children().length - 1,
								elements = [];

							for (i; i < cols; i++) {
								elements.push(makeCell())
							}
							row.after($('<tr />').append(elements));
						}
					);
					break;

				case 'first':
					rowOrColumn(function() {
						var col = $(this).children().eq(colNum);
						col.prevAll().last().after(col); // Use after the first, because '0' is the buttons column
					});
					break;

				case 'last':
					rowOrColumn(function() {
						var col = $(this).children().eq(colNum);
						col.nextAll().last().after(col);
					});
					break;

				case 'right':
					rowOrColumn(function() {
						var col = $(this).children().eq(colNum);
						col.next().after(col);
					});
					break;

				case 'left':
					rowOrColumn(function() {
						var col = $(this).children().eq(colNum);
						col.prev().before(col);
					});
					break;

				case 'up':
					row.insertBefore(row.prev());
					break;

				case 'down':
					row.insertAfter(row.next());
					break;

				case 'top':
					row.parent().prepend(row);
					break;

				case 'bottom':
					row.parent().append(row);
					break;

				case 'delete':
					rowOrColumn(
						row,
						function() {
							$(this).children().eq(colNum).remove();
						},
						function() {
							row.remove();
						}
					);
					break;
			}

			reassignNames();
		});

	makeButtons();
});
