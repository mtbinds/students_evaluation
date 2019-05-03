// the semi-colon before function invocation is a safety net against concatenated
// scripts and/or other plugins which may not be closed properly.
;// noinspection JSUnusedLocalSymbols
(function ($, window, document, undefined) {

	"use strict";

	// undefined is used here as the undefined global variable in ECMAScript 3 is
	// mutable (ie. it can be changed by someone else). undefined isn't really being
	// passed in so we can ensure the value of it is truly undefined. In ES5, undefined
	// can no longer be modified.

	// window and document are passed through as local variables rather than global
	// as this (slightly) quickens the resolution process and can be more efficiently
	// minified (especially when both are regularly referenced in your plugin).

	// Create the defaults once
	var pluginName = "forminatorFront",
		defaults = {
			form_type: 'custom-form',
			rules: {},
			messages: {},
			conditions: {},
			inline_validation: false,
			chart_design: 'bar',
			chart_options: {}
		};

	// The actual plugin constructor
	function ForminatorFront(element, options) {
		this.element = element;
		this.$el = $(this.element);
		this.forminator_selector = '#' + $(this.element).attr('id') + '[data-forminator-render="' + $(this.element).data('forminator-render') + '"]';
		this.forminator_loader_selector = 'div[data-forminator-render="' + $(this.element).data('forminator-render') + '"]' + '[data-form="' + $(this.element).attr('id') + '"]';

		// jQuery has an extend method which merges the contents of two or
		// more objects, storing the result in the first object. The first object
		// is generally empty as we don't want to alter the default options for
		// future instances of the plugin
		this.settings = $.extend({}, defaults, options);

		// special treatment for rules, messages, and conditions
		if (typeof this.settings.messages !== 'undefined') {
			this.settings.messages = this.maybeParseStringToJson(this.settings.messages, 'object');
		}
		if (typeof this.settings.rules !== 'undefined') {
			this.settings.rules = this.maybeParseStringToJson(this.settings.rules, 'object');
		}
		if (typeof this.settings.calendar !== 'undefined') {
			this.settings.calendar = this.maybeParseStringToJson(this.settings.calendar, 'array');
		}

		this._defaults = defaults;
		this._name = pluginName;
		this.init();
	}

	// Avoid Plugin.prototype conflicts
	$.extend(ForminatorFront.prototype, {
		init: function () {
			var self = this;

			$(this.forminator_loader_selector).remove();

			// If form from hustle popup, do not show
			if(this.$el.closest('.wph-modal').length === 0) {
				this.$el.show();
			}

			// Show form when popup trigger with click
			$(document).on("hustle:module:displayed", function( e, data ) {
				var $modal = $('.wph-modal-active');
				$modal.find('form').css('display', '');
			});

			// Show form when popup trigger
			setTimeout(function() {
				var $modal = $('.wph-modal-active');
				$modal.find('form').css('display', '');
			}, 10);

			//selective activation based on type of form
			switch (this.settings.form_type) {
				case  'custom-form':
					this.init_custom_form();
					break;
				case  'poll':
					this.init_poll_form();
					break;
				case  'quiz':
					this.init_quiz_form();
					break;

			}

			//init submit
			$(this.element).forminatorFrontSubmit({
				form_type: self.settings.form_type,
				forminator_selector: self.forminator_selector,
				chart_design: self.settings.chart_design,
				chart_options: self.settings.chart_options,
			});


			// TODO: confirm usage on form type
			// Handle field activation classes
			this.activate_field();
			// Handle special classes for material design
			this.material_field();

			// Init small form for all type of form
			this.small_form();

		},
		init_custom_form: function () {

			var self = this;

			//initiate validator
			if (this.settings.inline_validation) {

				this.init_intlTelInput_validation();

				$(this.element).forminatorFrontValidate({
					rules: self.settings.rules,
					messages: self.settings.messages
				});
			}

			//initiate pagination
			this.init_pagination();

			//initiate condition
			$(this.element).forminatorFrontCondition(this.settings.conditions);

			//initiate datepicker
			$(this.element).find('.forminator-datepicker').forminatorFrontDatePicker(this.settings.calendar);

			//initiate select2
			this.init_select2();

			// Handle responsive captcha
			this.responsive_captcha();

			// Handle field counter
			this.field_counter();

			// Handle number input
			this.field_number();

			// Handle time fields
			this.field_time();

			// Handle upload field change
			this.upload_field();

			// Handle function on resize
			$(window).on('resize', function () {

				self.responsive_captcha();

			});

		},
		init_poll_form: function () {
			var self = this,
				$selection = this.$el.find('.forminator-radio--field'),
				$input = this.$el.find('.forminator-input');

			if (this.$el.hasClass('forminator-poll-disabled')) {
				this.$el.find('.forminator-radio--field').each(function () {
					$(this).attr('disabled', true);
				});
			}

			$selection.on('click', function () {
				$input.hide();
				$input.attr('name', '');
				var checked = this.checked,
					$id = $(this).attr('id'),
					$name = $(this).attr('name');
				if (self.$el.find('.forminator-input#' + $id + '-extra').length) {
					var $extra = self.$el.find('.forminator-input#' + $id + '-extra');
					if (checked) {
						$extra.attr('name', $name + '-extra');
						$extra.show();
					} else {
						$extra.hide();
					}
				}
				return true;
			});

		},

		init_quiz_form: function () {
			var self = this;

			this.$el.find('.forminator-button').each(function () {
				$(this).prop("disabled", true);
			});

			this.$el.find('.forminator-answer input').each(function () {
				$(this).attr('checked', false);
			});

			this.$el.find('.forminator-result--info button').on('click', function () {
				location.reload();
			});

			this.$el.find('.forminator-submit-rightaway').click(function () {
				self.$el.submit();
				$(this).closest('.forminator-question').find('.forminator-submit-rightaway').addClass('forminator-has-been-disabled').attr('disabled', 'disabled');
			});


			this.$el.on('click', '.forminator-social--icon a', function (e) {
				e.preventDefault();
				var social = $(this).data('social'),
					message = $(this).closest('.forminator-social--icons').data('message'),
					social_shares = {
						'facebook': 'https://www.facebook.com/sharer/sharer.php?u=' + window.location.href + '&t=' + message,
						'twitter': 'https://twitter.com/intent/tweet?&url=' + window.location.href + '&text=' + message,
						'google': 'https://plus.google.com/share?url=' + window.location.href,
						'linkedin': 'https://www.linkedin.com/shareArticle?mini=true&url=' + window.location.href + '&title=' + message
					};

				if (social_shares[social] !== undefined) {
					var newwindow = window.open(social_shares[social], social, 'height=' + $(window).height() + ',width=' + $(window).width());
					if (window.focus) {
						newwindow.focus();
					}
					return false;
				}
			});

			this.$el.on('change', '.forminator-answer input', function (e) {
				var count = 0,
					amount_answers = self.$el.find('.forminator-question').length;

				self.$el.find('.forminator-answer input').each(function () {
					if ($(this).prop('checked')) {
						count++;
					}

					if (count === amount_answers) {
						self.$el.find('.forminator-button').each(function () {
							$(this).prop("disabled", false);
						});
					}
				});

			});

		},

		small_form: function () {

			var form = $(this.element);

			if ($(window).width() > 782) {

				if (form.parent().width() <= 420 && ! form.closest( '.form-preview-wrapper' ).length ) {
					form.addClass('forminator-size--small');
				}

			}

		},

		init_intlTelInput_validation: function () {

			var form = $(this.element),
				is_material = form.is('.forminator-design--material'),
				fields = form.find('.forminator-phone--field');

			fields.each( function() {

				// Initialize intlTelInput plugin on each field with "format check" enabled and
				// set to check either "international" or "standard" phones.
				var is_national_phone = $(this).data('national_mode'),
					country = $(this).data('country');

				if ( 'undefined' !== typeof( is_national_phone ) ) {

					if ( is_material ) {
						$(this).unwrap( '.forminator-input--wrap' );
					}

					var args = {
						nationalMode: ( 'enabled' === is_national_phone ) ? true : false,
						initialCountry: 'us',
						utilsScript: window.ForminatorFront.cform.intlTelInput_utils_script
					};

					if ( 'undefined' !== typeof( country ) ) {
						args.initialCountry = country;
						args.allowDropdown = false;
					}

					$(this).intlTelInput( args );

					// intlTelInput plugin adds a markup that's not compatible with 'material' theme when 'allowDropdown' is true (default).
					// If we're going to allow users to disable the dropdown, this should be adjusted accordingly.
					if ( is_material ) {
						$(this).closest( '.intl-tel-input.allow-dropdown' ).addClass( 'forminator-phone-intl' ).removeClass( 'intl-tel-input' );
						$(this).closest( '.forminator-field' ).addClass( 'intl-tel-input' );
						$(this).wrap( '<div class="forminator-input--wrap"></div>' );
					}
				}
			} );

		},

		init_select2: function () {

			var form = $(this.element),
				form_id = form.attr('id');

			if (form.hasClass('forminator-design--default')) {

				$(this.element).find(".forminator-select").wpmuiSelect({
					allowClear: false,
					containerCssClass: "forminator-select2",
					dropdownCssClass: "forminator-dropdown forminator-dropdown--default forminator-ddfor--" + form_id
				});

				$(this.element).find(".forminator-time").wpmuiSelect({
					allowClear: false,
					containerCssClass: "forminator-select2",
					dropdownCssClass: "forminator-droptime forminator-droptime--default forminator-ddfor--" + form_id
				});

			} else if (form.hasClass('forminator-design--material')) {

				$(this.element).find(".forminator-select").wpmuiSelect({
					allowClear: false,
					containerCssClass: "forminator-select2",
					dropdownCssClass: "forminator-dropdown forminator-dropdown--material forminator-ddfor--" + form_id
				});

				$(this.element).find(".forminator-time").wpmuiSelect({
					allowClear: false,
					containerCssClass: "forminator-select2",
					dropdownCssClass: "forminator-droptime forminator-droptime--material forminator-ddfor--" + form_id
				});

			} else if (form.hasClass('forminator-design--bold')) {

				$(this.element).find(".forminator-select").wpmuiSelect({
					allowClear: false,
					containerCssClass: "forminator-select2",
					dropdownCssClass: "forminator-dropdown forminator-dropdown--bold forminator-ddfor--" + form_id
				});

				$(this.element).find(".forminator-time").wpmuiSelect({
					allowClear: false,
					containerCssClass: "forminator-select2",
					dropdownCssClass: "forminator-droptime forminator-droptime--bold forminator-ddfor--" + form_id
				});

			} else if (form.hasClass('forminator-design--flat')) {

				$(this.element).find(".forminator-select").wpmuiSelect({
					allowClear: false,
					containerCssClass: "forminator-select2",
					dropdownCssClass: "forminator-dropdown forminator-dropdown--flat forminator-ddfor--" + form_id
				});

				$(this.element).find(".forminator-time").wpmuiSelect({
					allowClear: false,
					containerCssClass: "forminator-select2",
					dropdownCssClass: "forminator-droptime forminator-droptime--flat forminator-ddfor--" + form_id
				});

			} else {

				$(this.element).find(".forminator-select").wpmuiSelect({
					allowClear: false,
					containerCssClass: "forminator-select2",
					dropdownCssClass: "forminator-dropdown forminator-ddfor--" + form_id
				});

				$(this.element).find(".forminator-time").wpmuiSelect({
					allowClear: false,
					containerCssClass: "forminator-select2",
					dropdownCssClass: "forminator-droptime forminator-droptime--flat forminator-ddfor--" + form_id
				});

			}
		},

		responsive_captcha: function () {
			$(this.element).find('.forminator-g-recaptcha').each(function () {
				if ($(this).is(':visible')) {
					var width = $(this).parent().width(),
						scale = 1;
					if (width < 302) {
						scale = width / 302;
					}
					$(this).css('transform', 'scale(' + scale + ')');
					$(this).css('-webkit-transform', 'scale(' + scale + ')');
					$(this).css('transform-origin', '0 0');
					$(this).css('-webkit-transform-origin', '0 0');
				}
			});
		},

		init_pagination: function () {
			var self = this,
				num_pages = $(this.element).find(".forminator-pagination").length,
				hash = window.location.hash,
				hashStep = false,
				step = 0;

			if (num_pages > 0) {
				//find from hash
				if (typeof hash !== "undefined" && hash.indexOf('step-') >= 0) {
					hashStep = true;
					step = hash.substr(6, 8);
				}

				$(this.element).forminatorFrontPagination({
					totalSteps: num_pages,
					hashStep: hashStep,
					step: step,
					inline_validation: self.settings.inline_validation
				});
			}
		},

		activate_field: function () {
			var form = $(this.element);

			form.find('.forminator-input, .forminator-textarea').each(function () {

				var $ftype = $(this);

				if ($(this).val().trim() !== "") {
					$(this).closest('.forminator-field').addClass('forminator-is_filled');
					$(this).closest('.forminator-poll--answer').addClass('forminator-is_filled');
				} else {
					$(this).closest('.forminator-field').removeClass('forminator-is_filled');
					$(this).closest('.forminator-poll--answer').removeClass('forminator-is_filled');
				}

				// Set field active class on hover
				$ftype.mouseover(function (e) {
					e.stopPropagation();
					$(this).closest('.forminator-field').addClass('forminator-is_hover');
					$(this).closest('.forminator-poll--answer').addClass('forminator-is_hover');

				}).mouseout(function (e) {
					e.stopPropagation();
					$(this).closest('.forminator-field').removeClass('forminator-is_hover');
					$(this).closest('.forminator-poll--answer').removeClass('forminator-is_hover');

				});

				// Set field active class on focus
				$ftype.focus(function (e) {
					e.stopPropagation();
					$(this).closest('.forminator-field').addClass('forminator-is_active');
					$(this).closest('.forminator-poll--answer').addClass('forminator-is_active');

				}).blur(function (e) {
					e.stopPropagation();
					$(this).closest('.forminator-field').removeClass('forminator-is_active');
					$(this).closest('.forminator-poll--answer').removeClass('forminator-is_active');

				});

				// Set field filled class on change
				$ftype.change(function (e) {
					e.stopPropagation();

					if ($(this).val().trim() !== "") {
						$(this).closest('.forminator-field').addClass('forminator-is_filled');
						$(this).closest('.forminator-poll--answer').addClass('forminator-is_filled');
					} else {
						$(this).closest('.forminator-field').removeClass('forminator-is_filled');
						$(this).closest('.forminator-poll--answer').removeClass('forminator-is_filled');
					}

					if ($(this).val().trim() !== "" && $(this).find('forminator-label--validation').text() !== "") {
						$(this).find('.forminator-label--validation').remove();
						$(this).find('.forminator-field').removeClass('forminator-has_error');
					}
				});

			});

			form.find('.forminator-select + .select2, .forminator-time + .select2').each(function () {

				var $select = $(this);

				// Set field active class on hover
				$select.mouseover(function (e) {
					e.stopPropagation();
					$(this).closest('.forminator-field').addClass('forminator-is_hover');

				}).mouseout(function (e) {
					e.stopPropagation();
					$(this).closest('.forminator-field').removeClass('forminator-is_hover');

				});

				// Set field active class on focus
				$select.on('click', function (e) {
					e.stopPropagation();
					checkSelectActive();
					if ($select.hasClass('select2-container--open')) {
						$(this).closest('.forminator-field').addClass('forminator-is_active');
					} else {
						$(this).closest('.forminator-field').removeClass('forminator-is_active');
					}

				});


			});

			function checkSelectActive() {
				if (form.find('.select2-container').hasClass('select2-container--open')) {
					setTimeout(checkSelectActive, 300);
				} else {
					form.find('.select2-container').closest('.forminator-field').removeClass('forminator-is_active');
				}
			}
		},

		field_counter: function () {
			var form = $(this.element);
			form.find('.forminator-input, .forminator-textarea').each(function () {
				var $input = $(this),
					count = 0;

				$input.on('change keyup', function (e) {
					e.stopPropagation();
					var $field = $(this).closest('.forminator-field'),
						$limit = $field.find('.forminator-field--helper .forminator-label--limit')
					;

					if ($limit.length) {
						if ($limit.data('limit')) {
							if ($limit.data('type') !== "words") {
								count = $(this).val().trim().length;
							} else {
								count = $(this).val().trim().split(/\s+/).length;
							}
							$limit.html(count + ' / ' + $limit.data('limit'));
						}
					}
				});

			});
		},

		field_number: function () {
			// var form = $(this.element);
			// form.find('input[type=number]').on('change keyup', function () {
			// 	if( ! $(this).val().match(/^\d+$/) ){
			// 		var sanitized = $(this).val().replace(/[^0-9]/g, '');
			// 		$(this).val(sanitized);
			// 	}
			// });
		},

		field_time: function () {
			$('.forminator-input-time').on('input', function (e) {
				var $this = $(this),
					value = $this.val()
				;

				// Allow only 2 digits for time fields
				if (value && value.length >= 2) {
					$this.val(value.substr(0, 2));
				}
			});
		},

		material_field: function () {
			var form = $(this.element);
			if (form.is('.forminator-design--material')) {
				var $input		= form.find('.forminator-input--wrap'),
					$textarea	= form.find('.forminator-textarea--wrap'),
					$date		= form.find('.forminator-date'),
					$product	= form.find('.forminator-product');

				var $navigation = form.find('.forminator-pagination--nav'),
					$navitem = $navigation.find('li');

				$('<span class="forminator-nav-border"></span>').insertAfter($navitem);

				$input.prev('.forminator-field--label').addClass('forminator-floating--input');
				$input.closest('.forminator-phone-intl').prev('.forminator-field--label').addClass('forminator-floating--input');
				$textarea.prev('.forminator-field--label').addClass('forminator-floating--textarea');

				if ($date.hasClass('forminator-has_icon')) {
					$date.prev('.forminator-field--label').addClass('forminator-floating--date');
				} else {
					$date.prev('.forminator-field--label').addClass('forminator-floating--input');
				}
			}
		},

		toggle_file_input: function () {

			var form = $(this.element);

			form.find(".forminator-upload").each(function () {

				var $self = $(this),
					$input = $self.find(".forminator-input"),
					$remove = $self.find(".forminator-upload--remove")
					;

				// Toggle remove button depend on input value
				if ( $input.val() !== "" ) {
					// Show remove button
					$remove.show();
				} else {
					// Hide remove button
					$remove.hide();
				}
			});
		},

		upload_field: function () {

			var self = this,
				form = $(this.element)
				;

			// Toggle file remove button
			this.toggle_file_input();

			// Handle remove file button click
			form.find(".forminator-upload--remove").on('click', function (e) {

				e.preventDefault();

				var $self = $(this),
					$input = $self.siblings('.forminator-input'),
					$label = $self.siblings('.forminator-label')
					;

				// Cleanup
				$input.val( '' );
				$label.html( 'No file chosen' );
				$self.hide();

			});

			form.find(".forminator-upload-button").on('click', function (e) {

				e.preventDefault();

				var $id = $(this).attr('data-id'),
					$target = form.find('input#' + $id),
					$nameLabel = form.find('label#' + $id)
					;

				$target.trigger('click');

				$target.change(function () {

					var vals = $(this).val(),
						val = vals.length ? vals.split('\\').pop() : ''
						;

					$nameLabel.text(val);

					self.toggle_file_input();

				});
			});

			form.find( '.forminator-input-file' ).on('change', function(e) {

				e.preventDefault();

				var $file = $(this)[0].files.length,
					$remove = $(this).find( '~ .forminator-upload--remove' );

				if ( $file === 0 ) {
					$remove.hide();
				} else {
					$remove.show();
				}

			});
		},

		renderCaptcha: function (captcha_field) {
			var self = this;
			//render captcha only if not rendered
			if (typeof $(captcha_field).data('forminator-recapchta-widget') === 'undefined') {
				var size = $(captcha_field).data('size'),
					data = {
						sitekey: $(captcha_field).data('sitekey'),
						theme: $(captcha_field).data('theme'),
						size: size
					};

				if (size === 'invisible') {
					data.badge = 'inline';
					data.callback = function(token){
						$(self.element).trigger('submit.frontSubmit');
					};
				}

				if (data.sitekey !== "") {
					// noinspection Annotator
					var widget = window.grecaptcha.render(captcha_field, data);
					// mark as rendered
					$(captcha_field).data('forminator-recapchta-widget', widget);
					this.responsive_captcha();
				}
			}
		},
		hide: function() {
			this.$el.hide();
		},
		/**
		 * Return JSON object if possible
		 *
		 * We tried our best here
		 * if there is an error/exception, it will return empty object/array
		 *
		 * @param string
		 * @param type ('array'/'object')
		 */
		maybeParseStringToJson: function (string, type) {
			var object = {};
			// already object
			if (typeof string === 'object') {
				return string;
			}

			if (type === 'object') {
				string = '{' + string.trim() + '}';
			} else if(type === 'array') {
				string = '[' + string.trim() + ']';
			} else {
				return {};
			}

			try {
				// remove trailing comma, duh
				/**
				 * find `,`, after which there is no any new attribute, object or array.
				 * New attribute could start either with quotes (" or ') or with any word-character (\w).
				 * New object could start only with character {.
				 * New array could start only with character [.
				 * New attribute, object or array could be placed after a bunch of space-like symbols (\s).
				 *
				 * Feel free to hack this regex if you got better idea
				 * @type {RegExp}
				 */
				var trailingCommaRegex = /\,(?!\s*?[\{\[\"\'\w])/g;
				string = string.replace(trailingCommaRegex, '');

				object = JSON.parse(string);
			} catch (e) {
				console.error(e.message);
				if (type === 'object') {
					object = {};
				} else if(type === 'array') {
					object = [];
				}
			}

			return object;

		},

	});

	// A really lightweight plugin wrapper around the constructor,
	// preventing against multiple instantiations
	$.fn[pluginName] = function (options) {
		return this.each(function () {
			if (!$.data(this, pluginName)) {
				$.data(this, pluginName, new ForminatorFront(this, options));
			}
		});
	};

	// hook from wp_editor tinymce
	$(document).on('tinymce-editor-init', function (event, editor) {
		// trigger editor change to save value to textarea,
		// default wp tinymce textarea update only triggered when submit
		editor.on('change', function () {
			// only forminator
			if (editor.id.indexOf('forminator-wp-editor-') === 0 ) {
				editor.save();
			}

		});
	});

})(jQuery, window, document);

// noinspection JSUnusedGlobalSymbols
var forminator_render_captcha = function () {
	// TODO: avoid conflict with another plugins that provide recaptcha
	//  notify forminator front that grecaptcha loaded. anc can be used
	jQuery('.forminator-g-recaptcha').each(function () {
		// find closest form
		var form = jQuery(this).closest('form');
		if (form.length > 0) {
			var forminatorFront = form.data('forminatorFront');
			if (typeof forminatorFront !== 'undefined') {
				forminatorFront.renderCaptcha(jQuery(this)[0]);
			}
		}
	});
};
