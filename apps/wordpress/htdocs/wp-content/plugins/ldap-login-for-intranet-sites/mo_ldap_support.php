<?php

function mo_ldap_local_support(){

	$current_user = wp_get_current_user();
	if(get_option('mo_ldap_local_admin_email'))
		$admin_email = get_option('mo_ldap_local_admin_email');
	else
		$admin_email = $current_user->user_email;
	
// 	update_option('mo_ldap_local_admin_email',get_option('admin_email'));
	
?>
	<div class="mo_ldap_support_layout" id="mo_ldap_support_layout_ldap" style="position: relative; line-height: 2">
		<h3>Contact Us</h3>
			<form name="f" method="post" action="">
				<div>Need any help?We can help you with configuring LDAP configuration. Just send us a query so we can help you.<br /><br />
                    </div>
				<div>
					<table class="mo_ldap_settings_table">
						<tr><td>
							<input type="email" class="mo_ldap_table_textbox" id="query_email" name="query_email" value="<?php echo $admin_email; ?>" placeholder="Enter your email" required />
							</td>
						</tr>
						<tr><td>
							<input type="text" class="mo_ldap_table_textbox" name="query_phone" id="query_phone" pattern="[\+]\d{11,14}|[\+]\d{1,4}[\s]\d{9,10}" value="<?php echo get_option('mo_ldap_local_admin_phone'); ?>" placeholder="Enter your phone"/>
							</td>
						</tr>
						<tr>
							<td>
								<textarea id="query" name="query" class="mo_ldap_settings_textarea" style="border-radius:4px;resize: vertical;width:100%" cols="52" rows="7" onkeyup="mo_ldap_valid(this)" onblur="mo_ldap_valid(this)" onkeypress="mo_ldap_valid(this)" placeholder="Write your query here"></textarea>
							</td>
						</tr>
					</table>
				</div>
				<input type="hidden" name="option" value="mo_ldap_login_send_query"/>
				<input type="submit" name="send_query" id="send_query" value="Submit Query" style="margin-bottom:3%;" class="button button-primary button-large" />
			</form>
			<br />
	</div>
	<script>
		jQuery("#query_phone").intlTelInput();
		function mo_ldap_valid(f) {
		//	!(/^[a-zA-Z?,.\(\)\/@ 0-9]*$/).test(f.value) ? f.value = f.value.replace(/[^a-zA-Z?,.\(\)\/@ 0-9]/, '') : null;
		}
	</script>
<?php
}
function feature_request(){
    $current_user = wp_get_current_user();
    if(get_option('mo_ldap_local_admin_email'))
        $admin_email = get_option('mo_ldap_local_admin_email');
    else
        $admin_email = $current_user->user_email;
    ?>
    <div class="mo_ldap_support_layout" id="mo_ldap_support_layout_ldap" style="position: relative; line-height: 2">
        <h3>Feature Request</h3>
        <form name="f" method="post" action="">
            <div>
                <i>If you didn't find what you are looking for in the plugin or any of the licensing plans. Please let us know, we will respond back at the earliest and will guide you in the right direction as per your requirement.</i></div>
            <div>
                <table class="mo_ldap_settings_table">
                    <tr><td>
                            <input type="email" class="mo_ldap_table_textbox" id="query_email" name="query_email" value="<?php echo $admin_email; ?>" placeholder="Enter your email" required />
                        </td>
                    </tr>
                    <tr><td>
                            <input type="text" class="mo_ldap_table_textbox" name="query_phone" id="query_phone" pattern="[\+]\d{11,14}|[\+]\d{1,4}[\s]\d{9,10}" value="<?php echo get_option('mo_ldap_local_admin_phone'); ?>" placeholder="Enter your phone"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <textarea id="query" name="query" class="mo_ldap_settings_textarea" style="border-radius:4px;resize: vertical;width:100%" cols="52" rows="7" onkeyup="mo_ldap_valid(this)" onblur="mo_ldap_valid(this)" onkeypress="mo_ldap_valid(this)" placeholder="Write your query here"></textarea>
                        </td>
                    </tr>
                </table>
            </div>
            <input type="hidden" name="option" value="mo_ldap_login_send_query"/>
            <input type="submit" name="send_query" id="send_query" value="Submit Query" style="margin-bottom:3%;" class="button button-primary button-large" />
        </form>
        <br />
    </div>
    <script>
        jQuery("#query_phone").intlTelInput();
        function mo_ldap_valid(f) {
            //	!(/^[a-zA-Z?,.\(\)\/@ 0-9]*$/).test(f.value) ? f.value = f.value.replace(/[^a-zA-Z?,.\(\)\/@ 0-9]/, '') : null;
        }
    </script>
    <?php
}
?>