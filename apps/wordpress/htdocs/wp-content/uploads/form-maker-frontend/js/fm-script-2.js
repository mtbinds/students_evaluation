    var fm_currentDate = new Date();
    var FormCurrency_2 = '$';
    var FormPaypalTax_2 = '0';
    var check_submit2 = 0;
    var check_before_submit2 = {};
    var required_fields2 = ["4"];
    var labels_and_ids2 = {"2":"type_text","3":"type_text","4":"type_submitter_mail","5":"type_text","6":"type_text","7":"type_address","1":"type_submit_reset"};
    var check_regExp_all2 = [];
    var check_paypal_price_min_max2 = [];
    var file_upload_check2 = [];
    var spinner_check2 = [];
    var scrollbox_trigger_point2 = '20';
    var header_image_animation2 = 'none';
    var scrollbox_loading_delay2 = '0';
    var scrollbox_auto_hide2 = '1';
    var inputIds2 = '[]';
	  var form_view_count2 = 0;
     function before_load2() {	
}	
 function before_submit2() {
	 }	
 function before_reset2() {	
} function after_submit2() {
  
}
    function onload_js2() {    }

    function condition_js2() {    }

    function check_js2(id, form_id) {
		if (id != 0) {
			x = jQuery("#" + form_id + "form_view"+id);
		}
		else {
		x = jQuery("#form"+form_id);
		}
		    }

    function onsubmit_js2() {
		
    var disabled_fields = "";
    jQuery("#form2 div[wdid]").each(function() {
      if(jQuery(this).css("display") == "none") {
        disabled_fields += jQuery(this).attr("wdid");
        disabled_fields += ",";
      }
    })
    if(disabled_fields) {
      jQuery("<input type=\"hidden\" name=\"disabled_fields2\" value =\""+disabled_fields+"\" />").appendTo("#form2");
    };    }

	function unset_fields2( values, id, i ) {
		rid = 0;
		if ( i > 0 ) {
			jQuery.each( values, function( k, v ) {
				if ( id == k.split('|')[2] ) {
					rid = k.split('|')[0];
					values[k] = '';
				}
			});
			return unset_fields2(values, rid, i - 1);
		} else {
			return values;
		}
	}
	function ajax_similarity2( obj, changing_field_id ) {
		jQuery.ajax({
			type: "POST",
			url: fm_objectL10n.form_maker_admin_ajax,
			dataType: "json",
			data: {
				nonce: fm_ajax.ajaxnonce,
				action: 'fm_reload_input',
				page: 'form_maker',
				form_id: 2,
				inputs: obj.inputs
			},
			beforeSend: function() {
				if ( !jQuery.isEmptyObject(obj.inputs) ) {
					jQuery.each( obj.inputs, function( key, val ) {
						wdid = key.split('|')[0];
						if ( val != '' && parseInt(wdid) == parseInt(changing_field_id) ) {
							jQuery("#form2 div[wdid='"+ wdid +"']").append( '<div class="fm-loading"></div>' );
						}
					});
				}
			},
			success: function (res) {
				if ( !jQuery.isEmptyObject(obj.inputs) ) {
					jQuery.each( obj.inputs, function( key, val ) {
						wdid = key.split('|')[0];
						jQuery("#form2 div[wdid='"+ wdid +"'] .fm-loading").remove();
						if ( !jQuery.isEmptyObject(res[wdid]) && ( !val || parseInt(wdid) == parseInt(changing_field_id) ) ) {
							jQuery("#form2 div[wdid='"+ wdid +"']").html( res[wdid].html );
						}
					});
				}
			},
			complete: function() {
			}
		});
	}

    jQuery(document).ready(function () {
		if (jQuery('#form2 .wdform_section').length > 0) {
			fm_document_ready(2);
		}
		else {
			jQuery("#form2").closest(".fm-form-container").removeAttr("style")
		}
		if (jQuery('#form2 .wdform_section').length > 0) {
			formOnload(2);
		}

		var ajaxObj2 = {};
		var value_ids2 = {};

		jQuery.each( jQuery.parseJSON( inputIds2 ), function( key, values ) {
			jQuery.each( values, function( index, input_id ) {
				tagName =  jQuery('#form2 [id^="wdform_'+ input_id +'_elemen"]').prop("tagName");
				type =  jQuery('#form2 [id^="wdform_'+ input_id +'_elemen"]').prop("type");
				if ( tagName == 'INPUT' ) {
					input_value = jQuery('#form2 [id^="wdform_'+ input_id +'_elemen"]').val();
					if ( jQuery('#form2 [id^="wdform_'+ input_id +'_elemen"]').is(':checked') ) { 
						if ( input_value ) {
							value_ids2[key + '|' + input_id] = input_value;
						}
					}
					else if ( type == 'text' ) {
						if ( input_value ) {
							value_ids2[key + '|' + input_id] = input_value;
						}
					}
				}
				else if ( tagName == 'SELECT' ) {
					select_value = jQuery('#form2 [id^="wdform_'+ input_id +'_elemen"] option:selected').val();
					if ( select_value ) {
						value_ids2[key + '|' + input_id] = select_value;
					}
				}
				ajaxObj2.inputs = value_ids2;

				jQuery(document).on('change', '#form2 [id^="wdform_'+ input_id +'_elemen"]', function() {
					var id = '';
					var changing_field_id = '';
					if( jQuery(this).prop("tagName") == 'INPUT' ) {
						if( jQuery(this).is(':checked') ) {
							id = jQuery(this).val();
						}
						if( jQuery(this).attr('type') == 'text' ) {
							id = jQuery(this).val();
						}
					}
					else {
						id = jQuery(this).val();
					}
					value_ids2[key + '|' + input_id] = id;

					jQuery.each( value_ids2, function( k, v ) {
						key_arr = k.split('|');
						if ( input_id == key_arr[2] ) {
							changing_field_id = key_arr[0];
							count = Object.keys(value_ids2).length;
							value_ids2 = unset_fields2( value_ids2, changing_field_id, count );
						}
					});

					ajaxObj2.inputs = value_ids2;
					ajax_similarity2( ajaxObj2, changing_field_id );
				});
			});
		});
		ajax_similarity2( ajaxObj2, null );
    });
    