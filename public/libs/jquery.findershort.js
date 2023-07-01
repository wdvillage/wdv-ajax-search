(function( $ ) {
	'use strict';
/**
 * jQuery Finder Plugin
 * @author Danny McGee
 * @version 1.0
 * github.com/dannymcgee
 * 
 * Copyright 2018 Danny McGee
 * Released under the MIT License
 * https://opensource.org/licenses/MIT
 */
/*******************************  this is the modified code. Original code here github.com/dannymcgee *****************************/
$(document).ready(function () {

	$("body").on('click', finder.activator, function() {
		finder.activate();
	});
	$("body").on('focus', finder.activator, function() {
		finder.activate();
	});

	$(document).mousedown(function (event) {
		if (event.which === 1) {
			switch ($(event.target).attr('id') || $(event.target).parents().attr('id')) {
				case 'finderClose':
					finder.closeFinder();
					break;
				
				case 'finderPrev':
					finder.prevResult();
					break;

				case 'finderNext':
					finder.nextResult();
					break;
				
				default:
					return true;
			}
		}
	});


//Add search on page or post
if ($('#content').length){
	$('#content').wrap('<div class="content" data-finder-content></div>');
	$('.content').wrap('<div class="app" data-finder-wrapper></div>');
	$('.content').before( '<button id="finderbtn" class="finder-activator" data-finder-activator><div id="searchtxt"><div id="search-text"></div><i class="fas fa-search"></i></div></button>');
}
if ($('#site-content').length){
	$('#site-content').wrap('<div class="content" data-finder-content></div>');
	$('.content').wrap('<div class="app" data-finder-wrapper></div>');
	$('.content').before( '<button id="finderbtn" class="finder-activator" data-finder-activator><div id="searchtxt"><div id="search-text"></div><i class="fas fa-search"></i></div></button>');
}

finder.createFinder();

$('#finderClose').keydown(function(e) {
    if(e.keyCode === 13) {
      finder.closeFinder();
    }
  });

//read page url
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
};

var searchword = getUrlParameter('c');
if (searchword===false){
    searchword='';
}


finder.closeFinder();

if (searchword!==''){

var btn = document.getElementById('finderbtn');
    document.addEventListener("show", function(event) { // (1)
    finder.activate();
    finder.findTerm($('#finderInput').val(searchword));
  });

  let event = new Event("show", {bubbles: true}); // (2)
  btn.dispatchEvent(event);
}

	
});

const finder = {
	activator: '[data-finder-activator]',

	content: '[data-finder-content]',

	wrapper: '[data-finder-wrapper]',

	activate: () => {
		if (!$('#finder').length) {
			finder.createFinder();
		}
		setTimeout(function () {
			$('#finder').addClass('active');
			$('#finderInput').focus();
			if ($('#finderInput').val()) {
				finder.findTerm($('#finderInput').val());
			}
			$('#finderInput').on('input', function () {
				finder.findTerm($(this).val());
			});
		}, 50);
	},

	createFinder: () => {
		const finderElem = $('<div />')
			.attr({
				'id': 'finder',
				'class': 'finder'
			})
			.prependTo(finder.wrapper);

		const input = $('<input />')
			.attr({
				'id': 'finderInput',
				'type': 'text',
				'class': 'finder-input',
			})
			.appendTo(finderElem);

		const prev = $('<button />')
			.attr({
				'id': 'finderPrev',
				'class': 'btn btn-finder btn-finder-prev',
			})
			.appendTo(finderElem);

		const prevIcon = $('<i />')
			.attr({
				'class': 'fas fa-angle-up',
			})
			.appendTo(prev);

		const next = $('<button />')
			.attr({
				'id': 'finderNext',
				'class': 'btn btn-finder btn-finder-next',
			})
			.appendTo(finderElem);

		const nextIcon = $('<i />')
			.attr({
				'class': 'fas fa-angle-down',
			})
			.appendTo(next);

		const close = $('<button />')
			.attr({
				'id': 'finderClose',
				'class': 'btn btn-finder btn-finder-close', 
				//'onfocus': 'myFunction(this)'
			})
			.appendTo(finderElem);

		const closeIcon = $('<i />')
			.attr({
				'class': 'fas fa-times',
			})
			.appendTo(close);
	},

	closeFinder: () => {
		$('#finder').removeClass('active');
		$(finder.content).unhighlight();
	},

	resultsCount: 0,

	currentResult: 0,

	findTerm: (term) => {
		// highlight results
		$(finder.content).unhighlight();
		$(finder.content).highlight(term);

		// count results
		finder.resultsCount = $('.highlight').length;

		if (finder.resultsCount) {
			// there are results, scroll to first one
			finder.currentResult = 1;
		} else {
			// no results
			finder.currentResult = 0;
		}

		// term not found
		if (!finder.resultsCount && term) {
			$('#finderInput').addClass('not-found');
		} else {
			$('#finderInput').removeClass('not-found');
		}

		finder.updateCurrent();
	},

	prevResult: () => {
		if (finder.resultsCount) {
			if (finder.currentResult > 1) {
				finder.currentResult--;
			} else {
				finder.currentResult = finder.resultsCount;
			}
		}

		finder.updateCurrent();
	},

	nextResult: () => {
		if (finder.resultsCount) {
			if (finder.currentResult < finder.resultsCount) {
				finder.currentResult++;
			} else {
				finder.currentResult = 1;
			}
		}

		finder.updateCurrent();
	},

	updateCurrent: () => {
		if ($('#finderInput').val()) {
			if (!$('#finderCount').length) {
				const countElem = $('<span />')
					.attr({
						'id': 'finderCount',
						'class': 'finder-count',
					})
					.insertAfter('#finderInput');
			}
			setTimeout(function () {
				$('#finderCount').text(finder.resultsCount);
			}, 50);
		} else {
			$('#finderCount').remove();
		}
	},
}


})( jQuery );