jQuery(document).ready(function($){

	"use strict";

	/**
	 * Helper function to get URL parameters by name
	 * http://stackoverflow.com/questions/901115/how-can-i-get-query-string-values-in-javascript
	 */
	function getParameterByName(name) {
		var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
		return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
	}


	/**
	 * Adding functionality for Upload input boxes in Custom Fields and Options
	 * New Code (new media manager)
	 * 
	 * IMPORTANT: Needs wp_enqueue_media(); anywhere in the theme to work in other
	 * places than regular post editor. We are calling it as soon as we initiate the
	 * QI Framework.
	 *
	 * Credit to: https://github.com/thomasgriffin/New-Media-Image-Uploader/blob/master/js/media.js
	 */
	
	// Prepare the variable that holds our custom media manager
	var qiMedia, qiMediaGallery;
  	
  	// For simple uploads
  	jQuery(document).on('click', '.upload_file_button', function() {

		var thisButton 	= jQuery(this),
  			uploadID 	= thisButton.prev('input');
		
		qiMedia = wp.media.frames.qiMedia = wp.media({
			frame: 'select',
			title: adminscripts_localized.mediaTitle,
			button: {
				text: adminscripts_localized.mediaButton
			},
		});

		qiMedia.on('select', function(){
			// Grab our attachment selection and construct a JSON representation of the model.
			var media_attachment = qiMedia.state().get('selection').first().toJSON();
			// Send the attachment URL to our custom input field via jQuery.
			uploadID.val( media_attachment.url );
		});
		qiMedia.open();
		return false;
	
	});

  	// For Gallery Uploads
	jQuery(document).on('click', '.gallery_pick_button', function() {

		var thisButton 	= jQuery(this),
  			uploadID 	= thisButton.prev('input');
		
		qiMediaGallery = wp.media.frames.qiMediaGallery = wp.media({
			frame: 'post',
			title: adminscripts_localized.mediaTitle,
			button: {
				text: adminscripts_localized.mediaButton
			},
		});

		qiMediaGallery.on( 'update', function(selection){
			// Send the gallery shortcode to our custom input field via jQuery.
			uploadID.val( wp.media.gallery.shortcode( selection ).string() );
		});
		qiMediaGallery.open();
		return false;
	
	});


	/**
	 * Adding functionality for repeatable input boxes
	 */

	jQuery(document).on('click', '.repeatable-add', function(e){
		var thisRepeat = jQuery(this),
			field = thisRepeat.closest('td').find('.custom_repeatable li:last').clone(true),
			fieldLocation = thisRepeat.closest('td').find('.custom_repeatable li:last');
		// Reset new item, and increase index number for inputs
		jQuery('input:not([type=radio], [type=button]), textarea, select', field).val('').attr('name', function(index, name) {
			if (name) {
				return name.replace(/(\d+)/, function(fullMatch, n) {
					return Number(n) + 1;
				});
			}
		});
		// Set placeholder value for colorpickers
		jQuery('input.repeat-color', field).val('#')
		// Set radio inputs
		jQuery('input:radio', field).attr('name', function(index, name) {
			if (name) {
				return name.replace(/(\d+)/, function(fullMatch, n) {
					return Number(n) + 1;
				});
			}
		});
		// Increase textarea ID number for WYSIWYG editors
		jQuery('.wp-editor-area', field).attr('id', function(index, id) {
			if (id) {
				return id.replace(/(\d+)/, function(fullMatch, n) {
					return Number(n) + 1;
				});
			}
		});
		// Prepare new ID and name for wp_editor
		var newEditorID = jQuery('.wp-editor-area', field).attr('id'),
		 	newEditorName = jQuery('.wp-editor-area', field).attr('name');
		// Remove current editor and put a textarea instead
		jQuery('.wp-editor-area.repeatable-editor', field).replaceWith('');
		jQuery('.mce-tinymce.mce-container.mce-panel', field).replaceWith('<textarea class="wp-editor-area repeatable-editor" id="'+newEditorID+'" name="'+newEditorName+'"></textarea>');
		// Increase new item title index
		var index = parseInt( jQuery('.repeat-index', field).html() );
		jQuery('.repeat-index', field).html(++index);
		// Insert newly added item in DOM
		field.insertAfter(fieldLocation, jQuery(this).closest('td'));
		
		// Enable Repeatable Editors
		if ( jQuery('.repeatable-editor').length ) {
			tinyMCE.init({
				selector: 'textarea.repeatable-editor',
				mode: 'specific_textareas',
				content_css: adminscripts_localized.includes_url + 'js/tinymce/skins/wordpress/wp-content.css',
				menubar : false,
				plugins: "textcolor",
				toolbar1: "styleselect | bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | undo redo",
			});
		}
		
		return false;
	});


	jQuery(document).on('click', '.repeatable-remove', function(e){
		if ( jQuery('.custom_repeatable .fields-set').length != 1 ) {
			jQuery(this).parents('li').remove();
		} else {
			// If there is only one set, just clean it up
			jQuery(this).parent().find('input').val('');
		}
		return false;
	});

	// Setting a variable 
	var sortablePrevChecked;

	jQuery('.custom_repeatable').sortable({
		opacity: 0.6,
		revert: true,
		cursor: 'move',
		handle: '.sort',
		start: function(event, ui) {
			sortablePrevChecked = ui.item.find('input:checked').val();
		},
		update: function(event, ui) {
			// Renumber Array indexes when re ordered
			jQuery(this).data().uiSortable.currentItem.parent().find('.fields-set').each(function(rowIndex){
				jQuery(this).find('input[name], textarea[name], select[name]').each(function(){
					var selectName;
					selectName = jQuery(this).attr('name');
					selectName = selectName.replace(/\[[0-9]+\]/g, '['+rowIndex+']');
					jQuery(this).attr('name',selectName);
				});
			});
			ui.item.find(':radio[value="'+sortablePrevChecked+'"]').prop("checked", true);
		},
	});

	// Enable Fieldset Toggle
	jQuery(document).on('click', '.custom_repeatable .fields-toggle', function(e){
		var thisToggle = jQuery(this);
		thisToggle.next('.fields-wrapper').slideToggle();
		thisToggle.find('i').toggleClass('fa-flip-vertical');
	});
	
	// End repeatable section


	// Enables Color Picker for Admin Options
	jQuery(document).on('click', '.quadropickcolor', function(e){
		var colorPicker = jQuery(this).next('div'),
			input = jQuery(this).prev('input');
		colorPicker.farbtastic(input);
		colorPicker.children().show();
		e.preventDefault();
		jQuery(document).mousedown( function() {
			jQuery(colorPicker).children().hide();
			jQuery('#bg-color').trigger('change');
		});
	});


	/**
	 * Post selection and pickers functionality
	 */

	// Enables Posts Select functionality in custom fields
	jQuery(document).on('click', '.posts-adder', function(e){
		// Grab all selected
		var $selPosts = jQuery(e.target).prev('.posts-picker').find('option:selected'),
			$listContainer = jQuery(e.target).next();
		// Map them and construct icon prefixed li's with Posts' ID as data-id
		$selPosts.map(function(){
			// Get current posts list and check if current post is already there
			var $currentPosts = $listContainer.next().val().split(', ');
			if ( jQuery.inArray( jQuery(this).val(), $currentPosts ) == -1 ) {
				var thisId = jQuery(this).val();
				// If it isn't, add it
				$listContainer.append('<li data-id="' + thisId + '"><label class="li-mover"><i class="remove-post fa fa-times"></i> ' + jQuery(this).text() + '</label><span class="qi-mod-action-links"><a href="' + adminscripts_localized.generalPostLink + thisId + '&qi=internal-preview" target="_blank" class="qi-preview-link"><i class="fa fa-eye"></i></a><a href="' + adminscripts_localized.generalEditLink.replace('1', thisId) + '" class="qi-edit-link"><i class="fa fa-pencil"></i></a></span></li>');
			}
		});

		// Grabs current li's data IDs and puts them into the hidden field
		var $postsIds = '';
		$listContainer.find('li').each(function(){
			$postsIds += jQuery(this).data('id') + ', ';
		});
		if ( $postsIds !== '' ) {
			$listContainer.next().val($postsIds);
		}
	});

	// Enables Posts Select functionality in custom fields on double click
	jQuery(document).on('dblclick', '.posts-picker option', function(e){
		// Grab all selected + general edit link
		var $selPosts 		= jQuery(e.target),
			$listContainer 	= $selPosts.parent().siblings('ul');
		// Map them and construct icon prefixed li's with Posts' ID as data-id
		$selPosts.map(function(){
			// Get current posts list and check if current post is already there
			var $currentPosts = $listContainer.next().val().split(', ');
			if ( jQuery.inArray( jQuery(this).val(), $currentPosts ) == -1 ) {
				var thisId = jQuery(this).val();
				// If it isn't, add it
				$listContainer.append('<li data-id="' + thisId + '"><label class="li-mover"><i class="remove-post fa fa-times"></i> ' + jQuery(this).text() + '</label><span class="qi-mod-action-links"><a href="' + adminscripts_localized.generalPostLink + thisId + '&qi=internal-preview" target="_blank" class="qi-preview-link"><i class="fa fa-eye"></i></a><a href="' + adminscripts_localized.generalEditLink.replace('1', thisId) + '" class="qi-edit-link"><i class="fa fa-pencil"></i></a></span></li>');
			}
		});

		// Grabs current li's data IDs and puts them into the hidden field
		var $postsIds = '';
		$listContainer.find('li').each(function(){
			$postsIds += jQuery(this).data('id') + ', ';
		});
		if ( $postsIds != '' ) {
			$listContainer.next().val($postsIds);
		}
	});


	// Enables Posts Sorting in Posts Select fields
	jQuery('.sel-posts-container').sortable({
		opacity: 0.6,
		revert: true,
		cursor: 'move',
		handle: '.li-mover',
		update: function (e, ui) {
			// Grabs current li's data IDs and puts them into the hidden field
			var $postsIds = '';
			jQuery(this).find('li').each(function(){
				$postsIds += jQuery(this).data('id') + ', ';
			});
			jQuery(this).next().val($postsIds);
		}
	});

	// Enables Remover for posts list items
	jQuery(document).on("click", '.remove-post', function(e){
		// Grab parent variable position before we swipe this li out
		var $containerUl = jQuery(this).parents('ul');
		// Remove this Parent li
		jQuery(this).parents('li').remove();
		// Grabs current li's data IDs and puts them into the hidden field
		var $postsIds = '';		
		$containerUl.find('li').each(function(){
			$postsIds += jQuery(this).data('id') + ', ';
		});
		$containerUl.next().val($postsIds);
	});


	// Removes empty select boxes when nothing to show
	jQuery('.posts-picker').each(function(){
		if ( ! jQuery(this).find('option').length ) {
			jQuery(this).hide();
			jQuery(this).next('.posts-adder').hide();
		}
	});


	/**
	 * Modules Type Filter in Posts Picker
	 */
	jQuery(document).on( 'change', '.module-type-filter', function(){
		var filter = jQuery(this),
			type = filter.find(':selected').attr('class');
		filter.parent().next().find('option').hide();
		filter.parent().next().find('option.qi-type-'+type).fadeIn('fast');
	});

	
	/**
	 * Handles selection boxes appearing when chosing selection methods
	 */
	
	// First, hide the selectors by default and show already chosen selector
	var allSelectors = jQuery('.qcustom-selector, .qtax-selector, .qformat-selector').parents('tr');
	
	jQuery('select[id*=_method]').each(function(){
		jQuery(this).parents('tr').siblings('tr').find('.qcustom-selector, .qtax-selector, .qformat-selector').parents('tr').hide();
		jQuery(this).parents('tr').siblings('tr').find('.q' + jQuery(this).val() + '-selector').parents('tr').fadeIn();
	})
	// Then, detect change on selection method and show the proper select box
	jQuery(document).on('change', 'select[id*=_method]', function(){
		jQuery(this).parents('tr').siblings('tr').find('.qcustom-selector, .qtax-selector, .qformat-selector').parents('tr').hide();
		jQuery(this).parents('tr').siblings('tr').find('.q' + jQuery(this).val() + '-selector').parents('tr').fadeIn();
	})


	/**
	 * Little handler to make Greyed Out custom fields take full width space
	 */
	jQuery('#quadro_page_greyed_out').parent('td').prev('th').hide();


	/**
	 * Ajax Function for Options Backup and Restore
	 */
	jQuery('#quadro_backup_button').live('click', function(){
	
		var answerText = jQuery('#backup_confirm').val(),
			answer = confirm(answerText);
		
		if ( answer ) {
			var clickedObject = jQuery(this),
				clickedID = jQuery(this).attr('id'),
				nonce = jQuery('#quadro_nonce').val();
		
			var data = {
				action: 'quadro_ajax_options_action',
				type: 'backup_options',
				security: nonce
			};
						
			jQuery.post(ajaxurl, data, function(response) {				
				//check nonce
				if( response == -1 ) { 
					//failed
				} else {
					window.setTimeout(function(){
						location.reload();
					}, 1000);
				}
			});
			
		}
		
	return false;
					
	}); 
	
	//restore button
	jQuery('#quadro_restore_button').live('click', function(){
	
		var answerText = jQuery('#restore_confirm').val(),
			answer = confirm(answerText);
		
		if ( answer ){
					
			var nonce = jQuery('#quadro_nonce').val();
		
			var data = {
				action: 'quadro_ajax_options_action',
				type: 'restore_options',
				security: nonce
			};
						
			jQuery.post(ajaxurl, data, function(response) {			
				//check nonce
				if( response == -1 ) { 
					//failed
				} else {
					window.setTimeout(function(){
						location.reload();                        
					}, 1000);
				}
			});
	
		}
	
	return false;
					
	});


	/**
	 * Select All Btn For Textareas
	 */
	jQuery('#quadro_select_button').live('click', function(){
		jQuery(this).prev('textarea').select();
		return false;
	});


	/**
	 * Ajax Transfer (Import/Export) Option
	 */
	jQuery('#quadro_import_button').live('click', function(){
	
		var answerText = jQuery('#import_confirm').val(),
			answer = confirm(answerText);
		
		if ( answer ) {
					
			var nonce = jQuery('#quadro_nonce').val();
			
			var import_data = jQuery('#export_data').val();

			var data = {
				action: 'quadro_ajax_options_action',
				type: 'import_options',
				security: nonce,
				data: import_data
			};
						
			jQuery.post(ajaxurl, data, function(response) {
				//check nonce
				if ( response == -1 ) { 
					//failed
				} else 	{
					window.setTimeout(function(){
						location.reload();
					}, 1000);
				}
			});
			
		}
		
		return false;
					
	});


	/**
	 * Ajax Dummy Content Install Option
	 */
	jQuery('#quadro_dcontent_button').live('click', function(){
	
		var answerText = jQuery('#dcontent_confirm').val(),
			answerSuccess = jQuery('#dcontent_success').val(),
			answer = confirm(answerText);
		
		if ( answer ) {
					
			var nonce = jQuery('#quadro_nonce').val(),
				loaderImg = jQuery('.loader-icon');
				loaderImg.fadeIn();

			var data = {
				action: 'quadro_ajax_options_action',
				type: 'dcontent_import',
				security: nonce,
			};

			jQuery.post(ajaxurl, data, function(response) {
				//check nonce
				if ( response == -1 ) { 
					// Failed
					loaderImg.fadeOut();
					alert(adminscripts_localized.importFail);
				} else 	{
					loaderImg.fadeOut(function(){
						var answerSuccessResp = confirm(answerSuccess);
						if (answerSuccessResp){
							window.setTimeout(function(){
								location.reload();
							}, 1000);
						}
					});
				}
			});
			
		}
		
		return false;
					
	});


	/**
	 * NEW Ajax RMS Install Option
	 */
	jQuery('#quadro_dcontentx_button').live('click', function(){
					
		var thisWrapper = jQuery('.dcontent-wrapper');
		jQuery.colorbox({
			width: '85%',
			height: '85%',
			close: '<i class="fa fa-close"></i>',
			inline: true,
			href: thisWrapper,
			onComplete: function(){},
			onCleanup: function(){},
		});
		
		return false;
					
	});


	/**
	 * RMS Details Preview
	 */
	jQuery('.dcontent-view-details').live('click', function(){
		
		jQuery(this).parents('.dcontent-pack').addClass('selected-pack').siblings().removeClass('selected-pack');

		var detailsWrapper = jQuery('.dcontent-pack-details'),
			nonce = jQuery('#quadro_nonce').val(),
			data = {
				action: 'quadro_ajax_dcontent',
				type: 'dcontent_details',
				pack: jQuery(this).data('pack'),
				security: nonce,
			};
		
		jQuery.post(ajaxurl, data, function(response) {
			//check nonce
			if ( response != -1 ) {
				jQuery('.dcontent-packs').addClass('packs-view-small');
				detailsWrapper.html(response).removeClass('dcontent-details-hidden').addClass('dcontent-details-shown');
				jQuery('#cboxLoadedContent').animate({scrollTop: 0}, 500);
			}
		});
		
		return false;
					
	});


	/**
	 * RMS Thumbs Previewer
	 */
	jQuery('.dcontent-thumbs img').live('click', function(){
		var thisImg = jQuery(this),
			selImg = thisImg.clone();
		thisImg.addClass('selected-thumb').siblings().removeClass('selected-thumb');
		jQuery('.dcontent-thumb-screener').html(selImg);
	});


	/**
	 * Back to RMS Button
	 */
	jQuery('.backto-dcontent').live('click', function(){
		jQuery('.dcontent-pack-details').html('').toggleClass('dcontent-details-hidden dcontent-details-shown');
		jQuery('.dcontent-packs').removeClass('packs-view-small');
		jQuery('.dcontent-pack').removeClass('selected-pack');

		return false;
	});


	/**
	 * RMS Import AJAX Call
	 */
	jQuery('.dcontent-install-pack').live('click', function(){
		
		var pack = jQuery(this).data('pack');

		swal({
			title: "RMS Import",
			text: adminscripts_localized.importConfirm + '\n\n' + adminscripts_localized.importPlugins,
			showCancelButton: true,
			confirmButtonColor: "#22aa00",
			confirmButtonText: "OK",
			closeOnConfirm: true
		},
			function(){

				var nonce = jQuery('#quadro_nonce').val(),
				loaderIcon = jQuery('.dpack-loader');

				loaderIcon.fadeIn();

				// Program Feedback Messages
				var feedbackContainer = jQuery('.dcontent-import-process');
				window.setTimeout(function(){
					feedbackContainer.append('<p class="rms-imp-feedb in-process">Fetching posts</p>');
				}, 200);
				window.setTimeout(function(){
					jQuery('.rms-imp-feedb').removeClass('in-process');
					feedbackContainer.append('<p class="rms-imp-feedb in-process">Setting Theme Options</p>');
				}, 1200);
				window.setTimeout(function(){
					jQuery('.rms-imp-feedb').removeClass('in-process');
					feedbackContainer.append('<p class="rms-imp-feedb in-process">Processing Images</p>');
				}, 2200);

				var data = {
					action: 'quadro_ajax_dcontent',
					type: 'dcontent_importx',
					pack: pack,
					security: nonce,
				};

				jQuery.post(ajaxurl, data, function(response) {
					//check nonce
					if ( response == -1 ) { 
						// Failed
						loaderIcon.fadeOut();
						alert(adminscripts_localized.importFail);
					} else 	{
						jQuery('.dcontent-import-process').html('<p>Fetching posts</p><p>Setting Theme Options</p><p>Processing Images</p>')
						loaderIcon.fadeOut(function(){
							swal({
								title: "RMS Import",
								text: adminscripts_localized.importSuccess,
								type: "success",
								confirmButtonText: "RELOAD",
								closeOnConfirm: false
								},
							function(){
									window.setTimeout(function(){
										location.reload();
									}, 300);
							});
						});
					}
				});

			}
		);
		
		return false;
					
	});


	/**
	 * Ajax Function for Artisan Themes Typekit Activation
	 */
	jQuery('#quadro_typekit_activate').live('click', function(){
		
		var nonce = jQuery('#quadro_nonce').val();

		// make request
		var data = {
			action: 'quadro_ajax_options_action',
			type: 'typekit_activate',
			security: nonce
		};
					
		jQuery.post(ajaxurl, data, function(response) {				
			alert(response);
		});
		
		return false;
					
	});


	/**
	 * Ajax Function for Artisan Themes User check
	 */
	jQuery('#quadro_user_check').live('click', function(){
		
		var nonce = jQuery('#quadro_nonce').val(),
			lic_username = jQuery('input[name="quadro_'+adminscripts_localized.theme_slug+'_options[quadro_username]"]').val(),
			lic_password = jQuery('input[name="quadro_'+adminscripts_localized.theme_slug+'_options[quadro_userpass]"]').val(),
			lic_license = jQuery('input[name="quadro_'+adminscripts_localized.theme_slug+'_options[quadro_userlicense]"]').val();

		// highlight empty fields and return false
		if ( lic_username == '' ) jQuery('input[name="quadro_'+adminscripts_localized.theme_slug+'_options[quadro_username]"]').addClass('opts-incomplete-field');
		if ( lic_password == '' ) jQuery('input[name="quadro_'+adminscripts_localized.theme_slug+'_options[quadro_userpass]"]').addClass('opts-incomplete-field');
		// if ( lic_license == '' ) jQuery('input[name="quadro_'+adminscripts_localized.theme_slug+'_options[quadro_userlicense]"]').addClass('opts-incomplete-field');
		
		if ( jQuery('.opts-incomplete-field').length ) {
			jQuery('.opts-incomplete-field').css({ backgroundColor: "#f3f37e" }).after('<small class="incomplete-notice"> Oops! This field cannot be empty.</small><br />');
			return false;
		}

		var data = {
			action: 'quadro_ajax_options_action',
			type: 'user_check',
			username: lic_username,
			userpass: lic_password,
			license: lic_license,
			security: nonce
		};
					
		jQuery.post(ajaxurl, data, function(response) {				
			alert(response);
		});
		
	return false;
					
	});


	// Remove "incomplete fields" notice when fields get populated
	jQuery(document).on( 'keyup', '.opts-incomplete-field', function(){
		jQuery(this).removeClass('opts-incomplete-field').css({ backgroundColor: "#fff" }).next('.incomplete-notice').remove();
	});


	/**
	 * Ajax Portfolio Transients Delete Option
	 */
	jQuery('#quadro_portf_transients_delete_button').live('click', function(){
	
		var nonce = jQuery('#quadro_nonce').val();
		var data = {
			action: 'quadro_ajax_options_action',
			type: 'portfolio_transients_delete',
			security: nonce,
		};
					
		jQuery.post(ajaxurl, data, function(response) {
			//check nonce
			if ( response == -1 ) { 
				//failed
			} else 	{
				alert(adminscripts_localized.portfTransientsRefreshed);
			}
		});
		
		return false;
					
	});


	/**
	 * Ajax Set Skin Option
	 */
	jQuery('#quadro_skin_button').live('click', function(){

		var answerText = jQuery('#skin_confirm').val(),
			answer = confirm(answerText);
		
		if (answer){
	
			var nonce = jQuery('#quadro_nonce').val();

			var sel_option = jQuery('.skin-select-radio:checked').val();
			
			var selected_skin = jQuery.parseJSON(jQuery('#'+sel_option+'-skin').val());
		
			var data = {
				action: 'quadro_ajax_options_action',
				type: 'set_skin',
				security: nonce,
				data: selected_skin
			};
						
			jQuery.post(ajaxurl, data, function(response) {
				//check nonce
				if(response==-1){ 
					//failed
				} else 	{
					alert(response);
					window.setTimeout(function(){
						location.reload();
					}, 1000);
				}
			});
			
		}
		
		return false;
					
	});


	// Show or Hide Modules Metaboxes depending on Selected Modules
	// Add Module type to body class
	// ************************************************************
	if ( jQuery('#mod-type-metabox').length ) {
		
		var moduleSelector = jQuery('#quadro_mod_type');

		// First, get selected type on loading and display metabox
		var selType = moduleSelector.val();
		// Show or Hide Metabox
		jQuery('#mod-' + selType + '-qi-type-metabox').addClass('selected-type-metabox');
		// Add module class to body
		jQuery('body').addClass('qimodule-' + selType);

		// Reset Shown Module on change
		moduleSelector.change(function(){
			var selType = moduleSelector.val();
			// Show or Hide Metabox
			jQuery('.selected-type-metabox').fadeOut().removeClass('selected-type-metabox');
			jQuery('#mod-' + selType + '-qi-type-metabox').fadeIn().addClass('selected-type-metabox').removeClass('tab-hidden');
			// Add module class to body
			jQuery('body').alterClass('qimodule-*').addClass('qimodule-' + selType);
			// Scroll to editor if Canvas selected
			if ( selType == 'canvas' ) {
				// jQuery('html, body').animate({scrollTop: 0}, 600);
				jQuery('html, body').animate({ scrollTop: jQuery('#postdivrich').offset().top-20 }, 800);
			}
		});

	}


	// Show or Hide Specific Theme Options depending on selected theme options
	// ************************************************************
	
	// Define operators for posible conditions
	var operators = {
		'==': function( a, b ){ return a == b; },
		'!=': function( a, b ){ return a != b; },
		'<=': function( a, b ){ return a <= b; },
		'>=': function( a, b ){ return a >= b; },
		'<': function( a, b ){ return a < b; },
		'>': function( a, b ){ return a > b; },
	};

	function showHideFields() {
		// Function to loop through all hidden fields and show/hide if conditions met
		jQuery('*[data-hide="hideme"]').each(function(){
			var showConditions = jQuery(this).data('if'),
				conditionsCount = showConditions.length;

			// jQuery.each(showConditions, function(index, item) {
			// 	var op = typeof item['operator'] != 'undefined' ? item['operator'] : '==';
			// 	// if ( jQuery('[name$="['+item['id']+']"]'+item['type']).val() == item['val'] ) conditionsCount = conditionsCount - 1;
			// 	if ( operators[op]( jQuery('[name$="['+item['id']+']"]'+item['type']).val(), item['val'] ) ) conditionsCount = conditionsCount - 1;
			// });

			jQuery.each(showConditions, function(index, item) {
                // go for combined conditions first
                if ( typeof item['combined'] != 'undefined' && item['combined'] == 'true' ) {
                    // grab recursive conditions array, count it and define operator
                    var combination = item['combination'],
                    	combConditionsCount = combination.length,
                    	combAddition = 0,
                    	combOperator = item['combOperator'] == 'or' ? 1 : combConditionsCount;
                    // go through each recursive conditions array
                    jQuery.each(combination, function(combIndex, combItem) {
                    	var op = typeof combItem['operator'] != 'undefined' ? combItem['operator'] : '==';
                    	if ( operators[op]( jQuery('[name$="['+combItem['id']+']"]'+combItem['type']).val(), combItem['val'] ) ) combAddition = combAddition + 1;
                    });
                    // define result
                    if ( combAddition >= combOperator	 ) conditionsCount = conditionsCount - 1;
                } else {
                    var op = typeof item['operator'] != 'undefined' ? item['operator'] : '==';
                    if ( operators[op]( jQuery('[name$="['+item['id']+']"]'+item['type']).val(), item['val'] ) ) conditionsCount = conditionsCount - 1;
                }
            });

			// We substracted 1 per each met condition, so we'll
			// show the option field if the count has reached 0.
			// Hide it, if the count isn't 0.
			if ( conditionsCount == 0 ) {
				jQuery(this).parents('tr').fadeIn('fast');
			} else {
				jQuery(this).parents('tr').hide();
			}
		});
	}

	// Show or hide fields if conditions met
	showHideFields();

	// Trigger conditions check once form changes
	jQuery('#quadro_options_form').change(function(){
		showHideFields();
	})


	// Show or Hide Template Metaboxes depending on Selected Template
	// ************************************************************
	if ( jQuery('#page_template').length ) {
		
		// First, get selected type on loading and display metabox
		var selTemplate = jQuery('#page_template').val();
		// Hide editor for Modular Template
		if ( selTemplate == 'template-modular.php' ) jQuery('#postdivrich').hide();
		// Present according option metaboxes
		selTemplate = selTemplate.substring(selTemplate.indexOf('-') +1).split('.');
		jQuery('#' + selTemplate[0] + '-qi-template-metabox').addClass('selected-template-metabox');

		// Reset Shown Module on change
		jQuery("#page_template").live('change',function(){
			var selTemplate = jQuery(this).val();
			// Hide or show editor for Modular Template
			if ( selTemplate == 'template-modular.php' ) {
				jQuery('#postdivrich').hide();
			} else {
				jQuery('#postdivrich').show();
				jQuery('#modular-qi-template-metabox').hide();
			}
			// Present according option metaboxes
			selTemplate = selTemplate.substring(selTemplate.indexOf('-') +1).split('.');
			jQuery('.selected-template-metabox').removeClass('selected-template-metabox');
			jQuery('#' + selTemplate[0] + '-qi-template-metabox').addClass('selected-template-metabox');
		});

	}


	// Togles Pattern Selector display in Custom Fields
	jQuery('#pattern-picker-opener').click(function(){
		jQuery('#pattern-selector').toggle();
	});

	
	// Opens Colorbox Lightbox for Icon Picker
	jQuery('.icon-picker-opener').live('click', function() { 
		var thisHandler = jQuery(this),
			thisPicker = thisHandler.next().find('.icons-wrapper');
		jQuery.colorbox({
			width: '60%',
			height: '80%',
			close: '<i class="fa fa-close"></i>',
			inline: true,
			href: thisPicker,
			onComplete: function(){
				// Adds focus on icon search when opening icon selector
				jQuery('.icon-search').focus();
			},
			onCleanup: function(){ 
				if ( thisPicker.find('.icon-selector input:checked + i').attr('class') ) {
					// Adds copy of selected icon to Working Fields (input + icon placeholder)
					thisHandler.prev('i').attr('class', 'icon-placeholder ' + thisPicker.find('.icon-selector input:checked + i').attr('class'));
					thisHandler.siblings('input').val(thisPicker.find('.icon-selector input:checked + i').attr('class'));
				}
			},
		});
	});


	// Enable Icon Picker opening when clicking
	// on selected icon
	jQuery(document).on( 'click', '.icon-placeholder', function(e){
		jQuery(e.target).next('a').click();
	});


	// Make the icon picker close on double clicks over icons
	jQuery(document).on( 'dblclick', '.icon-selector i', function(e){
		jQuery.colorbox.close();
	});
	

	// Responds to Icon Search for Icon Picker
	jQuery(document).on( 'keyup', '.icon-search', function(e){
		var iSearcher	= jQuery(this),
			iSearch 	= iSearcher.val(),
			iPicker 	= iSearcher.parent().next('.icon-selector');
		// Hide all labels to begin with
		iPicker.find('h3, label').hide();
		// Show Icons which contain the searched terms
		var iShow = iPicker.find('i[class*="' + iSearch + '"]');
		iShow.parent().show();
		iShow.parent().parent().prev('h3').show();
		// Show all if search empty
		if ( iSearch == '' ) iPicker.find('h3, label').show();
	});


	/**
	 * Adds Portfolio Sortable Functionality in backend
	 */
	jQuery('#sortable-table tbody').sortable({
		
		axis: 'y',
		handle: '.draggable',
		placeholder: 'ui-state-highlight',
		forcePlaceholderSize: true,
		update: function(event, ui) {
		
			var theOrder = jQuery(this).sortable('toArray');

			var data = {
				action: 'quadro_update_portfolio_order',
				postType: jQuery(this).attr('data-post-type'),
				order: theOrder
			};

			jQuery.post(ajaxurl, data);
			
			jQuery('.order-updated').fadeTo('slow', 1).animate({opacity: 1.0}, 600).fadeTo('slow', 0);
			
		}
		
	}).disableSelection();


	// Dismisses Welcome Panel message
	jQuery('.welc-msg-dismiss').click(function(){
		jQuery('#qi-welcome-panel').fadeOut();
		return false;
	});


	/**
	 * Handling Mailchimp Form Option-Cookies to avoid
	 * showing it again after the user has already
	 * submitted the form once successfully.
	 */
	if ( jQuery('#mc_embed_signup').length ) {
		var mcForm = document.getElementById('mce-success-response');
		if( window.addEventListener ) {
			// Normal browsers
			mcForm.addEventListener('DOMSubtreeModified', mailchimpSent, false);
		} else
		if ( window.attachEvent ) {
			// IE
			mcForm.attachEvent('DOMSubtreeModified', mailchimpSent);
		}
	}

	function mailchimpSent() {

		// Store cookie for this user stating it has already
		// submitted the form once successfully
		var nonce = jQuery('#mailchimp_nonce').val();
		var data = {
			action: 'quadro_mailchimp_submit_check',
			security: nonce
		};
		// Call function via ajax
		jQuery.post(ajaxurl, data, function(response) {});
			
	}


	// Adding 'internal-preview' parameter to Modules Preview button
	if ( jQuery('body').hasClass('post-type-quadro_mods') ) {
		if ( jQuery('#preview-action').length ) {
			var	currentPreview = jQuery('#sample-permalink a').attr('href');
			jQuery('#preview-action').before('<a class="preview button" href="' + currentPreview + '?qi=internal-preview" id="module-view">View Module</a>').remove();
			jQuery('#edit-slug-buttons').after('<a class="slug-view-mod" href="' + currentPreview + '?qi=internal-preview" id="module-view">View Module</a>');
			jQuery('#message.updated p a').attr('href', currentPreview + '?qi=internal-preview');
		}
	}


	/**
	 * Adding "Add to Page" & "Duplicate" links to Module Type select metabox
	 */
	jQuery('#mod-type-metabox').find('td').append('<div class="module-helpers"></div><div style="display: none;"><div id="qi-page-adder"></div></div>');
	jQuery('.module-helpers').append('<a href="#qi-page-adder" class="in-mod-addto-page">'+ adminscripts_localized.addThisModule +'</a>');
	jQuery('.module-helpers').append('<a href="admin.php?action=qi_duplicate_post_as_draft&amp;post=' + jQuery('#post_ID').val() + '" class="in-mod-duplicate-link" target="_blank">'+adminscripts_localized.dupThisModule +'</a>');


	/**
	 * Modify add to page button if module already published
	 */
	if ( jQuery('#original_post_status').val() == 'publish' ) {
		jQuery('.in-mod-addto-page').removeClass('in-mod-addto-page').addClass('in-mod-addto-page-publish');
	}


	/**
	 * Ask for module publishing before enabling add to page functionality
	 */
	jQuery(document).on( 'click', '.in-mod-addto-page', function(e){
		e.preventDefault();
		alert(adminscripts_localized.publishFirst);
	});


	/**
	 * Handling "Add this Module to Page"
	 */
	jQuery('.in-mod-addto-page-publish').colorbox({
		width: '60%',
		height: '85%',
		close: '<i class="fa fa-close"></i>',
		inline: true,
		onComplete: function(){
			// Grab previously loaded content if there is one
			var	prevLoaded = jQuery('#already-loaded').val();
			if ( prevLoaded == undefined ) {
				// Run first Ajax function
				var data = { action: 'qi_ajax_module_adder' };
				jQuery.post(ajaxurl, data, function(response) {				
					if( response != -1 ) { 
						jQuery('#qi-page-adder').html(response);
						// Set previously loaded content
						jQuery('#already-loaded').val('loaded');
					}
				});
			}
		},

	});

	jQuery(document).on( 'change', '#qi-modular-pages', function(){
		var data = { 
			action: 'qi_ajax_module_fields', 
			page_id: jQuery(this).val(),
			mod_id: jQuery('#post_ID').val(),
		};
		jQuery.post(ajaxurl, data, function(response) {				
			if( response != -1 ) { 
				jQuery('.qi-page-modules').html(response);
				jQuery('.added-module').fadeIn();
				// Enables Posts Sorting in Posts Select fields
				jQuery('.sel-posts-container').sortable({
					opacity: 0.6,
					revert: true,
					cursor: 'move',
					handle: '.li-mover',
					update: function (e, ui) {
						// Grabs current li's data IDs and puts them into the hidden field
						var $postsIds = '';
						jQuery(this).find('li').each(function(){
							$postsIds += jQuery(this).data('id') + ', ';
						});
						jQuery(this).next().val($postsIds);
					}
				});
			}
		});
	});

	jQuery(document).on( 'click', '#page-mods-save', function(e){
		e.preventDefault();
		jQuery('.saved-mods-receiver').fadeOut();
		var data = { 
			action: 'qi_ajax_module_save', 
			page_id: jQuery('#qi-modular-pages').val(),
			mods_list: jQuery('#modules-to-save').val(),
		};
		jQuery.post(ajaxurl, data, function(response) {				
			if( response != -1 ) { 
				jQuery('.saved-mods-receiver').html(response).fadeIn();
			}
		});
	});


	// Handle Scrolling to anchors in pages
	jQuery(document).on( 'click', '.scroll-to-link', function(){
		var thisLink = jQuery(this);
		if ( thisLink.is('a') ) {
			var target = jQuery( thisLink.attr('href') );
		} else {
			var target = jQuery( thisLink.find('a').attr('href') );
		}
		jQuery('html, body').animate({ scrollTop: target.offset().top - 50
		}, 600, 'swing');
		return false;
	});


	/**
	 * Getting Started Page Tabs
	 */
	jQuery('#gs-tabs-list li').click(function(i){
		jQuery(this).addClass('current').siblings().removeClass('current')
		.parent().next('#started-tabs').find('.gs-tab').removeClass('visible').end()
		.find('#'+ jQuery(this).attr('id') +'-tab').addClass('visible');
		return false;
	});

	// Check URL for 'current-tab' parameter and make specified
	// tab visible if selected (in use at Getting Started Page)
	if ( getParameterByName('page') === 'getting-started' ) {
		var currentTab = getParameterByName('current-tab');
		if ( currentTab !== null && currentTab !== '' ) {
			jQuery('#started-tabs').find('.gs-tab').removeClass('visible').end()
			.find('#'+currentTab+'-tab').addClass('visible');
			jQuery('#gs-tabs-list').find('li').removeClass('current').end()
			.find('#'+currentTab).addClass('current');
		}
	}

	// Getting Started FAQS Back to top links
	jQuery('.theme-faq').append( jQuery('<a class="scroll-to-link back-to-faqs" href="#theme-faqs-list"><i class="fa fa-angle-up"></i> ' + adminscripts_localized.backToTop + '</a>') );


	/**
	 * Admin Notices Dismiss Handler
	 */
	jQuery('.at-admin-notice .notice-dismiss').live('click', function(){
		
		var data = {
			action: 'at_notices_dismiss',
			notice: jQuery(this).parent().data('notice'),
			security: jQuery('#at_notices_nonce').val(),
		};
		jQuery.post(ajaxurl, data);
					
	}); 

	
});



/**
 * jQuery alterClass plugin
 * https://gist.github.com/peteboere/1517285
 *
 * Remove element classes with wildcard matching. Optionally add classes:
 *   $( '#foo' ).alterClass( 'foo-* bar-*', 'foobar' )
 *
 * Copyright (c) 2011 Pete Boere (the-echoplex.net)
 * Free under terms of the MIT license: http://www.opensource.org/licenses/mit-license.php
 *
 */
(function ( $ ) {
	
$.fn.alterClass = function ( removals, additions ) {
	
	var self = this;
	
	if ( removals.indexOf( '*' ) === -1 ) {
		// Use native jQuery methods if there is no wildcard matching
		self.removeClass( removals );
		return !additions ? self : self.addClass( additions );
	}
 
	var patt = new RegExp( '\\s' + 
			removals.
				replace( /\*/g, '[A-Za-z0-9-_]+' ).
				split( ' ' ).
				join( '\\s|\\s' ) + 
			'\\s', 'g' );
 
	self.each( function ( i, it ) {
		var cn = ' ' + it.className + ' ';
		while ( patt.test( cn ) ) {
			cn = cn.replace( patt, ' ' );
		}
		it.className = $.trim( cn );
	});
 
	return !additions ? self : self.addClass( additions );
};
 
})( jQuery );



/*!
	Colorbox 1.6.0
	license: MIT
	http://www.jacklmoore.com/colorbox
*/
(function(t,e,i){function n(i,n,o){var r=e.createElement(i);return n&&(r.id=Z+n),o&&(r.style.cssText=o),t(r)}function o(){return i.innerHeight?i.innerHeight:t(i).height()}function r(e,i){i!==Object(i)&&(i={}),this.cache={},this.el=e,this.value=function(e){var n;return void 0===this.cache[e]&&(n=t(this.el).attr("data-cbox-"+e),void 0!==n?this.cache[e]=n:void 0!==i[e]?this.cache[e]=i[e]:void 0!==X[e]&&(this.cache[e]=X[e])),this.cache[e]},this.get=function(e){var i=this.value(e);return t.isFunction(i)?i.call(this.el,this):i}}function h(t){var e=W.length,i=(A+t)%e;return 0>i?e+i:i}function a(t,e){return Math.round((/%/.test(t)?("x"===e?E.width():o())/100:1)*parseInt(t,10))}function s(t,e){return t.get("photo")||t.get("photoRegex").test(e)}function l(t,e){return t.get("retinaUrl")&&i.devicePixelRatio>1?e.replace(t.get("photoRegex"),t.get("retinaSuffix")):e}function d(t){"contains"in y[0]&&!y[0].contains(t.target)&&t.target!==v[0]&&(t.stopPropagation(),y.focus())}function c(t){c.str!==t&&(y.add(v).removeClass(c.str).addClass(t),c.str=t)}function g(e){A=0,e&&e!==!1&&"nofollow"!==e?(W=t("."+te).filter(function(){var i=t.data(this,Y),n=new r(this,i);return n.get("rel")===e}),A=W.index(_.el),-1===A&&(W=W.add(_.el),A=W.length-1)):W=t(_.el)}function u(i){t(e).trigger(i),ae.triggerHandler(i)}function f(i){var o;if(!G){if(o=t(i).data(Y),_=new r(i,o),g(_.get("rel")),!$){$=q=!0,c(_.get("className")),y.css({visibility:"hidden",display:"block",opacity:""}),I=n(se,"LoadedContent","width:0; height:0; overflow:hidden; visibility:hidden"),b.css({width:"",height:""}).append(I),j=T.height()+k.height()+b.outerHeight(!0)-b.height(),D=C.width()+H.width()+b.outerWidth(!0)-b.width(),N=I.outerHeight(!0),z=I.outerWidth(!0);var h=a(_.get("initialWidth"),"x"),s=a(_.get("initialHeight"),"y"),l=_.get("maxWidth"),f=_.get("maxHeight");_.w=(l!==!1?Math.min(h,a(l,"x")):h)-z-D,_.h=(f!==!1?Math.min(s,a(f,"y")):s)-N-j,I.css({width:"",height:_.h}),J.position(),u(ee),_.get("onOpen"),O.add(S).hide(),y.focus(),_.get("trapFocus")&&e.addEventListener&&(e.addEventListener("focus",d,!0),ae.one(re,function(){e.removeEventListener("focus",d,!0)})),_.get("returnFocus")&&ae.one(re,function(){t(_.el).focus()})}var p=parseFloat(_.get("opacity"));v.css({opacity:p===p?p:"",cursor:_.get("overlayClose")?"pointer":"",visibility:"visible"}).show(),_.get("closeButton")?B.html(_.get("close")).appendTo(b):B.appendTo("<div/>"),w()}}function p(){y||(V=!1,E=t(i),y=n(se).attr({id:Y,"class":t.support.opacity===!1?Z+"IE":"",role:"dialog",tabindex:"-1"}).hide(),v=n(se,"Overlay").hide(),M=t([n(se,"LoadingOverlay")[0],n(se,"LoadingGraphic")[0]]),x=n(se,"Wrapper"),b=n(se,"Content").append(S=n(se,"Title"),F=n(se,"Current"),P=t('<button type="button"/>').attr({id:Z+"Previous"}),K=t('<button type="button"/>').attr({id:Z+"Next"}),R=n("button","Slideshow"),M),B=t('<button type="button"/>').attr({id:Z+"Close"}),x.append(n(se).append(n(se,"TopLeft"),T=n(se,"TopCenter"),n(se,"TopRight")),n(se,!1,"clear:left").append(C=n(se,"MiddleLeft"),b,H=n(se,"MiddleRight")),n(se,!1,"clear:left").append(n(se,"BottomLeft"),k=n(se,"BottomCenter"),n(se,"BottomRight"))).find("div div").css({"float":"left"}),L=n(se,!1,"position:absolute; width:9999px; visibility:hidden; display:none; max-width:none;"),O=K.add(P).add(F).add(R)),e.body&&!y.parent().length&&t(e.body).append(v,y.append(x,L))}function m(){function i(t){t.which>1||t.shiftKey||t.altKey||t.metaKey||t.ctrlKey||(t.preventDefault(),f(this))}return y?(V||(V=!0,K.click(function(){J.next()}),P.click(function(){J.prev()}),B.click(function(){J.close()}),v.click(function(){_.get("overlayClose")&&J.close()}),t(e).bind("keydown."+Z,function(t){var e=t.keyCode;$&&_.get("escKey")&&27===e&&(t.preventDefault(),J.close()),$&&_.get("arrowKey")&&W[1]&&!t.altKey&&(37===e?(t.preventDefault(),P.click()):39===e&&(t.preventDefault(),K.click()))}),t.isFunction(t.fn.on)?t(e).on("click."+Z,"."+te,i):t("."+te).live("click."+Z,i)),!0):!1}function w(){var e,o,r,h=J.prep,d=++le;if(q=!0,U=!1,u(he),u(ie),_.get("onLoad"),_.h=_.get("height")?a(_.get("height"),"y")-N-j:_.get("innerHeight")&&a(_.get("innerHeight"),"y"),_.w=_.get("width")?a(_.get("width"),"x")-z-D:_.get("innerWidth")&&a(_.get("innerWidth"),"x"),_.mw=_.w,_.mh=_.h,_.get("maxWidth")&&(_.mw=a(_.get("maxWidth"),"x")-z-D,_.mw=_.w&&_.w<_.mw?_.w:_.mw),_.get("maxHeight")&&(_.mh=a(_.get("maxHeight"),"y")-N-j,_.mh=_.h&&_.h<_.mh?_.h:_.mh),e=_.get("href"),Q=setTimeout(function(){M.show()},100),_.get("inline")){var c=t(e);r=t("<div>").hide().insertBefore(c),ae.one(he,function(){r.replaceWith(c)}),h(c)}else _.get("iframe")?h(" "):_.get("html")?h(_.get("html")):s(_,e)?(e=l(_,e),U=_.get("createImg"),t(U).addClass(Z+"Photo").bind("error",function(){h(n(se,"Error").html(_.get("imgError")))}).one("load",function(){d===le&&setTimeout(function(){var t;_.get("retinaImage")&&i.devicePixelRatio>1&&(U.height=U.height/i.devicePixelRatio,U.width=U.width/i.devicePixelRatio),_.get("scalePhotos")&&(o=function(){U.height-=U.height*t,U.width-=U.width*t},_.mw&&U.width>_.mw&&(t=(U.width-_.mw)/U.width,o()),_.mh&&U.height>_.mh&&(t=(U.height-_.mh)/U.height,o())),_.h&&(U.style.marginTop=Math.max(_.mh-U.height,0)/2+"px"),W[1]&&(_.get("loop")||W[A+1])&&(U.style.cursor="pointer",U.onclick=function(){J.next()}),U.style.width=U.width+"px",U.style.height=U.height+"px",h(U)},1)}),U.src=e):e&&L.load(e,_.get("data"),function(e,i){d===le&&h("error"===i?n(se,"Error").html(_.get("xhrError")):t(this).contents())})}var v,y,x,b,T,C,H,k,W,E,I,L,M,S,F,R,K,P,B,O,_,j,D,N,z,A,U,$,q,G,Q,J,V,X={html:!1,photo:!1,iframe:!1,inline:!1,transition:"elastic",speed:300,fadeOut:300,width:!1,initialWidth:"600",innerWidth:!1,maxWidth:!1,height:!1,initialHeight:"450",innerHeight:!1,maxHeight:!1,scalePhotos:!0,scrolling:!0,opacity:.9,preloading:!0,className:!1,overlayClose:!0,escKey:!0,arrowKey:!0,top:!1,bottom:!1,left:!1,right:!1,fixed:!1,data:void 0,closeButton:!0,fastIframe:!0,open:!1,reposition:!0,loop:!0,slideshow:!1,slideshowAuto:!0,slideshowSpeed:2500,slideshowStart:"start slideshow",slideshowStop:"stop slideshow",photoRegex:/\.(gif|png|jp(e|g|eg)|bmp|ico|webp|jxr|svg)((#|\?).*)?$/i,retinaImage:!1,retinaUrl:!1,retinaSuffix:"@2x.$1",current:"image {current} of {total}",previous:"previous",next:"next",close:"close",xhrError:"This content failed to load.",imgError:"This image failed to load.",returnFocus:!0,trapFocus:!0,onOpen:!1,onLoad:!1,onComplete:!1,onCleanup:!1,onClosed:!1,rel:function(){return this.rel},href:function(){return t(this).attr("href")},title:function(){return this.title},createImg:function(){var e=new Image,i=t(this).data("cbox-img-attrs");return"object"==typeof i&&t.each(i,function(t,i){e[t]=i}),e},createIframe:function(){var i=e.createElement("iframe"),n=t(this).data("cbox-iframe-attrs");return"object"==typeof n&&t.each(n,function(t,e){i[t]=e}),"frameBorder"in i&&(i.frameBorder=0),"allowTransparency"in i&&(i.allowTransparency="true"),i.name=(new Date).getTime(),i.allowFullScreen=!0,i}},Y="colorbox",Z="cbox",te=Z+"Element",ee=Z+"_open",ie=Z+"_load",ne=Z+"_complete",oe=Z+"_cleanup",re=Z+"_closed",he=Z+"_purge",ae=t("<a/>"),se="div",le=0,de={},ce=function(){function t(){clearTimeout(h)}function e(){(_.get("loop")||W[A+1])&&(t(),h=setTimeout(J.next,_.get("slideshowSpeed")))}function i(){R.html(_.get("slideshowStop")).unbind(s).one(s,n),ae.bind(ne,e).bind(ie,t),y.removeClass(a+"off").addClass(a+"on")}function n(){t(),ae.unbind(ne,e).unbind(ie,t),R.html(_.get("slideshowStart")).unbind(s).one(s,function(){J.next(),i()}),y.removeClass(a+"on").addClass(a+"off")}function o(){r=!1,R.hide(),t(),ae.unbind(ne,e).unbind(ie,t),y.removeClass(a+"off "+a+"on")}var r,h,a=Z+"Slideshow_",s="click."+Z;return function(){r?_.get("slideshow")||(ae.unbind(oe,o),o()):_.get("slideshow")&&W[1]&&(r=!0,ae.one(oe,o),_.get("slideshowAuto")?i():n(),R.show())}}();t[Y]||(t(p),J=t.fn[Y]=t[Y]=function(e,i){var n,o=this;return e=e||{},t.isFunction(o)&&(o=t("<a/>"),e.open=!0),o[0]?(p(),m()&&(i&&(e.onComplete=i),o.each(function(){var i=t.data(this,Y)||{};t.data(this,Y,t.extend(i,e))}).addClass(te),n=new r(o[0],e),n.get("open")&&f(o[0])),o):o},J.position=function(e,i){function n(){T[0].style.width=k[0].style.width=b[0].style.width=parseInt(y[0].style.width,10)-D+"px",b[0].style.height=C[0].style.height=H[0].style.height=parseInt(y[0].style.height,10)-j+"px"}var r,h,s,l=0,d=0,c=y.offset();if(E.unbind("resize."+Z),y.css({top:-9e4,left:-9e4}),h=E.scrollTop(),s=E.scrollLeft(),_.get("fixed")?(c.top-=h,c.left-=s,y.css({position:"fixed"})):(l=h,d=s,y.css({position:"absolute"})),d+=_.get("right")!==!1?Math.max(E.width()-_.w-z-D-a(_.get("right"),"x"),0):_.get("left")!==!1?a(_.get("left"),"x"):Math.round(Math.max(E.width()-_.w-z-D,0)/2),l+=_.get("bottom")!==!1?Math.max(o()-_.h-N-j-a(_.get("bottom"),"y"),0):_.get("top")!==!1?a(_.get("top"),"y"):Math.round(Math.max(o()-_.h-N-j,0)/2),y.css({top:c.top,left:c.left,visibility:"visible"}),x[0].style.width=x[0].style.height="9999px",r={width:_.w+z+D,height:_.h+N+j,top:l,left:d},e){var g=0;t.each(r,function(t){return r[t]!==de[t]?(g=e,void 0):void 0}),e=g}de=r,e||y.css(r),y.dequeue().animate(r,{duration:e||0,complete:function(){n(),q=!1,x[0].style.width=_.w+z+D+"px",x[0].style.height=_.h+N+j+"px",_.get("reposition")&&setTimeout(function(){E.bind("resize."+Z,J.position)},1),t.isFunction(i)&&i()},step:n})},J.resize=function(t){var e;$&&(t=t||{},t.width&&(_.w=a(t.width,"x")-z-D),t.innerWidth&&(_.w=a(t.innerWidth,"x")),I.css({width:_.w}),t.height&&(_.h=a(t.height,"y")-N-j),t.innerHeight&&(_.h=a(t.innerHeight,"y")),t.innerHeight||t.height||(e=I.scrollTop(),I.css({height:"auto"}),_.h=I.height()),I.css({height:_.h}),e&&I.scrollTop(e),J.position("none"===_.get("transition")?0:_.get("speed")))},J.prep=function(i){function o(){return _.w=_.w||I.width(),_.w=_.mw&&_.mw<_.w?_.mw:_.w,_.w}function a(){return _.h=_.h||I.height(),_.h=_.mh&&_.mh<_.h?_.mh:_.h,_.h}if($){var d,g="none"===_.get("transition")?0:_.get("speed");I.remove(),I=n(se,"LoadedContent").append(i),I.hide().appendTo(L.show()).css({width:o(),overflow:_.get("scrolling")?"auto":"hidden"}).css({height:a()}).prependTo(b),L.hide(),t(U).css({"float":"none"}),c(_.get("className")),d=function(){function i(){t.support.opacity===!1&&y[0].style.removeAttribute("filter")}var n,o,a=W.length;$&&(o=function(){clearTimeout(Q),M.hide(),u(ne),_.get("onComplete")},S.html(_.get("title")).show(),I.show(),a>1?("string"==typeof _.get("current")&&F.html(_.get("current").replace("{current}",A+1).replace("{total}",a)).show(),K[_.get("loop")||a-1>A?"show":"hide"]().html(_.get("next")),P[_.get("loop")||A?"show":"hide"]().html(_.get("previous")),ce(),_.get("preloading")&&t.each([h(-1),h(1)],function(){var i,n=W[this],o=new r(n,t.data(n,Y)),h=o.get("href");h&&s(o,h)&&(h=l(o,h),i=e.createElement("img"),i.src=h)})):O.hide(),_.get("iframe")?(n=_.get("createIframe"),_.get("scrolling")||(n.scrolling="no"),t(n).attr({src:_.get("href"),"class":Z+"Iframe"}).one("load",o).appendTo(I),ae.one(he,function(){n.src="//about:blank"}),_.get("fastIframe")&&t(n).trigger("load")):o(),"fade"===_.get("transition")?y.fadeTo(g,1,i):i())},"fade"===_.get("transition")?y.fadeTo(g,0,function(){J.position(0,d)}):J.position(g,d)}},J.next=function(){!q&&W[1]&&(_.get("loop")||W[A+1])&&(A=h(1),f(W[A]))},J.prev=function(){!q&&W[1]&&(_.get("loop")||A)&&(A=h(-1),f(W[A]))},J.close=function(){$&&!G&&(G=!0,$=!1,u(oe),_.get("onCleanup"),E.unbind("."+Z),v.fadeTo(_.get("fadeOut")||0,0),y.stop().fadeTo(_.get("fadeOut")||0,0,function(){y.hide(),v.hide(),u(he),I.remove(),setTimeout(function(){G=!1,u(re),_.get("onClosed")},1)}))},J.remove=function(){y&&(y.stop(),t[Y].close(),y.stop(!1,!0).remove(),v.remove(),G=!1,y=null,t("."+te).removeData(Y).removeClass(te),t(e).unbind("click."+Z).unbind("keydown."+Z))},J.element=function(){return t(_.el)},J.settings=X)})(jQuery,document,window);



/**
 * Sweet Alert
 * https://github.com/t4t5/sweetalert
 */
!function(e,t,n){"use strict";!function o(e,t,n){function a(s,l){if(!t[s]){if(!e[s]){var i="function"==typeof require&&require;if(!l&&i)return i(s,!0);if(r)return r(s,!0);var u=new Error("Cannot find module '"+s+"'");throw u.code="MODULE_NOT_FOUND",u}var c=t[s]={exports:{}};e[s][0].call(c.exports,function(t){var n=e[s][1][t];return a(n?n:t)},c,c.exports,o,e,t,n)}return t[s].exports}for(var r="function"==typeof require&&require,s=0;s<n.length;s++)a(n[s]);return a}({1:[function(o,a,r){var s=function(e){return e&&e.__esModule?e:{"default":e}};Object.defineProperty(r,"__esModule",{value:!0});var l,i,u,c,d=o("./modules/handle-dom"),f=o("./modules/utils"),p=o("./modules/handle-swal-dom"),m=o("./modules/handle-click"),v=o("./modules/handle-key"),y=s(v),h=o("./modules/default-params"),b=s(h),g=o("./modules/set-params"),w=s(g);r["default"]=u=c=function(){function o(e){var t=a;return t[e]===n?b["default"][e]:t[e]}var a=arguments[0];if(d.addClass(t.body,"stop-scrolling"),p.resetInput(),a===n)return f.logStr("SweetAlert expects at least 1 attribute!"),!1;var r=f.extend({},b["default"]);switch(typeof a){case"string":r.title=a,r.text=arguments[1]||"",r.type=arguments[2]||"";break;case"object":if(a.title===n)return f.logStr('Missing "title" argument!'),!1;r.title=a.title;for(var s in b["default"])r[s]=o(s);r.confirmButtonText=r.showCancelButton?"Confirm":b["default"].confirmButtonText,r.confirmButtonText=o("confirmButtonText"),r.doneFunction=arguments[1]||null;break;default:return f.logStr('Unexpected type of argument! Expected "string" or "object", got '+typeof a),!1}w["default"](r),p.fixVerticalPosition(),p.openModal(arguments[1]);for(var u=p.getModal(),v=u.querySelectorAll("button"),h=["onclick","onmouseover","onmouseout","onmousedown","onmouseup","onfocus"],g=function(e){return m.handleButton(e,r,u)},C=0;C<v.length;C++)for(var S=0;S<h.length;S++){var x=h[S];v[C][x]=g}p.getOverlay().onclick=g,l=e.onkeydown;var k=function(e){return y["default"](e,r,u)};e.onkeydown=k,e.onfocus=function(){setTimeout(function(){i!==n&&(i.focus(),i=n)},0)},c.enableButtons()},u.setDefaults=c.setDefaults=function(e){if(!e)throw new Error("userParams is required");if("object"!=typeof e)throw new Error("userParams has to be a object");f.extend(b["default"],e)},u.close=c.close=function(){var o=p.getModal();d.fadeOut(p.getOverlay(),5),d.fadeOut(o,5),d.removeClass(o,"showSweetAlert"),d.addClass(o,"hideSweetAlert"),d.removeClass(o,"visible");var a=o.querySelector(".sa-icon.sa-success");d.removeClass(a,"animate"),d.removeClass(a.querySelector(".sa-tip"),"animateSuccessTip"),d.removeClass(a.querySelector(".sa-long"),"animateSuccessLong");var r=o.querySelector(".sa-icon.sa-error");d.removeClass(r,"animateErrorIcon"),d.removeClass(r.querySelector(".sa-x-mark"),"animateXMark");var s=o.querySelector(".sa-icon.sa-warning");return d.removeClass(s,"pulseWarning"),d.removeClass(s.querySelector(".sa-body"),"pulseWarningIns"),d.removeClass(s.querySelector(".sa-dot"),"pulseWarningIns"),setTimeout(function(){var e=o.getAttribute("data-custom-class");d.removeClass(o,e)},300),d.removeClass(t.body,"stop-scrolling"),e.onkeydown=l,e.previousActiveElement&&e.previousActiveElement.focus(),i=n,clearTimeout(o.timeout),!0},u.showInputError=c.showInputError=function(e){var t=p.getModal(),n=t.querySelector(".sa-input-error");d.addClass(n,"show");var o=t.querySelector(".sa-error-container");d.addClass(o,"show"),o.querySelector("p").innerHTML=e,setTimeout(function(){u.enableButtons()},1),t.querySelector("input").focus()},u.resetInputError=c.resetInputError=function(e){if(e&&13===e.keyCode)return!1;var t=p.getModal(),n=t.querySelector(".sa-input-error");d.removeClass(n,"show");var o=t.querySelector(".sa-error-container");d.removeClass(o,"show")},u.disableButtons=c.disableButtons=function(){var e=p.getModal(),t=e.querySelector("button.confirm"),n=e.querySelector("button.cancel");t.disabled=!0,n.disabled=!0},u.enableButtons=c.enableButtons=function(){var e=p.getModal(),t=e.querySelector("button.confirm"),n=e.querySelector("button.cancel");t.disabled=!1,n.disabled=!1},"undefined"!=typeof e?e.sweetAlert=e.swal=u:f.logStr("SweetAlert is a frontend module!"),a.exports=r["default"]},{"./modules/default-params":2,"./modules/handle-click":3,"./modules/handle-dom":4,"./modules/handle-key":5,"./modules/handle-swal-dom":6,"./modules/set-params":8,"./modules/utils":9}],2:[function(e,t,n){Object.defineProperty(n,"__esModule",{value:!0});var o={title:"",text:"",type:null,allowOutsideClick:!1,showConfirmButton:!0,showCancelButton:!1,closeOnConfirm:!0,closeOnCancel:!0,confirmButtonText:"OK",confirmButtonColor:"#8CD4F5",cancelButtonText:"Cancel",imageUrl:null,imageSize:null,timer:null,customClass:"",html:!1,animation:!0,allowEscapeKey:!0,inputType:"text",inputPlaceholder:"",inputValue:"",showLoaderOnConfirm:!1};n["default"]=o,t.exports=n["default"]},{}],3:[function(t,n,o){Object.defineProperty(o,"__esModule",{value:!0});var a=t("./utils"),r=(t("./handle-swal-dom"),t("./handle-dom")),s=function(t,n,o){function s(e){m&&n.confirmButtonColor&&(p.style.backgroundColor=e)}var u,c,d,f=t||e.event,p=f.target||f.srcElement,m=-1!==p.className.indexOf("confirm"),v=-1!==p.className.indexOf("sweet-overlay"),y=r.hasClass(o,"visible"),h=n.doneFunction&&"true"===o.getAttribute("data-has-done-function");switch(m&&n.confirmButtonColor&&(u=n.confirmButtonColor,c=a.colorLuminance(u,-.04),d=a.colorLuminance(u,-.14)),f.type){case"mouseover":s(c);break;case"mouseout":s(u);break;case"mousedown":s(d);break;case"mouseup":s(c);break;case"focus":var b=o.querySelector("button.confirm"),g=o.querySelector("button.cancel");m?g.style.boxShadow="none":b.style.boxShadow="none";break;case"click":var w=o===p,C=r.isDescendant(o,p);if(!w&&!C&&y&&!n.allowOutsideClick)break;m&&h&&y?l(o,n):h&&y||v?i(o,n):r.isDescendant(o,p)&&"BUTTON"===p.tagName&&sweetAlert.close()}},l=function(e,t){var n=!0;r.hasClass(e,"show-input")&&(n=e.querySelector("input").value,n||(n="")),t.doneFunction(n),t.closeOnConfirm&&sweetAlert.close(),t.showLoaderOnConfirm&&sweetAlert.disableButtons()},i=function(e,t){var n=String(t.doneFunction).replace(/\s/g,""),o="function("===n.substring(0,9)&&")"!==n.substring(9,10);o&&t.doneFunction(!1),t.closeOnCancel&&sweetAlert.close()};o["default"]={handleButton:s,handleConfirm:l,handleCancel:i},n.exports=o["default"]},{"./handle-dom":4,"./handle-swal-dom":6,"./utils":9}],4:[function(n,o,a){Object.defineProperty(a,"__esModule",{value:!0});var r=function(e,t){return new RegExp(" "+t+" ").test(" "+e.className+" ")},s=function(e,t){r(e,t)||(e.className+=" "+t)},l=function(e,t){var n=" "+e.className.replace(/[\t\r\n]/g," ")+" ";if(r(e,t)){for(;n.indexOf(" "+t+" ")>=0;)n=n.replace(" "+t+" "," ");e.className=n.replace(/^\s+|\s+$/g,"")}},i=function(e){var n=t.createElement("div");return n.appendChild(t.createTextNode(e)),n.innerHTML},u=function(e){e.style.opacity="",e.style.display="block"},c=function(e){if(e&&!e.length)return u(e);for(var t=0;t<e.length;++t)u(e[t])},d=function(e){e.style.opacity="",e.style.display="none"},f=function(e){if(e&&!e.length)return d(e);for(var t=0;t<e.length;++t)d(e[t])},p=function(e,t){for(var n=t.parentNode;null!==n;){if(n===e)return!0;n=n.parentNode}return!1},m=function(e){e.style.left="-9999px",e.style.display="block";var t,n=e.clientHeight;return t="undefined"!=typeof getComputedStyle?parseInt(getComputedStyle(e).getPropertyValue("padding-top"),10):parseInt(e.currentStyle.padding),e.style.left="",e.style.display="none","-"+parseInt((n+t)/2)+"px"},v=function(e,t){if(+e.style.opacity<1){t=t||16,e.style.opacity=0,e.style.display="block";var n=+new Date,o=function(e){function t(){return e.apply(this,arguments)}return t.toString=function(){return e.toString()},t}(function(){e.style.opacity=+e.style.opacity+(new Date-n)/100,n=+new Date,+e.style.opacity<1&&setTimeout(o,t)});o()}e.style.display="block"},y=function(e,t){t=t||16,e.style.opacity=1;var n=+new Date,o=function(e){function t(){return e.apply(this,arguments)}return t.toString=function(){return e.toString()},t}(function(){e.style.opacity=+e.style.opacity-(new Date-n)/100,n=+new Date,+e.style.opacity>0?setTimeout(o,t):e.style.display="none"});o()},h=function(n){if("function"==typeof MouseEvent){var o=new MouseEvent("click",{view:e,bubbles:!1,cancelable:!0});n.dispatchEvent(o)}else if(t.createEvent){var a=t.createEvent("MouseEvents");a.initEvent("click",!1,!1),n.dispatchEvent(a)}else t.createEventObject?n.fireEvent("onclick"):"function"==typeof n.onclick&&n.onclick()},b=function(t){"function"==typeof t.stopPropagation?(t.stopPropagation(),t.preventDefault()):e.event&&e.event.hasOwnProperty("cancelBubble")&&(e.event.cancelBubble=!0)};a.hasClass=r,a.addClass=s,a.removeClass=l,a.escapeHtml=i,a._show=u,a.show=c,a._hide=d,a.hide=f,a.isDescendant=p,a.getTopMargin=m,a.fadeIn=v,a.fadeOut=y,a.fireClick=h,a.stopEventPropagation=b},{}],5:[function(t,o,a){Object.defineProperty(a,"__esModule",{value:!0});var r=t("./handle-dom"),s=t("./handle-swal-dom"),l=function(t,o,a){var l=t||e.event,i=l.keyCode||l.which,u=a.querySelector("button.confirm"),c=a.querySelector("button.cancel"),d=a.querySelectorAll("button[tabindex]");if(-1!==[9,13,32,27].indexOf(i)){for(var f=l.target||l.srcElement,p=-1,m=0;m<d.length;m++)if(f===d[m]){p=m;break}9===i?(f=-1===p?u:p===d.length-1?d[0]:d[p+1],r.stopEventPropagation(l),f.focus(),o.confirmButtonColor&&s.setFocusStyle(f,o.confirmButtonColor)):13===i?("INPUT"===f.tagName&&(f=u,u.focus()),f=-1===p?u:n):27===i&&o.allowEscapeKey===!0?(f=c,r.fireClick(f,l)):f=n}};a["default"]=l,o.exports=a["default"]},{"./handle-dom":4,"./handle-swal-dom":6}],6:[function(n,o,a){var r=function(e){return e&&e.__esModule?e:{"default":e}};Object.defineProperty(a,"__esModule",{value:!0});var s=n("./utils"),l=n("./handle-dom"),i=n("./default-params"),u=r(i),c=n("./injected-html"),d=r(c),f=".sweet-alert",p=".sweet-overlay",m=function(){var e=t.createElement("div");for(e.innerHTML=d["default"];e.firstChild;)t.body.appendChild(e.firstChild)},v=function(e){function t(){return e.apply(this,arguments)}return t.toString=function(){return e.toString()},t}(function(){var e=t.querySelector(f);return e||(m(),e=v()),e}),y=function(){var e=v();return e?e.querySelector("input"):void 0},h=function(){return t.querySelector(p)},b=function(e,t){var n=s.hexToRgb(t);e.style.boxShadow="0 0 2px rgba("+n+", 0.8), inset 0 0 0 1px rgba(0, 0, 0, 0.05)"},g=function(n){var o=v();l.fadeIn(h(),10),l.show(o),l.addClass(o,"showSweetAlert"),l.removeClass(o,"hideSweetAlert"),e.previousActiveElement=t.activeElement;var a=o.querySelector("button.confirm");a.focus(),setTimeout(function(){l.addClass(o,"visible")},500);var r=o.getAttribute("data-timer");if("null"!==r&&""!==r){var s=n;o.timeout=setTimeout(function(){var e=(s||null)&&"true"===o.getAttribute("data-has-done-function");e?s(null):sweetAlert.close()},r)}},w=function(){var e=v(),t=y();l.removeClass(e,"show-input"),t.value=u["default"].inputValue,t.setAttribute("type",u["default"].inputType),t.setAttribute("placeholder",u["default"].inputPlaceholder),C()},C=function(e){if(e&&13===e.keyCode)return!1;var t=v(),n=t.querySelector(".sa-input-error");l.removeClass(n,"show");var o=t.querySelector(".sa-error-container");l.removeClass(o,"show")},S=function(){var e=v();e.style.marginTop=l.getTopMargin(v())};a.sweetAlertInitialize=m,a.getModal=v,a.getOverlay=h,a.getInput=y,a.setFocusStyle=b,a.openModal=g,a.resetInput=w,a.resetInputError=C,a.fixVerticalPosition=S},{"./default-params":2,"./handle-dom":4,"./injected-html":7,"./utils":9}],7:[function(e,t,n){Object.defineProperty(n,"__esModule",{value:!0});var o='<div class="sweet-overlay" tabIndex="-1"></div><div class="sweet-alert"><div class="sa-icon sa-error">\n      <span class="sa-x-mark">\n        <span class="sa-line sa-left"></span>\n        <span class="sa-line sa-right"></span>\n      </span>\n    </div><div class="sa-icon sa-warning">\n      <span class="sa-body"></span>\n      <span class="sa-dot"></span>\n    </div><div class="sa-icon sa-info"></div><div class="sa-icon sa-success">\n      <span class="sa-line sa-tip"></span>\n      <span class="sa-line sa-long"></span>\n\n      <div class="sa-placeholder"></div>\n      <div class="sa-fix"></div>\n    </div><div class="sa-icon sa-custom"></div><h2>Title</h2>\n    <p>Text</p>\n    <fieldset>\n      <input type="text" tabIndex="3" />\n      <div class="sa-input-error"></div>\n    </fieldset><div class="sa-error-container">\n      <div class="icon">!</div>\n      <p>Not valid!</p>\n    </div><div class="sa-button-container">\n      <button class="cancel" tabIndex="2">Cancel</button>\n      <div class="sa-confirm-button-container">\n        <button class="confirm" tabIndex="1">OK</button><div class="la-ball-fall">\n          <div></div>\n          <div></div>\n          <div></div>\n        </div>\n      </div>\n    </div></div>';n["default"]=o,t.exports=n["default"]},{}],8:[function(e,t,o){Object.defineProperty(o,"__esModule",{value:!0});var a=e("./utils"),r=e("./handle-swal-dom"),s=e("./handle-dom"),l=["error","warning","info","success","input","prompt"],i=function(e){var t=r.getModal(),o=t.querySelector("h2"),i=t.querySelector("p"),u=t.querySelector("button.cancel"),c=t.querySelector("button.confirm");if(o.innerHTML=e.html?e.title:s.escapeHtml(e.title).split("\n").join("<br>"),i.innerHTML=e.html?e.text:s.escapeHtml(e.text||"").split("\n").join("<br>"),e.text&&s.show(i),e.customClass)s.addClass(t,e.customClass),t.setAttribute("data-custom-class",e.customClass);else{var d=t.getAttribute("data-custom-class");s.removeClass(t,d),t.setAttribute("data-custom-class","")}if(s.hide(t.querySelectorAll(".sa-icon")),e.type&&!a.isIE8()){var f=function(){for(var o=!1,a=0;a<l.length;a++)if(e.type===l[a]){o=!0;break}if(!o)return logStr("Unknown alert type: "+e.type),{v:!1};var i=["success","error","warning","info"],u=n;-1!==i.indexOf(e.type)&&(u=t.querySelector(".sa-icon.sa-"+e.type),s.show(u));var c=r.getInput();switch(e.type){case"success":s.addClass(u,"animate"),s.addClass(u.querySelector(".sa-tip"),"animateSuccessTip"),s.addClass(u.querySelector(".sa-long"),"animateSuccessLong");break;case"error":s.addClass(u,"animateErrorIcon"),s.addClass(u.querySelector(".sa-x-mark"),"animateXMark");break;case"warning":s.addClass(u,"pulseWarning"),s.addClass(u.querySelector(".sa-body"),"pulseWarningIns"),s.addClass(u.querySelector(".sa-dot"),"pulseWarningIns");break;case"input":case"prompt":c.setAttribute("type",e.inputType),c.value=e.inputValue,c.setAttribute("placeholder",e.inputPlaceholder),s.addClass(t,"show-input"),setTimeout(function(){c.focus(),c.addEventListener("keyup",swal.resetInputError)},400)}}();if("object"==typeof f)return f.v}if(e.imageUrl){var p=t.querySelector(".sa-icon.sa-custom");p.style.backgroundImage="url("+e.imageUrl+")",s.show(p);var m=80,v=80;if(e.imageSize){var y=e.imageSize.toString().split("x"),h=y[0],b=y[1];h&&b?(m=h,v=b):logStr("Parameter imageSize expects value with format WIDTHxHEIGHT, got "+e.imageSize)}p.setAttribute("style",p.getAttribute("style")+"width:"+m+"px; height:"+v+"px")}t.setAttribute("data-has-cancel-button",e.showCancelButton),e.showCancelButton?u.style.display="inline-block":s.hide(u),t.setAttribute("data-has-confirm-button",e.showConfirmButton),e.showConfirmButton?c.style.display="inline-block":s.hide(c),e.cancelButtonText&&(u.innerHTML=s.escapeHtml(e.cancelButtonText)),e.confirmButtonText&&(c.innerHTML=s.escapeHtml(e.confirmButtonText)),e.confirmButtonColor&&(c.style.backgroundColor=e.confirmButtonColor,c.style.borderLeftColor=e.confirmLoadingButtonColor,c.style.borderRightColor=e.confirmLoadingButtonColor,r.setFocusStyle(c,e.confirmButtonColor)),t.setAttribute("data-allow-outside-click",e.allowOutsideClick);var g=e.doneFunction?!0:!1;t.setAttribute("data-has-done-function",g),e.animation?"string"==typeof e.animation?t.setAttribute("data-animation",e.animation):t.setAttribute("data-animation","pop"):t.setAttribute("data-animation","none"),t.setAttribute("data-timer",e.timer)};o["default"]=i,t.exports=o["default"]},{"./handle-dom":4,"./handle-swal-dom":6,"./utils":9}],9:[function(t,n,o){Object.defineProperty(o,"__esModule",{value:!0});var a=function(e,t){for(var n in t)t.hasOwnProperty(n)&&(e[n]=t[n]);return e},r=function(e){var t=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(e);return t?parseInt(t[1],16)+", "+parseInt(t[2],16)+", "+parseInt(t[3],16):null},s=function(){return e.attachEvent&&!e.addEventListener},l=function(t){e.console&&e.console.log("SweetAlert: "+t)},i=function(e,t){e=String(e).replace(/[^0-9a-f]/gi,""),e.length<6&&(e=e[0]+e[0]+e[1]+e[1]+e[2]+e[2]),t=t||0;var n,o,a="#";for(o=0;3>o;o++)n=parseInt(e.substr(2*o,2),16),n=Math.round(Math.min(Math.max(0,n+n*t),255)).toString(16),a+=("00"+n).substr(n.length);return a};o.extend=a,o.hexToRgb=r,o.isIE8=s,o.logStr=l,o.colorLuminance=i},{}]},{},[1]),"function"==typeof define&&define.amd?define(function(){return sweetAlert}):"undefined"!=typeof module&&module.exports&&(module.exports=sweetAlert)}(window,document);