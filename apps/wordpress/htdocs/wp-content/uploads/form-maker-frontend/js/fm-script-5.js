    var fm_currentDate = new Date();
    var FormCurrency_5 = '$';
    var FormPaypalTax_5 = '0';
    var check_submit5 = 0;
    var check_before_submit5 = {};
    var required_fields5 = ["2","3","4"];
    var labels_and_ids5 = {"2":"type_name","3":"type_submitter_mail","4":"type_date_new","5":"type_radio","6":"type_spinner","7":"type_textarea","1":"type_submit_reset"};
    var check_regExp_all5 = [];
    var check_paypal_price_min_max5 = [];
    var file_upload_check5 = [];
    var spinner_check5 = {"6":["",""]};
    var scrollbox_trigger_point5 = '20';
    var header_image_animation5 = 'none';
    var scrollbox_loading_delay5 = '0';
    var scrollbox_auto_hide5 = '1';
    var inputIds5 = '[]';
	  var form_view_count5 = 0;
     function before_load5() {	
}	
 function before_submit5() {
	 }	
 function before_reset5() {	
} function after_submit5() {
  
}
    function onload_js5() {
  jQuery("#button_calendar_4, #fm-calendar-4").click(function() {
    jQuery("#wdform_4_element5").datepicker("show");
  });
  jQuery("#wdform_4_element5").datepicker({
    dateFormat: format_date,
    minDate: "",
    maxDate: "",
    changeMonth: true,
    changeYear: true,
    yearRange: "-100:+50",
    showOtherMonths: true,
    selectOtherMonths: true,
    firstDay: "0",
    beforeShow: function(input, inst) {
      jQuery("#ui-datepicker-div").addClass("fm_datepicker");
    },
    beforeShowDay: function(date) {
      var invalid_dates = "";
      var invalid_dates_finish = [];
      var invalid_dates_start = invalid_dates.split(",");
      var invalid_date_range =[];
      for(var i = 0; i < invalid_dates_start.length; i++ ) {
        invalid_dates_start[i] = invalid_dates_start[i].trim();
        if(invalid_dates_start[i].length < 11 || invalid_dates_start[i].indexOf("-") == -1){
          invalid_dates_finish.push(invalid_dates_start[i]);
        }
        else{
          if(invalid_dates_start[i].indexOf("-") > 4) {
            invalid_date_range.push(invalid_dates_start[i].split("-"));
          }
          else {
            var invalid_date_array = invalid_dates_start[i].split("-");
            var start_invalid_day = invalid_date_array[0] + "-" + invalid_date_array[1] + "-" + invalid_date_array[2];
            var end_invalid_day = invalid_date_array[3] + "-" + invalid_date_array[4] + "-" + invalid_date_array[5];
            invalid_date_range.push([start_invalid_day, end_invalid_day]);
          }
        }
      }
      jQuery.each(invalid_date_range, function( index, value ) {
        for(var d = new Date(value[0]); d <= new Date(value[1]); d.setDate(d.getDate() + 1)) {
          invalid_dates_finish.push(jQuery.datepicker.formatDate(format_date, d));
        }
      });
      var string_days = jQuery.datepicker.formatDate(format_date, date);
      var day = date.getDay();
      return [ invalid_dates_finish.indexOf(string_days) == -1 ];
    }
  });
  var default_date;
  var date_value = jQuery("#wdform_4_element5").val();
  (date_value != "") ? default_date = date_value : default_date = "";
  var format_date = "mm/dd/yy";
  jQuery("#wdform_4_element5").datepicker("option", "dateFormat", format_date);
  if(default_date == "today") {
    jQuery("#wdform_4_element5").datepicker("setDate", new Date());
  }
  else if (default_date.indexOf("d") == -1 && default_date.indexOf("m") == -1 && default_date.indexOf("y") == -1 && default_date.indexOf("w") == -1) {
    jQuery("#wdform_4_element5").datepicker("setDate", default_date);
  }
  else {
    jQuery("#wdform_4_element5").datepicker("setDate", default_date);
  }
  jQuery("#form5 #wdform_6_element5")[0].spin = null;
  spinner = jQuery("#form5 #wdform_6_element5").spinner();
  if ("null" == "null" && jQuery("#form5 #wdform_6_element5").val() == "") { spinner.spinner("value", ""); }
  jQuery("#form5 #wdform_6_element5").spinner({ min: ""});
  jQuery("#form5 #wdform_6_element5").spinner({ max: ""});
  jQuery("#form5 #wdform_6_element5").spinner({ step: "1"});    }

    function condition_js5() {    }

    function check_js5(id, form_id) {
		if (id != 0) {
			x = jQuery("#" + form_id + "form_view"+id);
		}
		else {
		x = jQuery("#form"+form_id);
		}
		    }

    function onsubmit_js5() {
		
  jQuery("<input type=\"hidden\" name=\"wdform_5_allow_other5\" value=\"no\" />").appendTo("#form5");
  jQuery("<input type=\"hidden\" name=\"wdform_5_allow_other_num5\" value=\"0\" />").appendTo("#form5");
    var disabled_fields = "";
    jQuery("#form5 div[wdid]").each(function() {
      if(jQuery(this).css("display") == "none") {
        disabled_fields += jQuery(this).attr("wdid");
        disabled_fields += ",";
      }
    })
    if(disabled_fields) {
      jQuery("<input type=\"hidden\" name=\"disabled_fields5\" value =\""+disabled_fields+"\" />").appendTo("#form5");
    };    }

	function unset_fields5( values, id, i ) {
		rid = 0;
		if ( i > 0 ) {
			jQuery.each( values, function( k, v ) {
				if ( id == k.split('|')[2] ) {
					rid = k.split('|')[0];
					values[k] = '';
				}
			});
			return unset_fields5(values, rid, i - 1);
		} else {
			return values;
		}
	}
	function ajax_similarity5( obj, changing_field_id ) {
		jQuery.ajax({
			type: "POST",
			url: fm_objectL10n.form_maker_admin_ajax,
			dataType: "json",
			data: {
				nonce: fm_ajax.ajaxnonce,
				action: 'fm_reload_input',
				page: 'form_maker',
				form_id: 5,
				inputs: obj.inputs
			},
			beforeSend: function() {
				if ( !jQuery.isEmptyObject(obj.inputs) ) {
					jQuery.each( obj.inputs, function( key, val ) {
						wdid = key.split('|')[0];
						if ( val != '' && parseInt(wdid) == parseInt(changing_field_id) ) {
							jQuery("#form5 div[wdid='"+ wdid +"']").append( '<div class="fm-loading"></div>' );
						}
					});
				}
			},
			success: function (res) {
				if ( !jQuery.isEmptyObject(obj.inputs) ) {
					jQuery.each( obj.inputs, function( key, val ) {
						wdid = key.split('|')[0];
						jQuery("#form5 div[wdid='"+ wdid +"'] .fm-loading").remove();
						if ( !jQuery.isEmptyObject(res[wdid]) && ( !val || parseInt(wdid) == parseInt(changing_field_id) ) ) {
							jQuery("#form5 div[wdid='"+ wdid +"']").html( res[wdid].html );
						}
					});
				}
			},
			complete: function() {
			}
		});
	}

    jQuery(document).ready(function () {
		if (jQuery('#form5 .wdform_section').length > 0) {
			fm_document_ready(5);
		}
		else {
			jQuery("#form5").closest(".fm-form-container").removeAttr("style")
		}
		if (jQuery('#form5 .wdform_section').length > 0) {
			formOnload(5);
		}

		var ajaxObj5 = {};
		var value_ids5 = {};

		jQuery.each( jQuery.parseJSON( inputIds5 ), function( key, values ) {
			jQuery.each( values, function( index, input_id ) {
				tagName =  jQuery('#form5 [id^="wdform_'+ input_id +'_elemen"]').prop("tagName");
				type =  jQuery('#form5 [id^="wdform_'+ input_id +'_elemen"]').prop("type");
				if ( tagName == 'INPUT' ) {
					input_value = jQuery('#form5 [id^="wdform_'+ input_id +'_elemen"]').val();
					if ( jQuery('#form5 [id^="wdform_'+ input_id +'_elemen"]').is(':checked') ) { 
						if ( input_value ) {
							value_ids5[key + '|' + input_id] = input_value;
						}
					}
					else if ( type == 'text' ) {
						if ( input_value ) {
							value_ids5[key + '|' + input_id] = input_value;
						}
					}
				}
				else if ( tagName == 'SELECT' ) {
					select_value = jQuery('#form5 [id^="wdform_'+ input_id +'_elemen"] option:selected').val();
					if ( select_value ) {
						value_ids5[key + '|' + input_id] = select_value;
					}
				}
				ajaxObj5.inputs = value_ids5;

				jQuery(document).on('change', '#form5 [id^="wdform_'+ input_id +'_elemen"]', function() {
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
					value_ids5[key + '|' + input_id] = id;

					jQuery.each( value_ids5, function( k, v ) {
						key_arr = k.split('|');
						if ( input_id == key_arr[2] ) {
							changing_field_id = key_arr[0];
							count = Object.keys(value_ids5).length;
							value_ids5 = unset_fields5( value_ids5, changing_field_id, count );
						}
					});

					ajaxObj5.inputs = value_ids5;
					ajax_similarity5( ajaxObj5, changing_field_id );
				});
			});
		});
		ajax_similarity5( ajaxObj5, null );
    });
    