<?php function display_ldap_feedback_form()
{
    if ('plugins.php' != basename($_SERVER['PHP_SELF'])) {
        return;
    }

    $mo_ldap_message = get_option('mo_ldap_local_message');
    wp_enqueue_style('wp-pointer');
    wp_enqueue_script('wp-pointer');
    wp_enqueue_script('utils');
    wp_enqueue_style('mo_ldap_admin_plugins_page_style', plugins_url('includes/css/mo_ldap_plugins_page.css', __FILE__));
    ?>

    </head>
    <body>


    <!-- The Modal -->
    <div id="ldapModal" class="mo_ldap_modal">

        <!-- Modal content -->
        <div class="mo_ldap_modal-content">
            <span class="mo_ldap_close">&times;</span>
            <h3 style="margin: 2%;">Leaving us? </h3>
            <form name="f" method="post" action="" id="mo_ldap_feedback">
                <input type="hidden" name="option" value="mo_ldap_feedback"/>
                <div>
                    <p style="margin:2%">
                        <br>
                        <textarea id="query_feedback" name="query_feedback" required rows="5" style="width: 100%"
                                  placeholder="Tell us what happended!" minlength="10"></textarea>
                        <br><br>
                    <div class="mo_ldap_modal-footer" style="text-align: center">
                        <input type="submit" name="miniorange_ldap_feedback_submit" id="miniorange_ldap_feedback_submit"
                               class="button button-primary button-large" value="Submit"/>
                        <input type="button" name="miniorange_skip_feedback"
                               class="button button-large" value="Skip Feedback and Deactivate"
                               onclick="document.getElementById('mo_ldap_feedback_form_close').submit();"/>
                    </div>
                </div>
            </form>
            <form name="mo_ldap_feedback_form_close" method="post" action="" id="mo_ldap_feedback_form_close">
                <input type="hidden" name="option" value="mo_ldap_skip_feedback"/>
            </form>

        </div>

    </div>

    <script>
       var active_plugins = document.getElementsByClassName('deactivate');		
	for (i = 0; i<active_plugins.length;i++) {			
		var plugin_deactivate_link = active_plugins.item(i).getElementsByTagName('a').item(0);
		var plugin_name = plugin_deactivate_link.href;
		if (plugin_name.includes('plugin=ldap-login-for-intranet-sites')) {			
			jQuery(plugin_deactivate_link).click(function () {				
				// Get the mo_ldap_modal
            var mo_ldap_modal = document.getElementById('ldapModal');

				// Get the <span> element that closes the mo_ldap_modal
            var span = document.getElementsByClassName("mo_ldap_close")[0];

				// When the user clicks the button, open the mo_ldap_modal
            mo_ldap_modal.style.display = "block";
				// When the user clicks on <span> (x), mo_ldap_close the mo_ldap_modal
            span.onclick = function () {
                mo_ldap_modal.style.display = "none";
                jQuery('#mo_ldap_feedback_form_close').submit();
            }

            // When the user clicks anywhere outside of the mo_ldap_modal, mo_ldap_close it
            window.onclick = function (event) {
                if (event.target == mo_ldap_modal) {
                    mo_ldap_modal.style.display = "none";
                }
            }
            return false;
			});
			break;
		}
	}
    </script><?php
}

?>