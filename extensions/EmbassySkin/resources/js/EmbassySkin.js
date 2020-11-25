(function (mw, $, window) {

	/**
	 * SemanticCoreSkin Namespace
	 *
	 * @type {Object}
	 */
	mw.libs.EmbassySkin = {};


	//////////////////////////////////////////
	// FUNCTIONS                            //
	//////////////////////////////////////////

	mw.libs.EmbassySkin.ajax = function (data, async = true, type = 'GET', callback) {
		$.ajax({
			url: mw.util.wikiScript('api'),
			data: data,
			type: type,
			async: async,
			success: callback,
			error: function (err) {
				console.error('error: ', err);
			},
			fail: function (fail) {
				console.log('fail:', fail);
			}
		})
	};

	mw.libs.EmbassySkin.searchInput = function(){
		$('#searchInput').attr('placeholder', 'search the embassy');
	};

	mw.libs.EmbassySkin.handleTabs = function () {

		if($('#gesinn-custom-tabs').length){
			$('#gesinn-custom-tabs .g-tablinks').first().addClass("active");
			document.getElementById('data-tab-content-trainee').style.display = "block";

			$('span.g-tablinks').on('click', function () {

				var tabval = $(this).attr('data-tab');

				// Get all elements with class="tabcontent" and hide them
				var tabcontent = document.getElementsByClassName("g-tabcontent");
				for (i = 0; i < tabcontent.length; i++) {
					tabcontent[i].style.display = "none";
				}

				// Get all elements with class="tablinks" and remove the class "active"
				var tablinks = document.getElementsByClassName("g-tablinks");
				for (i = 0; i < tablinks.length; i++) {
					tablinks[i].className = tablinks[i].className.replace(" active", "");
				}

				document.getElementById('data-tab-content-' + tabval).style.display = "block";
				$(this).addClass("active");
			});
		}
	};

	mw.libs.EmbassySkin.mobileSearchTrigger = function () {
		$('button.search-trigger').on('click', function () {
			window.location.href = mw.config.get('wgServer') + mw.config.get('wgScript') + '/Special:Search';
		});
	};

	mw.libs.EmbassySkin.openInternalLinkInNewTab = function () {
		$('#mw-content-text').on('click', '.newtab > a', function () {
			var otherWindow = window.open();
			otherWindow.opener = null;
			otherWindow.location = this;
			return false;
		});
	};

	mw.libs.EmbassySkin.moveToSidebar = function () {

		var sidebarItem = $('.sidebar-items');
		if (sidebarItem.length > 0) {
			// Move divs with class 'sidebar-item' to the aside
			sidebarItem.appendTo('aside.sidebar').each(function () {

				// Mediawiki will always wrap the formlink with a paragraph
				// Replace these nodes with an span
				if (this.nodeName == "P") {
					$(this).replaceWith(function () {
						return $("<div>", {
							class: this.className,
							html: this.innerHTML
						});
					});
				}
			});
		}

		$('#content .sidebar-item.sidebar-anchors').prependTo('aside.sidebar');
		// move "Join our Discussion" to sidebar
		$('.sidebar-item.sidebar--discusssions').prependTo('aside.sidebar .sidebar-items');

		// move formlink to sidebar
		if($('.sidebar-item.formbutton')){
			$('.sidebar-item.formbutton').prependTo('aside.sidebar .sidebar-items');
		}


		$('#bodyContent #toc').remove();
	};


	// Issue described here: https://momkai.atlassian.net/browse/EMB-213
	// After you edit a form the second time the cites that are related to specific words inside a textarea
	// move from the button under the related textarea.
	// This patch collect all of these references, bundle them and move it to the bottom again.
	//
	// This also will start the <ref> inside each textarea with [1] to [x]
	// To achieve a cronological representation that fits the numbers of the references on the bottom
	// Fortunately the href of the <a>-tag (#cite_note-2) / id of <sup>-tag (cite_ref-2) holds the right number to the related reference on the bottom
	// so we easily can strip the end of the href and use it for representation.
	// ######### Here an Example: #########
	// Actual:
	// textarea1 => ref[1], ref[2], ref[3]
	// textarea2 => ref[1]
	// textarea3 => ref [1]
	//
	// Expected:
	// textarea1 => ref[1], ref[2], ref[3]
	// textarea2 => ref[4]
	// textarea3 => ref [5]

	mw.libs.EmbassySkin.handleReferences = function () {

		var ref = $('sup.reference');
		var footnotes = $('ol.references li');

		if (ref.length > 0 && footnotes.length > 0) {

			// Create wrapper for all references
			// then loop over all footnotes and append it to the wrapper
			var referenceBlock = '<div class="references"><h2><span class="mw-headline">References</span></h2><ol class="references">';
			footnotes.each(function () {
				referenceBlock += this.outerHTML;
			});
			referenceBlock += '</ol></div>';


			// remove all mw-references-wrap divs
			$('.mw-references-wrap').remove();

			// Add <references/> to the bottom of content div
			$('#mw-content-text .mw-parser-output').append('<div class="spacer"></div>' + referenceBlock);

			// Now clean up the wrong numbering of the <ref> inside the content area
			ref.each(function () {
				// get right number by id "e.g. cite_ref-2"
				var cite_ref = $(this).attr('id');

				var re = /^cite_ref-+:*0*_*([\d])/i;
				var refNr = cite_ref.match(re);

				$(this).find('a').html('[' + refNr[1] + ']');
			});

		}

	};


	mw.libs.EmbassySkin.handleTags = function () {
		$('.other-information-items').each(function () {
			var isHidden = false;
			var count = 0;
			$(this).find('.other-information-item').each(function (index) {
				if (index > 2) {
					// add 'is-hidden' class to li
					$(this).addClass('is-hidden');

					count++;
					isHidden = true;
				}
			});
			if (isHidden) {
				$(this).append('<li class="other-information-last grid-item-last is-visible"><a href="#">+ ' + count + ' more</a></li>');
			}
		});
	};

	mw.libs.EmbassySkin.handleRelatedResources = function () {
		var countResources = $('.sidebar-items .sidebar-item .related-resource').length;

		// get parent wrapper of related resources
		var parent = $('.sidebar-items .sidebar-item .related-resource').parent();

		if (countResources > 3) {
			$('<input type="checkbox" id="resources">').prependTo(parent);
			$('<label for="resources" class="related-resources-seeMore">See more resources</label>').appendTo(parent);
		}
	};

	// move code from other-information-block.js from momkai to this function
	// to ensure that the dom is ready and that this function is executed after "handleTags" was applied
	mw.libs.EmbassySkin.otherInformationBlock = function () {
		/**
		 * This module uses masonry from https://masonry.desandro.com/
		 */
		var elem = document.querySelector('.other-information-grid');

		if (elem) {
			var msnry = new Masonry(elem, {
				itemSelector: '.other-information-block',
				percentPosition: true,
				gutter: 10
			});
		}

		// Grab number of grid items
		var gridItems = document.querySelectorAll('.grid-block');

		if (gridItems) {
			// Set collapse of grid items
			for (var i = 0; i < gridItems.length; i++) {
				new gridBlock(gridItems[i], msnry);
			}
		}

		// Created grid elements block
		// Used by other-information-block and related-discussion components
		function gridBlock(el, msnry) {
			this.el = el;
			this.trigger = this.el.querySelector('.grid-item-last');
			this.items = this.el.querySelectorAll('.grid-item');
			this.length = this.el.querySelectorAll('.grid-item').length;
			this.msnry = msnry;

			var open = function (e) {
				e.preventDefault();
				this.trigger.classList.remove('is-visible')

				for (var i = 3; i < this.items.length; i++) {
					this.items[i].classList.remove('is-hidden');
				}

				// Lays out all item elements.
				// See https://masonry.desandro.com/methods.html#layout
				this.msnry.layout()

				setTimeout(cleanup, 100)
			}.bind(this);

			var cleanup = function (e) {
				this.trigger.removeEventListener('click', open)
			}.bind(this)

			if (this.length > 3) {
				this.trigger.querySelector('a').innerHTML = "+ " + (this.length - 3) + " more";
				this.trigger.classList.add('is-visible');

				for (var i = 3; i < this.items.length; i++) {
					this.items[i].classList.add('is-hidden')
				}

				this.trigger.addEventListener('click', open);
			}
		}

		// Hide other information block in content if no items exist
		if($('.other-information-wrapper').children().length === 0){
			$('#content .other-information').css('display', 'none');
		}

	};

	// manipulate dom elements for masonry layout
	mw.libs.EmbassySkin.addColumnClasses = function () {
		$('.RT-Masonry-section-has-parent-theme').addClass('columns-item');
	};

	mw.libs.EmbassySkin.handleLinks = function () {
		/**
		 * Module to open links inside MediaWiki context
		 */
		$('.te-mw-link').on('click', function (e) {

			e.preventDefault();
			// does not do anything if href is undefined
			if (this.dataset.href === undefined) {
				return;
			}
			// specific to go back
			if (this.dataset.href === '#' && this.dataset.target === 'back') {
				window.history.back();
				return;
			}
			// check if its target
			if (this.dataset.target === '_self' || this.dataset.target === undefined) {
				document.location.href = mw.config.get('wgServer') + mw.config.get('wgScript') + '/' + this.dataset.href;
			} else if (this.dataset.target === '_blank' || this.dataset.href !== undefined) {
				window.open(this.dataset.href);
			} else if (this.dataset.target === '_ext' || this.dataset.href !== undefined) {
				location.href = this.dataset.href;
			}
		});
	};

	mw.libs.EmbassySkin.moveContributorsToBottom = function () {
		// check if on thematic page
		var ns = mw.config.get('wgCanonicalNamespace');

		if (ns === 'Theme' || ns === 'Instruction' || ns === 'Resource') {

			if ($('#content .copyright').length) {
				var contributors = $('#content .copyright')[0];
				$('#content .copyright').remove();

				$(contributors).appendTo('.mw-parser-output');
			}
		}
	};

	mw.libs.EmbassySkin.addContributors = function () {
		// check if on thematic page
		var ns = mw.config.get('wgCanonicalNamespace');

		if ((ns === 'Theme' || ns === 'Instruction' || ns === 'Resource') && mw.config.get('wgAction') === 'view') {
			var page = mw.config.get('wgPageName');
			var modificationDate = '';
			var lastModificationDateStr = '';
			var fullname = '';
			var contributors = '';

			var data = {
				action: 'ask',
				query: "[[" + page + "]]|?Page author|?Modification date|mainlabel=-",
				format: 'json'
			};

			mw.libs.EmbassySkin.ajax(data, false, 'GET', function (result) {

				if (typeof result.query.results[page].printouts !== 'undefined') {
					// get all authors of current page
					var authors = result.query.results[page].printouts['Page author'];

					// get modification date
					if (modificationDate === '') {
						modificationDate = result.query.results[page].printouts['Modification date'][0].timestamp * 1000;

						var ts = new Date(modificationDate);

						const ye = new Intl.DateTimeFormat('en', {year: 'numeric'}).format(ts);
						const mo = new Intl.DateTimeFormat('en', {month: 'short'}).format(ts);
						const da = new Intl.DateTimeFormat('en', {day: '2-digit'}).format(ts);

						lastModificationDateStr = mo + ' ' + da + ', ' + ye;
					}

					authors.forEach(function (author, index) {

						if (typeof author.fulltext !== 'undefined') {
							var userpage = author.fulltext;

							var data = {
								action: 'ask',
								query: "[[" + userpage + "]]|?Full Name|mainlabel=-",
								format: 'json'
							};

							mw.libs.EmbassySkin.ajax(data, false, 'GET', function (result) {

								var fullnameprintout = result.query.results[userpage].printouts['Full Name'][0];

								if (fullname !== '') {
									if (typeof fullnameprintout !== 'undefined') {
										fullname += ', <b>' + fullnameprintout.fulltext + '</b>';
									}
								} else {
									if (typeof fullnameprintout !== 'undefined') {
										fullname += '<b>' + fullnameprintout.fulltext + '</b>';
									}
								}
							});
						}
					});

					if (fullname.trim() !== '') {
						contributors = fullname + " contributed to this " + ns.toLowerCase() + ".";
					}

					var copyrightWrapper = "<div class='copyright'><p>" + contributors + " Latest contribution was <b>" + lastModificationDateStr + "<b></b></p></div>";
					$('#mw-content-text .mw-parser-output').append(copyrightWrapper);
				}
			});
		}
	};

	mw.libs.EmbassySkin.showPFerrorBox = function () {

		var errorMsg = [];
		errorMsg = $('.sfFieldContent .errorMessage');

		var errorBoxClass = "Form-error-msg-box";
		var errorBox = "<div class='" + errorBoxClass + " alert alert-danger'>" + mw.message('pf-box-blank-error').text() + "</div>";

		if ($('.' + errorBoxClass).length)
			$('.' + errorBoxClass).remove();

		if (errorMsg.length > 0) {

			// add a info box at the top of the form
			// if a errorMessage of PF was found
			$('form#pfForm .form-wrapper .Form-introduction').append(errorBox)

		}
	};

	//////////////////////////////////////////
	// BOOTSTRAP                            //
	//////////////////////////////////////////


	$(document).ready(function () {
		try {
			mw.libs.EmbassySkin.searchInput();
			mw.libs.EmbassySkin.moveToSidebar();
			mw.libs.EmbassySkin.handleLinks();
			mw.libs.EmbassySkin.handleTags();

			// This call the hole content without "window.addEventListener('DOMContentLoaded'" to this function
			// Otherwise we will get some strange error msg in the console
			mw.libs.EmbassySkin.otherInformationBlock();
			mw.libs.EmbassySkin.addColumnClasses();
			mw.libs.EmbassySkin.handleRelatedResources();
			mw.libs.EmbassySkin.addContributors();
			mw.libs.EmbassySkin.handleReferences();
			mw.libs.EmbassySkin.openInternalLinkInNewTab();
			mw.libs.EmbassySkin.mobileSearchTrigger();
			//move Contributors needs to run after "handleReferences"!!
			mw.libs.EmbassySkin.moveContributorsToBottom();

			//mw.libs.EmbassySkin.handleTabs();

			// show error box if validation of input fields was not successfull
			mw.hook('pf.formValidationAfter').add(function () {
				mw.libs.EmbassySkin.showPFerrorBox();
			});


		} catch (e) {
			console.error('EmbassySkin.js crashed');
			console.error(e);
		}
	});

}(mediaWiki, jQuery, window));