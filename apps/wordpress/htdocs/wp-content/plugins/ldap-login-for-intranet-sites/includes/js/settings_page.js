jQuery(document).ready(function () {
	
	//show and hide instructions
    jQuery("#auth_help").click(function () {
        jQuery("#auth_troubleshoot").toggle();
    });
	jQuery("#conn_help").click(function () {
        jQuery("#conn_troubleshoot").toggle();
    });
	
	jQuery("#conn_help_user_mapping").click(function () {
        jQuery("#conn_user_mapping_troubleshoot").toggle();
    });
	
	//show and hide attribute mapping instructions
    jQuery("#toggle_am_content").click(function () {
        jQuery("#show_am_content").toggle();
    });

	 //Instructions
    jQuery("#help_curl_title").click(function () {
    	jQuery("#help_curl_desc").slideToggle(400);
    });

    jQuery("#help_ldap_title").click(function () {
    	jQuery("#help_ldap_desc").slideToggle(400);
    });
    
    jQuery("#help_ping_title").click(function () {
    	jQuery("#help_ping_desc").slideToggle(400);
    });

    jQuery("#help_selinuxboolen_title").click(function () {
        jQuery("#help_selinuxboolen_desc").slideToggle(400);
    });
    
    jQuery("#help_invaliddn_title").click(function () {
    	jQuery("#help_invaliddn_desc").slideToggle(400);
    });
    
    jQuery("#help_invalidsf_title").click(function () {
    	jQuery("#help_invalidsf_desc").slideToggle(400);
    });
    
    jQuery("#help_seracccre_title").click(function () {
    	jQuery("#help_seracccre_desc").slideToggle(400);
    });
    
    jQuery("#help_sbase_title").click(function () {
    	jQuery("#help_sbase_desc").slideToggle(400);
    });
    
    jQuery("#help_sfilter_title").click(function () {
    	jQuery("#help_sfilter_desc").slideToggle(400);
    });
    
    jQuery("#help_ou_title").click(function () {
    	jQuery("#help_ou_desc").slideToggle(400);
    });
    
    jQuery("#help_loginusing_title").click(function () {
    	jQuery("#help_loginusing_desc").slideToggle(400);
    });
    
    jQuery("#help_diffdist_title").click(function () {
    	jQuery("#help_diffdist_desc").slideToggle(400);
    });
    
    jQuery("#help_rolemap_title").click(function () {
    	jQuery("#help_rolemap_desc").slideToggle(400);
    });
    
    jQuery("#help_multiplegroup_title").click(function () {
    	jQuery("#help_multiplegroup_desc").slideToggle(400);
    });
    
    jQuery("#help_curl_warning_title").click(function () {
    	jQuery("#help_curl_warning_desc").slideToggle(400);
    });
    
    jQuery("#help_ldap_warning_title").click(function () {
    	jQuery("#help_ldap_warning_desc").slideToggle(400);
    });
	jQuery("input[name=sitetype]:radio").change(function() {

        if (this.value == 'singlesite') {
            jQuery("#basic_no_of_instances_drop_down").val("1");
             jQuery("#plus_no_of_instances_drop_down").val("1");
             jQuery("#pro_no_of_instances_drop_down").val("1");
            showTotalPrice("Basic","single",0,null);
            showTotalPrice("plus","single",0,null);
            showTotalPrice("pro","single",0,null);


        }else if(this.value == 'multisite'){
            jQuery("#multisite_basic_no_of_instances_drop_down").val("1");
            jQuery("#standard_number_of_subsites_dropdown").val("3");
            jQuery("#multisite_plus_no_of_instances_drop_down").val("1");
            jQuery("#multisite_plus_number_of_subsites_dropdown").val("3");
            jQuery("#pro_multiple_no_of_instances_drop_down").val("1");
            jQuery("#pro_multiple_number_of_subsites_dropdown").val("3");
            showTotalPrice("Basic","multisite",0,0);
            showTotalPrice("plus","multisite",0,0);
            showTotalPrice("pro","multisite",0,0);
        }

    });

    jQuery('#Basic_no_of_instances_drop_down_div').change(function () {
        var selected_instance_index = jQuery("#basic_no_of_instances_drop_down").prop('selectedIndex');
        showTotalPrice("Basic","single",selected_instance_index,null);
    });
    jQuery('#multisite_basic_no_of_instances_drop_down_div').change(function () {
        var selected_instance_index = jQuery("#multisite_basic_no_of_instances_drop_down").prop('selectedIndex');
        var selected_subsite_index = jQuery('#standard_number_of_subsites_dropdown').prop('selectedIndex');
        showTotalPrice("Basic","multisite",selected_instance_index,selected_subsite_index);
    });
    jQuery('#multisite_basic_number_of_subsites_dropdown_div').change(function () {
        var selected_instance_index = jQuery("#multisite_basic_no_of_instances_drop_down").prop('selectedIndex');
        var selected_subsite_index = jQuery('#standard_number_of_subsites_dropdown').prop('selectedIndex');
        showTotalPrice("Basic","multisite",selected_instance_index,selected_subsite_index);
    });

    jQuery('#plus_no_of_instances_drop_down_div').change(function () {
        var selected_instance_index = jQuery("#plus_no_of_instances_drop_down").prop('selectedIndex');
        showTotalPrice("plus","single",selected_instance_index,null);
    });
    jQuery('#multisite_plus_no_of_instances_drop_down_div').change(function () {
        var selected_instance_index = jQuery("#multisite_plus_no_of_instances_drop_down").prop('selectedIndex');
        var selected_subsite_index = jQuery('#multisite_plus_number_of_subsites_dropdown').prop('selectedIndex');
        showTotalPrice("plus","multisite",selected_instance_index,selected_subsite_index);
    });
    jQuery('#multisite_plus_number_of_subsites_dropdown_div').change(function () {
        var selected_instance_index = jQuery("#multisite_plus_no_of_instances_drop_down").prop('selectedIndex');
        var selected_subsite_index = jQuery('#multisite_plus_number_of_subsites_dropdown').prop('selectedIndex');
        showTotalPrice("plus","multisite",selected_instance_index,selected_subsite_index);
    });
    jQuery('#pro_no_of_instances_drop_down_div').change(function () {
        var selected_instance_index = jQuery("#pro_no_of_instances_drop_down").prop('selectedIndex');
        showTotalPrice("pro","single",selected_instance_index,null);
    });
    jQuery('#pro_multiple_no_of_instances_drop_down_div').change(function () {
        var selected_instance_index = jQuery("#pro_multiple_no_of_instances_drop_down").prop('selectedIndex');
        var selected_subsite_index = jQuery('#pro_multiple_number_of_subsites_dropdown').prop('selectedIndex');
        showTotalPrice("pro","multisite",selected_instance_index,selected_subsite_index);
    });
    jQuery('#pro_multiple_number_of_subsites_dropdown_div').change(function () {
        var selected_instance_index = jQuery("#pro_multiple_no_of_instances_drop_down").prop('selectedIndex');
        var selected_subsite_index = jQuery('#pro_multiple_number_of_subsites_dropdown').prop('selectedIndex');
        showTotalPrice("pro","multisite",selected_instance_index,selected_subsite_index);
    });




    function showTotalPrice(planType,sites,selected_instance_index,selected_subsite_index) {
        var subsite_price = [0,45,60,120,160,200,240,280,320,360,400,440,480,520,999];
        var total_price = 0, i=0;
        if(planType === "Basic"){
            total_price = 99;
            var instance_price = [0,89,79,75,71,67,63,59,55,51,200,175,250,150,100,250,166];

        if (selected_subsite_index === null) {
            for(i =0;i <= selected_instance_index;i++){
                total_price = total_price+instance_price[i];
            }
            // total_price = instance_price[selected_instance_index] + 99;
        }
        else {
            total_price = total_price + subsite_price[selected_subsite_index];
            for(i =0;i <= selected_instance_index;i++){
                total_price = total_price+instance_price[i];
            }
            // total_price = instance_price[selected_instance_index] + subsite_price[selected_subsite_index] + (planType === "standard" ? 119 : 199);
        }
        }
        else if(planType === "plus"){
            total_price = 179;
           var instance_price = [0,139,129,119,109,98,86,73,63,53,205,180,260,160,110,300,236];
            if (selected_subsite_index === null) {
                for(i =0;i <= selected_instance_index;i++){
                    total_price = total_price+instance_price[i];
                }
            }
            else {
                total_price = total_price + subsite_price[selected_subsite_index];
                for(i =0;i <= selected_instance_index;i++){
                    total_price = total_price+instance_price[i];
                }
            }
        }
        else if(planType === "pro"){
            total_price = 249;
            var instance_price = [0,199,179,159,139,123,107,89,71,59,225,200,280,180,130,400,210];
            if (selected_subsite_index === null) {
                for(i =0;i <= selected_instance_index;i++){
                    total_price = total_price+instance_price[i];
                }
            }
            else {
                total_price = total_price + subsite_price[selected_subsite_index];
                for(i =0;i <= selected_instance_index;i++){
                    total_price = total_price+instance_price[i];
                }
            }
        }

        if (planType === "Basic") {
            if (selected_subsite_index === null && sites=== "single") {
            var span = document.getElementById("basic_total_price"),
                text = document.createTextNode('$'+total_price);
            span.innerHTML = ''; // clear existing
            span.appendChild(text);
            }
            else{
                var span = document.getElementById("multisite_basic_total_price"),
                    text = document.createTextNode('$'+total_price);
                span.innerHTML = ''; // clear existing
                span.appendChild(text);
            }
        }
        else if(planType === "plus") {
            if (selected_subsite_index === null && sites==="single") {
                var span = document.getElementById("plus_total_price"),
                    text = document.createTextNode('$'+total_price);
                span.innerHTML = ''; // clear existing
                span.appendChild(text);
            }
            else{
                var span = document.getElementById("multisite_plus_total_price"),
                    text = document.createTextNode('$'+total_price);
                span.innerHTML = ''; // clear existing
                span.appendChild(text);
            }
        }
        else if(planType === "pro") {
            if (selected_subsite_index === null && sites==="single") {
                var span = document.getElementById("pro_total_price"),
                    text = document.createTextNode('$'+total_price);
                span.innerHTML = ''; // clear existing
                span.appendChild(text);
            }
            else{
                var span = document.getElementById("multiple_pro_total_price"),
                    text = document.createTextNode('$'+total_price);
                span.innerHTML = ''; // clear existing
                span.appendChild(text);
            }
        }
    }


});