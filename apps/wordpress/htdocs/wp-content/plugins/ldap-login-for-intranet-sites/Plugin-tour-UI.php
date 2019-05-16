<?php
function plugin_tour_ui() {
?>
    <div id="mo_ldap_settings" >
        <form name="f" method="post" id="show_ldap_pointers">
            <input type="hidden" name="option" value="clear_ldap_pointers"/>
            <input type="hidden" name="restart_tour" id="restart_tour"/>
            <input type="hidden" name="restart_plugin_tour" id="restart_plugin_tour"/>
        </form></div>
<br>
    <div style="font-size: large; font-weight: 600;">miniOrange LDAP/Active Directory Login for Intranet Sites
        <a id="license_upgrade" class=" add-new-h2 add-new-hover" style="position: relative;background-color: #e97d68 !important; border-color: orange; font-size: 16px; color: white;padding: 10px 18px; text-align: center;text-decoration: none;display: inline-block;" href="<?php echo add_query_arg( array( 'tab' => 'pricing' ), htmlentities( $_SERVER['REQUEST_URI'] ) ); ?>">Licensing Plans</a>
        <span id="configure-restart-plugin-tour" style="position: relative;">
            <button id="restart_plugin_tour" type="button" value="restart_plugin_tour" style="position: relative" class="button button-primary button-large"  onclick="jQuery('#restart_plugin_tour').val('true');jQuery('#show_ldap_pointers').submit();"><i class="fa fa-refresh"></i>Restart Plugin Tour</button>
            </span></div>
    <?php
    if(!Mo_Ldap_Local_Util::is_curl_installed()) {
        ?>

        <div class="notice notice-info is-dismissible">
            <div id="help_curl_warning_title" class="mo_ldap_title_panel">
                <p><font color="#FF0000">Warning: PHP cURL extension is not installed or disabled.</font></p>
                <p><a target="_blank" style="cursor: pointer;">Click here for instructions to enable it.</a></p>
            </div>
            <div hidden="" id="help_curl_warning_desc" class="mo_ldap_help_desc">
                <ul>
                    <li style="font-size: large; font-weight: bold">Step 1 </li>
                    <li style="font-size: large; font-weight: bold"><b>Loaded configuration file : <?php echo php_ini_loaded_file() ?></b></li>
                    <li style="list-style-type:square;margin-left:20px">Open php.ini file from above file path</br></li><br/>
                    <li style="font-size: large; font-weight: bold">Step 2</li>
                    <li style="font-weight: bold"><font color="#C31111"><b>For Windows users</b></font></li>
                    <li style="list-style-type:square;margin-left:20px">Search for <b>"extension=php_curl.dll"</b> in php.ini file. Uncomment this line, if not present then add this line in the file and save the file.</li>
                    <li><font color="#C31111"><b>For Linux users</b></font>
                        <ul style="list-style-type:square;margin-left: 20px">
                            <li style="margin-top: 5px">Install php curl extension (If not installed yet)
                                <ul style="list-style-type:disc;margin-left: 15px;margin-top: 5px">
                                    <li>For Debian, the installation command would be <b>apt-get install php-curl</b></li>
                                    <li>For RHEL based systems, the command would be <b>yum install php-curl</b></li></ul></li></li>
                            <li>Search for <b>"extension=php_curl.so"</b> in php.ini file. Uncomment this line, if not present then add this line in the file and save the file.</li></ul><br/>
                    <li style="margin-top: 5px;font-size: large; font-weight: bold">Step 3</li>
                    <li style="list-style-type:square;margin-left:20px">Restart your server. After that refresh the "LDAP/AD" plugin configuration page.</li>
                </ul>
                For any further queries, please <a href="mailto:info@miniorange.com">contact us</a>.
            </div>
        </div>

        <?php
    }

    if(!Mo_Ldap_Local_Util::is_extension_installed('ldap')) {
        ?>
        <div class="notice notice-info is-dismissible">
            <p><font color="#FF0000">Warning: PHP LDAP extension is not installed or disabled.</font></p>
            <div id="help_ldap_warning_title" class="mo_ldap_title_panel">
                <p><a target="_blank" style="cursor: pointer;">Click here for instructions to enable it.</a></p>
            </div>
            <div hidden="" style="padding: 2px 2px 2px 12px" id="help_ldap_warning_desc" class="mo_ldap_help_desc">
                <ul>
                    <li style="font-size: large; font-weight: bold">Step 1 </li>
                    <li style="font-size: large; font-weight: bold"><b>Loaded configuration file : <?php echo php_ini_loaded_file() ?></b></li>
                    <li style="list-style-type:square;margin-left:20px">Open php.ini file from above file path</b></li><br/>
                    <li style="font-size: large; font-weight: bold">Step 2</li>
                    <li ><font style="font-weight: bold" color="#C31111"><b>For Windows users using Apache Server</b></font></li>
                    <li style="list-style-type:square;margin-left:20px">Search for <b>"extension=php_ldap.dll"</b> in php.ini file. Uncomment this line, if not present then add this line in the file and save the file.</li>
                    <li><font color="#C31111"><b>For Windows users using IIS server</b></font></li>
                    <li style="list-style-type:square;margin-left:20px">Search for <b>"ExtensionList"</b> in the php.ini file. Uncomment the <b>"extension=php_ldap.dll"</b> line, if not present then add this line in the file and save the file.</li>
                    <li><font color="#C31111"><b>For Linux users</b></font>
                        <ul style="list-style-type:square;margin-left: 20px">
                            <li style="margin-top: 5px">Install php ldap extension (If not installed yet)
                                <ul style="list-style-type:disc;margin-left: 15px;margin-top: 5px">
                                    <li>For Debian, the installation command would be <b>apt-get install php-ldap</b></li>
                                    <li>For RHEL based systems, the command would be <b>yum install php-ldap</b></li></ul></li></li>
                            <li>Search for <b>"extension=php_ldap.so"</b> in php.ini file. Uncomment this line, if not present then add this line in the file and save the file.</li></ul><br/>
                    <li style="margin-top: 5px;font-size: large; font-weight: bold">Step 3</li>
                    <li style="list-style-type:square;margin-left:20px">Restart your server. After that refresh the "LDAP/AD" plugin configuration page.</li>
                </ul>
                For any further queries, please <a href="mailto:info@miniorange.com">contact us</a>.
            </div>
            <p><font color="black">If your site is hosted on <b>Shared Hosting</b> and it is impossible you to enable the extension then you can use our <a href="https://wordpress.org/plugins/miniorange-wp-ldap-login/" target="_blank" style="cursor: pointer;">LDAP/AD cloud plugin</font></a></p>
        </div>
        <?php
    }
    if(!Mo_Ldap_Local_Util::is_extension_installed('openssl')) {
        ?>
        <div class="notice notice-info is-dismissible">
        <p><font color="#FF0000">(Warning: <a target="_blank" href="http://php.net/manual/en/openssl.installation.php">PHP OpenSSL extension</a> is not installed or disabled)</font></p>
        </div>
        <?php
    }
?>

    <style>
        .add-new-hover:hover{
            color: white !important;
        }
		.reportTable{border-collapse: collapse; border:1px solid #ccc; width:100%}

        .reportTable, .reportTable th, .reportTable td {
            border: 1px solid black;
            align: center;
        }

        .reportTable th, .reportTable td{padding:10px}

    </style>
	   <div class="notice notice-info is-dismissible">
        <h4>We are providing the Add-ons such as<i> Kerberos/NTLM SSO, Directory Sync Add-on, BuddyPress Sync Add-on etc.</i>    You can try out <a id="Add_on_licensing_pointer" style="position: relative"  href="<?php echo add_query_arg( array( 'tab' => 'add_on'), htmlentities( $_SERVER['REQUEST_URI'] )); ?>" onclick="<?php update_option('add_on_page',1);?>" >Add-ons</a> to get more info.</h4>
    </div>
    <div class="notice notice-info is-dismissible">
        <h4>If you are looking for Single-Sign-On in addition to authentication with AD/LDAP and do not have any Identity Provider Yet. You can try out <a href="https://idp.miniorange.com" target="_blank">miniOrange On-Premise IdP</a>.</h4>
    </div>
    <div class="mo2f_container">
            <h2 class="nav-tab-wrapper">
                <a id="ldap_default_tab_pointer" style="position: relative" class="nav-tab nav-tab-active" href="<?php echo add_query_arg( array('tab' => 'default'), $_SERVER['REQUEST_URI'] ); ?>">LDAP Configuration</a>
                <a id="ldap_role_mapping_tab_pointer" style="position: relative" class="nav-tab " href="<?php echo add_query_arg( array('tab' => 'rolemapping'), $_SERVER['REQUEST_URI'] ); ?>">Role Mapping</a>
                <a id="ldap_attribute_mapping_tab_pointer" style="position: relative" class="nav-tab" href="<?php echo add_query_arg( array('tab' => 'attributemapping'), $_SERVER['REQUEST_URI'] ); ?>">Attribute Mapping</a>
                <a id="ldap_config_settings_tab_pointer" style="position: relative" class="nav-tab" href="<?php echo add_query_arg( array('tab' => 'config_settings'), $_SERVER['REQUEST_URI'] ); ?>">Configuration Settings</a>
                <a id="ldap_User_Report_tab_pointer" style="position: relative" class="nav-tab " href="<?php echo add_query_arg( array('tab' => 'Users_Report'), $_SERVER['REQUEST_URI'] ); ?>">Report</a>
				<a id="ldap_troubleshooting_tab_pointer" style="position: relative" class="nav-tab" href="<?php echo add_query_arg( array('tab' => 'troubleshooting'), $_SERVER['REQUEST_URI'] ); ?>">Troubleshooting</a>
                <a id="ldap_feature_request_tab_pointer" style="position: relative" class="nav-tab" href="<?php echo add_query_arg( array('tab' => 'feature_request'), $_SERVER['REQUEST_URI'] ); ?>">Feature Request</a>
                <a id="ldap_account_setup_tab_pointer" style="position: relative" class="nav-tab" href="<?php echo add_query_arg( array('tab' => 'account'), $_SERVER['REQUEST_URI'] ); ?>">Account Setup</a>

            </h2>
            <table style="width:100%;">
                <tr>
                    <td style="width:65%;vertical-align:top;" id="configurationForm">
                        <div id="ldap_configuration_tab" style="display: block">
                            <?php echo mo_ldap_local_configuration_page(); ?>
                        </div>


                        <div id="troubleshooting_tab" style="display: none">
                            <?php echo mo_ldap_local_troubleshooting(); ?>
                        </div>


                        <div id="role_mapping_tab" style="display: none;">
                            <?php echo mo_ldap_local_rolemapping(); ?>
                        </div>


                        <div id="registration_tab" style="display: none">
                            <?php if (get_option ( 'mo_ldap_local_verify_customer' ) == 'true') {
                                echo mo_ldap_show_verify_password_page_ldap();
                            } else if (! Mo_Ldap_Local_Util::is_customer_registered()) {
                                echo mo_ldap_show_new_registration_page_ldap();
                            } else{
                                echo mo_ldap_show_customer_details();
                            }?>
                        </div>


                        <div id="attribute_mapping_tab" style="display: none">
                            <?php echo mo_ldap_show_attribute_mapping_page(); ?>
                        </div>


                        <div id="export_tab" style="display: none">
                            <?php echo mo_show_export_page(); ?>
                        </div>
						
						 <div id="Users_Report" style="display: none">
                            <?php echo mo_user_report_page(); ?>
                        </div>


                        <div id="feature_request_tab" style="display:none;">
                            <?php echo mo_ldap_local_support(); ?>
                        </div>

                    </td>

                        <td style="vertical-align:top;padding-left:1%;">
                            <?php echo mo_ldap_local_support(); ?>
                        </td>
                </tr>
            </table>
    </div>
    <div class='overlay_back' id="overlay" hidden></div>
<?php } ?>