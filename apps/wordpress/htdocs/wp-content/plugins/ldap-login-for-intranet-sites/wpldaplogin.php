<?php
/*
Plugin Name: Active Directory Integration for Intranet sites
Plugin URI: http://miniorange.com
Description: Active Directory Integration for Intranet sites plugin provides login to WordPress using credentials stored in your LDAP Server.
Author: miniorange
Version: 3.0.9
Author URI: https://miniorange.com
*/

require_once 'mo_ldap_pages.php';
require_once 'Plugin-tour-UI.php';
require('mo_ldap_support.php');
require('class-mo-ldap-customer-setup.php');
require('class-mo-ldap-utility.php');
require('class-mo-ldap-config.php');
require('class-mo-ldap-role-mapping.php');
require ('mo_ldap_licensing_plans.php');
require('ldap_feedback_form.php');
require_once "PointersManager_ldap.php";
require_once dirname( __FILE__ ) . '/includes/lib/Mo_Pointer_Ldap.php';
require_once dirname( __FILE__ ) . '/includes/lib/export.php';

define( "Tab_ldap_Class_Names", serialize( array(
    "ldap_Login"         => 'mo_options_ldap_acc_details',
    "ldap_config" => 'mo_options_ldap_config_details',
    "Role_Mapping"      => 'mo_option_ldap_role_mapping',
    "Attribute_Mapping" => 'mo_options_ldap_enum_attribute_mapping'


) ) );

error_reporting(E_ERROR);

class Mo_Ldap_Local_Login
{

    function __construct()
    {
        add_option('mo_ldap_local_register_user', 1);
        add_option('mo_ldap_local_cust', 0);
        add_action('admin_menu', array($this, 'mo_ldap_local_login_widget_menu'));
        add_action('admin_init', array($this, 'login_widget_save_options'));
		
        add_action('init', array($this, 'test_attribute_configuration'));
        add_action('admin_enqueue_scripts', array($this, 'mo_ldap_local_settings_style'));
        add_action('admin_enqueue_scripts', array($this, 'mo_ldap_local_settings_script'));
        add_action('parse_request', array($this, 'parse_sso_request'));
        remove_action('admin_notices', array($this, 'success_message'));
        remove_action('admin_notices', array($this, 'error_message'));
        add_filter('query_vars', array($this, 'plugin_query_vars'));
        register_deactivation_hook(__FILE__, array($this, 'mo_ldap_local_deactivate'));
        register_uninstall_hook(__FILE__, array($this, 'mo_ldap_local_uninstall'));
        add_action('login_footer', 'mo_ldap_local_link');
        add_action('show_user_profile', array($this, 'show_user_profile'));
        if (get_option('mo_ldap_local_enable_login') == 1) {
            remove_filter('authenticate', 'wp_authenticate_username_password', 20, 3);
            add_filter('authenticate', array($this, 'ldap_login'), 7, 3);

            //Add hook to create users in LDAP when new users are created
            //add_action( 'user_register', array($this, 'mo_ldap_add_user'));
        }
        //add_filter( 'show_password_fields', array( $this, false ));
        register_activation_hook(__FILE__, array($this, 'mo_ldap_activate'));
        add_action('admin_footer', array($this, 'ldap_feedback_request'));
    }

    function ldap_feedback_request()
    {
        display_ldap_feedback_form();
    }

    function show_user_profile($user)
    {

        if ($this->is_administrator_user($user)) {
            $custom_attributes = array();
            $wp_options = wp_load_alloptions();

            ?>
            <h3>Extra profile information</h3>

            <table class="form-table">

                <tr>
                    <td><b><label for="user_dn">User DN</label></b></td>

                    <td>
                        <b><?php echo esc_attr(get_the_author_meta('mo_ldap_user_dn', $user->ID)); ?></b></td>
                    </td>
                </tr>
                <?php
                foreach ($wp_options as $option => $value) {
                    if (strpos($option, "mo_ldap_local_custom_attribute") === false) {
                        //Do nothing
                    } else {
                        ?>
                        <tr>
                        <td><b><font color="#FF0000"></font><?php echo $value; ?></b></td>
                        <td><input type="text" name="<?php echo $option; ?>"
                                   value="<?php echo get_user_meta($user->ID, $option, true); ?>" style="width:61%;"/>
                        </td>
                        </tr><?php
                    }
                }

                ?>
            </table>

            <?php
        }
    }


    function ldap_login($user, $username, $password)
    {
        if (empty($username) || empty ($password)) {
            //create new error object and add errors to it.
            $error = new WP_Error();

            if (empty($username)) { //No email
                $error->add('empty_username', __('<strong>ERROR</strong>: Email field is empty.'));
            }

            if (empty($password)) { //No password
                $error->add('empty_password', __('<strong>ERROR</strong>: Password field is empty.'));
            }
            return $error;
        }


        if (get_option('mo_ldap_local_enable_admin_wp_login')) {
            if (username_exists($username)) {
                $user = get_user_by("login", $username);
                if ($user && $this->is_administrator_user($user)) {
                    if (wp_check_password($password, $user->data->user_pass, $user->ID)){
						//$this->mo_ldap_report_update($username,"SUCCESS","Login Successfully");
                        return $user;
					}
                }
            }
        }

        $mo_ldap_config = new Mo_Ldap_Local_Config();
        $auth_response = $mo_ldap_config->ldap_login($username, $password);

        if ($auth_response->statusMessage == 'SUCCESS') {


            if (username_exists($username) || email_exists($username)) {
                $user = get_user_by("login", $username);
                if (empty($user)) {
                    $user = get_user_by("email", $username);
                }
                if (empty($user)) {
					$this->mo_ldap_report_update($username,'ERROR','<strong>Login Error:</strong> Invalid Username/Password combination');
                    $error = new WP_Error();
                    $error->add('error_fetching_user', __('<strong>ERROR</strong>: Invalid Username/Password combination.'));
                    return $error;
                }

                if(get_option('mo_ldap_local_enable_role_mapping')) {
                    $mo_ldap_role_mapping = new Mo_Ldap_Local_Role_Mapping();
                    $member_of_attr = $mo_ldap_role_mapping->get_member_of_attribute($username, $password);
                    $mo_ldap_role_mapping->mo_ldap_local_update_role_mapping($user->ID, $member_of_attr);
                }



                //Update user password if enabled
                $fallback_login_enabled = get_option('mo_ldap_local_enable_fallback_login');
                if ($fallback_login_enabled)
                    wp_set_password($password, $user->ID);

                //Store distinguishedName in User Meta
                update_user_meta($user->ID, 'mo_ldap_user_dn', $auth_response->userDn, false);

                //Update email, fname and lname attributes for user
                $profile_attributes = $auth_response->profileAttributesList;


                $user_data['ID'] = $user->ID;
                if(!empty($profile_attributes['mail']))
                    $user_data['user_email'] = $profile_attributes['mail'];
                if(!empty($profile_attributes['fname']))
                    $user_data['first_name'] = $profile_attributes['fname'];
                if(!empty($profile_attributes['lname']))
                    $user_data['last_name'] = $profile_attributes['lname'];

                wp_update_user($user_data);

                if (get_option('mo_ldap_local_cust', '1') != '0') {
                    //Store custom attributes in user meta
                    $custom_attributes = $auth_response->attributeList;
                    foreach ($custom_attributes as $attribute => $value) {
                        update_user_meta($user->ID, $attribute, $value);
                    }
                }
				//$this->mo_ldap_report_update($username,'SUCCESS','Login Successfully');
                return $user;
            } else {

                if (!get_option('mo_ldap_local_register_user')) {
					 $this->mo_ldap_report_update($username,'ERROR','<strong>Login Error:</strong> Your Administrator has not enabled Auto Registration. Please contact your Administrator.');
                    $error = new WP_Error();
                    $error->add('registration_disabled_error', __('<strong>ERROR</strong>: Your Administrator has not enabled Auto Registration. Please contact your Administrator.'));
                    return $error;
                } else {
                    //create user if not exists
                    $ldap_info = $mo_ldap_config->get_user_ldap_info($username);

                    //Update user password as LDAP password if enabled, else generate new password
                    $fallback_login_enabled = get_option('mo_ldap_local_enable_fallback_login');
                    if ($fallback_login_enabled)
                        $user_password = $password;
                    else
                        $user_password = wp_generate_password(10, false);

                    $profile_attributes = $auth_response->profileAttributesList;

                    if(!empty($profile_attributes['mail']))
                        $email = $profile_attributes['mail'];
                    if(!empty($profile_attributes['fname']))
                        $fname = $profile_attributes['fname'];
                    if(!empty($profile_attributes['lname']))
                        $lname = $profile_attributes['lname'];

                    $userdata = array(
                        'user_login' => $username,
                        'user_email' => $email,
                        'first_name' => $fname,
                        'last_name' => $lname,
                        'user_pass' => $user_password  // Create user with LDAP password as local password
                    );
                    $user_id = wp_insert_user($userdata);

                    //On success
                    if (!is_wp_error($user_id)) {
                        $user = get_user_by("login", $username);

                        //Store distinguishedName in User Meta
                        update_user_meta($user->ID, 'mo_ldap_user_dn', $auth_response->userDn, false);


                        if (get_option('mo_ldap_local_cust', '1') != '0') {
                            //Store custom attributes in user meta
                            $custom_attributes = $auth_response->attributeList;
                            foreach ($custom_attributes as $attribute => $value) {
                                update_user_meta($user->ID, $attribute, $value);
                            }
                        }

                        //Role Mapping: Assign default role in role mapping is not set.
                        $role_mapping_count = get_option('mo_ldap_local_enable_role_mapping');

                        if(get_option('mo_ldap_local_enable_role_mapping')) {
                            $mo_ldap_role_mapping = new Mo_Ldap_Local_Role_Mapping();
                            $member_of_attr = $mo_ldap_role_mapping->get_member_of_attribute($username, $password);
                            $mo_ldap_role_mapping->mo_ldap_local_update_role_mapping($user->ID, $member_of_attr);
                        }
						//$this->mo_ldap_report_update($username,$auth_response->statusMessage,'Login Successfully');
                        return $user;
                    } else {
                        $error = new WP_Error();
						$this->mo_ldap_report_update($username,$auth_response->statusMessage,'<strong>Login Error:</strong> There was an error registering your account. Please try again.');
                        $error->add('registration_error', __('<strong>ERROR</strong>: There was an error registering your account. Please try again.'));
                        return $error;
                    }
                }
            }

            wp_redirect(site_url());
            exit;

        } else if ($auth_response->statusMessage == 'LDAP_NOT_RESPONDING') {
			$this->mo_ldap_report_update($username,$auth_response->statusMessage,'<strong>Login Error: </strong> LDAP server is not responding ');
            $fallback_login_enabled = get_option('mo_ldap_local_enable_fallback_login');
            if ($fallback_login_enabled) {
                remove_filter('authenticate', array($this, 'ldap_login'), 20, 3);
                add_filter('authenticate', 'wp_authenticate_username_password', 20, 3);
                $user = wp_authenticate($username, $password);
                return $user;
            }

        } else if ($auth_response->statusMessage == 'LDAP_ERROR') {
			$this->mo_ldap_report_update($username,$auth_response->statusMessage,'<strong>Login Error:</strong> <a target="_blank" href="http://php.net/manual/en/ldap.installation.php">PHP LDAP extension</a> is not installed or disabled. Please enable it.');
            $error = new WP_Error();
            $error->add('curl_error', __('<strong>ERROR</strong>: <a target="_blank" href="http://php.net/manual/en/ldap.installation.php">PHP LDAP extension</a> is not installed or disabled. Please enable it.'));

            return $error;
        } else if ($auth_response->statusMessage == 'CURL_ERROR') {
			$this->mo_ldap_report_update($username,$auth_response->statusMessage,'<strong>Login Error:</strong> <a href="http://php.net/manual/en/curl.installation.php">PHP cURL extension</a> is not installed or disabled.');
            $error = new WP_Error();
            $error->add('curl_error', __('<strong>ERROR</strong>: <a href="http://php.net/manual/en/curl.installation.php">PHP cURL extension</a> is not installed or disabled.'));
            return $error;
        } else if ($auth_response->statusMessage == 'OPENSSL_ERROR') {
			$this->mo_ldap_report_update($username,$auth_response->statusMessage,'<strong>Login Error:</strong> <a target="_blank" href="http://php.net/manual/en/openssl.installation.php">PHP OpenSSL extension</a> is not installed or disabled.');
            $error = new WP_Error();
            $error->add('OPENSSL_ERROR', __('<strong>ERROR</strong>: <a target="_blank" href="http://php.net/manual/en/openssl.installation.php">PHP OpenSSL extension</a> is not installed or disabled.'));
            return $error;
        } else {
            $error = new WP_Error();
			$this->mo_ldap_report_update($username,$auth_response->statusMessage,"<strong>Login Error:</strong> Invalid username or incorrect password");
            $error->add('incorrect_credentials', __('<strong>ERROR</strong>: Invalid username or incorrect password. Please try again.'));
            return $error;
        }
    }

    function mo_ldap_add_user($user_id)
    {
        $user_info = get_userdata($user_id);
        $mo_ldap_config = new Mo_Ldap_Local_Config();
        $mo_ldap_config->add_user($user_info);

    }

    function mo_ldap_local_login_widget_menu()
    {
        add_menu_page('LDAP/AD Login for Intranet', 'LDAP/AD Login for Intranet', 'activate_plugins', 'mo_ldap_local_login', array($this, 'mo_ldap_local_login_widget_options'), plugin_dir_url(__FILE__) . 'includes/images/miniorange_icon.png');
        add_submenu_page( 'mo_ldap_local_login'	,'LDAP/AD plugin','Licensing Plans','manage_options','mo_ldap_local_login&amp;tab=pricing', array( $this, 'mo_ldap_show_licensing_page'));

    }

    function mo_ldap_local_login_widget_options()
    {
        update_option('mo_ldap_local_host_name', 'https://auth.miniorange.com');
        //Setting default configuration
        $default_config = array(
            'server_url' => 'ldap://58.64.132.235:389',
            'service_account_dn' => 'cn=testuser,cn=Users,dc=miniorange,dc=com',
            'admin_password' => 'XXXXXXXX',
            'dn_attribute' => 'distinguishedName',
            'search_base' => 'cn=Users,dc=miniorange,dc=com',
            'search_filter' => '(&(objectClass=*)(cn=?))',
            'test_username' => 'testuser',
            'test_password' => 'password'
        );
        update_option('mo_ldap_local_default_config', $default_config);
        if (!get_option('load_static_UI')) {
            add_option('load_static_UI','true');
        }
        if (get_option('load_static_UI') && get_option('load_static_UI') == 'true') {
            plugin_tour_ui();
        } else {
            mo_ldap_local_settings();
        }
    }

    public static function checkPasswordpattern($password){
        $pattern = '/^[(\w)*(\!\@\#\$\%\^\&\*\.\-\_)*]+$/';

        return !preg_match($pattern,$password);
    }

    function create_customer() {
        $customer    = new Mo_Ldap_Local_Customer();
        $customerKey = $customer->create_customer();

        if (!empty($customerKey)) {
            $customerKey = json_decode($customerKey,true);
            if (strcasecmp($customerKey['status'], 'CUSTOMER_USERNAME_ALREADY_EXISTS') == 0) {
                $api_response = $this->get_current_customer();
                if ($api_response) {
                    $response['status'] = "success";
                } else
                    $response['status'] = "error";

            } else if (strcasecmp($customerKey['status'], 'SUCCESS') == 0) {
                $this->save_success_customer_config($customerKey['id'], $customerKey['apiKey'], $customerKey['token'], 'Thanks for registering with the miniOrange');
                update_option('mo_ldap_local_password', '');
                $response['status'] = "success";
                return $response;
            }
        } else {
            $response['status'] = "error";
        }

        update_option( 'mo_saml_admin_password', '' );
        return $response;
    }

    function get_current_customer() {
        $customer    = new Mo_Ldap_Local_Customer();
        $content     = $customer->get_customer_key();
        if (!empty($content)) {
            $customerKey = json_decode($content, true);

            $response = array();
            if (json_last_error() == JSON_ERROR_NONE) {
                $this->save_success_customer_config($customerKey['id'], $customerKey['apiKey'], $customerKey['token'], 'Thanks for registering with miniOrange.');
                update_option('mo_ldap_local_password', '');
                $response['status'] = "success";
                return $response;
            } else {

                update_option('mo_ldap_local_message', 'You already have an account with miniOrange. Please enter a valid password.');
                $this->show_error_message();
                $response['status'] = "error";
                return $response;
            }
        } else {
            $response['status'] = "error";
            return $response;
        }
    }

    function login_widget_save_options()
    {

        if (isset($_POST['option'])) {
            if ($_POST['option'] == "mo_ldap_local_register_customer") {        //register the customer
                //validate and sanitize
                $email = '';
                $phone = '';
                $password = '';
                $confirmPassword = '';
                $fname = '';
                $lname = '';
                $companyName = '';
                if (Mo_Ldap_Local_Util::check_empty_or_null($_POST['email']) || Mo_Ldap_Local_Util::check_empty_or_null($_POST['password'])) {
                    update_option('mo_ldap_local_message', 'All the fields are required. Please enter valid entries.');
                    $this->show_error_message();
                    return;
                } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    update_option('mo_ldap_local_message', 'Please enter a valid email address.');
                    $this->show_error_message();
                    return;
                } else if ($this->checkPasswordpattern(strip_tags($_POST['password']))) {
                    update_option('mo_ldap_local_message', 'Minimum 6 characters should be present. Maximum 15 characters should be present. Only following symbols (!@#.$%^&*-_) should be present.');
                    $this->show_error_message();
                    return;
                } else {
                    $email = sanitize_email($_POST['email']);
                    $password = sanitize_text_field($_POST['password']);
                    $confirmPassword = sanitize_text_field($_POST['confirmPassword']);
                }

                update_option('mo_ldap_local_admin_email', $email);

                if (strcmp($password, $confirmPassword) == 0) {
                    update_option('mo_ldap_local_password', $password);
                    $customer = new Mo_Ldap_Local_Customer();
                    $content = $customer->check_customer();
                    if (!empty($content)) {
                        $content = json_decode($content, true);
                        if (strcasecmp($content['status'], 'CUSTOMER_NOT_FOUND') == 0) {
                            $content = $this->create_customer();
                            if (is_array($content) && array_key_exists('status', $content) && $content['status'] == 'success') {
                                wp_redirect(admin_url('/admin.php?page=mo_ldap_local_login&tab=pricing'), 301);
                                exit;
                            }
                        } else {
                            $response = $this->get_current_customer();
                            if (is_array($response) && array_key_exists('status', $response) && $response['status'] == 'success') {
                                wp_redirect(admin_url('/admin.php?page=mo_ldap_local_login&tab=pricing'), 301);
                                exit;
                            }
                        }
                    }
                } else {
                    update_option('mo_ldap_local_message', 'Password and Confirm password do not match.');
                    delete_option('mo_ldap_local_verify_customer');
                    $this->show_error_message();
                    return;
                }

            } else if ($_POST['option'] == "mo_ldap_local_verify_customer") {    //login the admin to miniOrange

                //validation and sanitization
                $email = '';
                $password = '';
                if (Mo_Ldap_Local_Util::check_empty_or_null($_POST['email']) || Mo_Ldap_Local_Util::check_empty_or_null($_POST['password'])) {
                    update_option('mo_ldap_local_message', 'All the fields are required. Please enter valid entries.');
                    $this->show_error_message();
                    return;
                } else {
                    $email = sanitize_email($_POST['email']);
                    $password = sanitize_text_field($_POST['password']);
                }

                update_option('mo_ldap_local_admin_email', $email);
                update_option('mo_ldap_local_password', $password);
                $customer = new Mo_Ldap_Local_Customer();
                $content = $customer->get_customer_key();
                if (!empty($content)) {
                    $customerKey = json_decode($content, true);
                    if (strcasecmp($customerKey['apiKey'], 'CURL_ERROR') == 0) {
                        update_option('mo_ldap_local_message', $customerKey['token']);
                        $this->show_error_message();
                    } else if (json_last_error() == JSON_ERROR_NONE) {
                        update_option('mo_ldap_local_admin_phone', $customerKey['phone']);
                        $this->save_success_customer_config($customerKey['id'], $customerKey['apiKey'], $customerKey['token'], 'Your account has been retrieved successfully.');
                        update_option('mo_ldap_local_password', '');
                    } else {
                        update_option('mo_ldap_local_message', 'Invalid username or password. Please try again.');
                        $this->show_error_message();
                    }
                    update_option('mo_ldap_local_password', '');
                }
                else {
                    update_option('mo_ldap_local_message', 'Error in request');
                    $this->show_error_message();
                }
            }else if($_POST['option'] == "clear_ldap_pointers"){
                $uid = get_current_user_id();
                $Ldap_array_dissmised_pointers = explode( ',', (string) get_user_meta( $uid, 'dismissed_wp_pointers', TRUE ) );
                if ( isset( $_GET['tab'] ) ) {
                    $active_tab = $_GET['tab'];
                }else {
                    $active_tab = 'default';
                }
                if (isset($_POST['restart_plugin_tour']) && $_POST['restart_plugin_tour']=='true') {
                    update_option('overall_plugin_tour','true');
                    update_option('load_static_UI','true');
                    $Ldap_array_dissmised_pointers = array_diff($Ldap_array_dissmised_pointers,mo_options_ldap_enum_pointers::$LDAP_PLUGIN_TOUR);
                }
                else if (isset($_POST['restart_tour']) && $_POST['restart_tour']=='true') {
                    if (get_option('load_static_UI') && get_option('load_static_UI') == 'true') {
                        update_option('load_static_UI','false');
                    }
                    if($active_tab == 'default') {

                        $remaining_dismissed_pointers = array_diff(mo_options_ldap_enum_pointers::$SERVICE_PROVIDER_LDAP, $Ldap_array_dissmised_pointers);
                        foreach ($remaining_dismissed_pointers as $dismissed_pointer) {
                            array_push($Ldap_array_dissmised_pointers,$dismissed_pointer);
                        }
                    }

                    else if ($active_tab == 'rolemapping') {
                        $remaining_dismissed_pointers = array_diff(mo_options_ldap_enum_pointers::$ROLE_MAPPING_LDAP, $Ldap_array_dissmised_pointers);
                        foreach ($remaining_dismissed_pointers as $dismissed_pointer) {
                            array_push($Ldap_array_dissmised_pointers,$dismissed_pointer);
                        }
                    }
                    else if ($active_tab == 'attributemapping') {
                        $remaining_dismissed_pointers = array_diff(mo_options_ldap_enum_pointers::$ATTRIBUTE_MAPPING_LDAP, $Ldap_array_dissmised_pointers);
                        foreach ($remaining_dismissed_pointers as $dismissed_pointer) {
                            array_push($Ldap_array_dissmised_pointers,$dismissed_pointer);
                        }
                    }
                    else if ($active_tab == 'config_settings') {
                        $remaining_dismissed_pointers = array_diff(mo_options_ldap_enum_pointers::$EXPORT_IMPORT_CONFIG_LDAP, $Ldap_array_dissmised_pointers);
                        foreach ($remaining_dismissed_pointers as $dismissed_pointer) {
                            array_push($Ldap_array_dissmised_pointers,$dismissed_pointer);
                        }
                    }
                }
                else {
                    if ($active_tab == 'default') {
                        $Ldap_array_dissmised_pointers = array_diff($Ldap_array_dissmised_pointers, mo_options_ldap_enum_pointers::$SERVICE_PROVIDER_LDAP);
                    }

                    else if ($active_tab == 'rolemapping') {
                        $Ldap_array_dissmised_pointers = array_diff($Ldap_array_dissmised_pointers, mo_options_ldap_enum_pointers::$ROLE_MAPPING_LDAP);
                    }
                    else if ($active_tab == 'attributemapping') {
                        $Ldap_array_dissmised_pointers = array_diff($Ldap_array_dissmised_pointers, mo_options_ldap_enum_pointers::$ATTRIBUTE_MAPPING_LDAP);
                    }
                    else if ($active_tab == 'config_settings') {
                        $Ldap_array_dissmised_pointers = array_diff($Ldap_array_dissmised_pointers, mo_options_ldap_enum_pointers::$EXPORT_IMPORT_CONFIG_LDAP);
                    }
                }
                update_user_meta($uid,'dismissed_wp_pointers',implode(",",$Ldap_array_dissmised_pointers));
                return;
            } 
			else if ($_POST['option'] == "mo_ldap_local_enable") {        //enable ldap login
                update_option('mo_ldap_local_enable_login', isset($_POST['enable_ldap_login']) ? $_POST['enable_ldap_login'] : 0);
                if (get_option('mo_ldap_local_enable_login')) {
                    update_option('mo_ldap_local_message', 'Login through your LDAP has been enabled.');
                    $this->show_success_message();
                } else {
                    update_option('mo_ldap_local_message', 'Login through your LDAP has been disabled.');
                    $this->show_success_message();
                }
            } else if($_POST['option'] == 'anonymous_bind'){
                update_option( 'mo_ldap_local_anonymous_bind', isset($_POST['anonymous_bind']) ? $_POST['anonymous_bind'] : 0);
                //var_dump(get_option('mo_ldap_local_anonymous_bind'));
                //exit();
            } else if($_POST['option'] == 'user_report_logs'){
                update_option( 'mo_ldap_local_user_report_log', isset($_POST['mo_ldap_local_user_report_log']) ? $_POST['mo_ldap_local_user_report_log'] : 0);
                $user_logs_table_exists = get_option('user_logs_table_exists');
                $user_reporting = get_option('mo_ldap_local_user_report_log');
                if($user_reporting == 1 && $user_logs_table_exists != 1) {
                    error_log("options");
                    $this->prefix_update_table();
                }
            }else if($_POST['option'] == 'keep_user_report_logs_on_unistall'){

                update_option( 'mo_ldap_local_keep_user_report_log_on_uninstall', isset($_POST['mo_ldap_local_keep_user_report_log']) ? $_POST['mo_ldap_local_keep_user_report_log'] : 0);
               

            } else if ($_POST['option'] == "mo_ldap_local_register_user") {        //enable auto registration of users
                update_option('mo_ldap_local_register_user', isset($_POST['mo_ldap_local_register_user']) ? $_POST['mo_ldap_local_register_user'] : 0);
                if (get_option('mo_ldap_local_register_user')) {
                    update_option('mo_ldap_local_message', 'Auto Registering users has been enabled.');
                    $this->show_success_message();
                } else {
                    update_option('mo_ldap_local_message', 'Auto Registering users has been disabled.');
                    $this->show_success_message();
                }
            } else if ($_POST['option'] == "mo_ldap_local_save_config") {        //save ldap configuration
				 if(isset($_POST['anonymous_bind'])){
                    update_option( 'mo_ldap_local_anonymous_bind', 1);

                }
                else
                    update_option( 'mo_ldap_local_anonymous_bind',0);
                //validation and sanitization
                $server_name = '';
                $dn = '';
                $admin_ldap_password = '';
                if (Mo_Ldap_Local_Util::check_empty_or_null($_POST['ldap_server']) || Mo_Ldap_Local_Util::check_empty_or_null($_POST['dn']) || Mo_Ldap_Local_Util::check_empty_or_null($_POST['admin_password'])) {
                    update_option('mo_ldap_local_message', 'All the fields are required. Please enter valid entries.');
                    $this->show_error_message();
                    return;
                } else {
                    $server_name = sanitize_text_field($_POST['ldap_server']);
                    $dn = sanitize_text_field($_POST['dn']);
                    $admin_ldap_password = sanitize_text_field($_POST['admin_password']);
                }

                if (!Mo_Ldap_Local_Util::is_extension_installed('openssl')) {
                    update_option('mo_ldap_local_message', 'PHP openssl extension is not installed or disabled. Please enable it first.');
                    $this->show_error_message();
                } else {
                    //Encrypting all fields and storing them
                    update_option('mo_ldap_local_server_url', Mo_Ldap_Local_Util::encrypt($server_name));
                    update_option('mo_ldap_local_server_dn', Mo_Ldap_Local_Util::encrypt($dn));
                    update_option('mo_ldap_local_server_password', Mo_Ldap_Local_Util::encrypt($admin_ldap_password));

                    delete_option('mo_ldap_local_message');
					update_option('refresh',0);
                    $mo_ldap_config = new Mo_Ldap_Local_Config();

                    $message = 'Your configuration has been saved.';
                    $status = 'success';

                    //Test connection with the LDAP configuration provided. This makes a call to check if connection is established successfully.
                    $content = $mo_ldap_config->test_connection();
                    $response = json_decode($content, true);
                    if (strcasecmp($response['statusCode'], 'SUCCESS') == 0) {
                        add_option('mo_ldap_local_message', $message . ' Connection was established successfully. Please configure LDAP User Mapping now.', '', 'no');
                        $audit_message = "Test was successful.";
                        $this->show_success_message();
                    } else if (strcasecmp($response['statusCode'], 'ERROR') == 0) {
                        add_option('mo_ldap_local_message', $response['statusMessage'], '', 'no');
                        $audit_message = "Invalid search filter or search base.";
                        $this->show_error_message();
                    } else if (strcasecmp($response['statusCode'], 'LDAP_ERROR') == 0) {
                        add_option('mo_ldap_local_message', $response['statusMessage'], '', 'no');
                        $audit_message = "LDAP extension not installed.";
                        $this->show_error_message();
                    } else if (strcasecmp($response['statusCode'], 'OPENSSL_ERROR') == 0) {
                        add_option('mo_ldap_local_message', $response['statusMessage'], '', 'no');
                        $audit_message = "OpenSSL extension not installed.";
                        $this->show_error_message();
                    } else if (strcasecmp($response['statusCode'], 'PING_ERROR') == 0) {
                        add_option('mo_ldap_local_message', $response['statusMessage'], '', 'no');
                        $audit_message = "Ping server failed " . $server_name;
                        $this->show_error_message();
                    } else {
                        add_option('mo_ldap_local_message', $message . ' There was an error in connecting with the current settings. Make sure you have entered server url in format ldap://domain.com:port. Test using Ping LDAP Server.', '', 'no');
                        $audit_message = "Invalid configuration.";
                        $this->show_error_message();
                    }


                }
            } else if ($_POST['option'] == "mo_ldap_local_save_user_mapping") {        //save user mapping configuration

                delete_option('mo_ldap_local_user_mapping_status');
                //validation and sanitization
                $dn_attribute = '';
                $search_base = '';
                $search_filter = '';
                if (Mo_Ldap_Local_Util::check_empty_or_null($_POST['search_base'])) {
                    update_option('mo_ldap_local_message', 'All the fields are required. Please enter valid entries.');
                    $this->show_error_message();
                    return;
                } else {
                    $search_base = sanitize_text_field($_POST['search_base']);
                    if (get_option('mo_ldap_local_cust', '1') == '0') {
                        if (strpos($search_base, ';')) {
                            $pricing_url = add_query_arg(array("tab" => "pricing"), $_SERVER["REQUEST_URI"]);
                            $message = 'You have entered multiple search bases. Multiple Search Bases are supported in the <b>Premium version</b> of the plugin. <a href="' . $pricing_url . '">Click here to upgrade</a> ';
                            update_option('mo_ldap_local_message', $message);
                            $this->show_error_message();
                            return;
                        }
                    }
                }

                if (!Mo_Ldap_Local_Util::is_extension_installed('openssl')) {
                    update_option('mo_ldap_local_message', 'PHP OpenSSL extension is not installed or disabled. Please enable it first.');
                    $this->show_error_message();
                } else {
                    //Encrypting all fields and storing them
                    if (!Mo_Ldap_Local_Util::check_empty_or_null($_POST['search_filter'])) {
                        $search_filter = sanitize_text_field($_POST['search_filter']);
                        $vals = explode(';', $search_filter);
                        if (count($vals) > 1) {
                            $message = 'You have entered multiple attributes for "Username Attribute" field. Logging in with multiple attributes are supported in the <b>Premium version</b> of the plugin. <a href="' . $pricing_url . '">Click here to upgrade</a> ';
                            update_option('mo_ldap_local_message', $message);
                            $this->show_error_message();
                            return;

                        } else {
                            $value_filter = '(&(objectClass=*)(' . $search_filter . '=?))';
                        }
                        update_option('Filter_search', $search_filter);
                        update_option('mo_ldap_local_search_filter', Mo_Ldap_Local_Util::encrypt($value_filter));
                    }
                    update_option('mo_ldap_local_search_base', Mo_Ldap_Local_Util::encrypt($search_base));
                    delete_option('mo_ldap_local_message');
                    $message = 'LDAP User Mapping Configuration has been saved. Please test authentication to verify LDAP User Mapping Configuration.';
                    add_option('mo_ldap_local_message', $message, '', 'no');
                    $this->show_success_message();
					update_option('import_flag', 1);
                }
            } else if ($_POST['option'] == "mo_ldap_local_test_auth") {        //test authentication with current settings
                $server_name = get_option('mo_ldap_local_server_url');
                $dn = get_option('mo_ldap_local_server_dn');
                $admin_ldap_password = get_option('mo_ldap_local_server_password');
                $search_base = get_option('mo_ldap_local_search_base');
                $search_filter = get_option('mo_ldap_local_search_filter');

                delete_option('mo_ldap_local_message');

                //validation and sanitization
                $test_username = '';
                $test_password = '';
                //Check if username and password are empty
                if (Mo_Ldap_Local_Util::check_empty_or_null($_POST['test_username']) || Mo_Ldap_Local_Util::check_empty_or_null($_POST['test_password'])) {
					$this->mo_ldap_report_update('Test Authentication ','ERROR','<strong>ERROR</strong>: All the fields are required. Please enter valid entries.');
                    add_option('mo_ldap_local_message', 'All the fields are required. Please enter valid entries.', '', 'no');
                    $this->show_error_message();
                    return;
                } //Check if configuration is saved
                else if (Mo_Ldap_Local_Util::check_empty_or_null($server_name) || Mo_Ldap_Local_Util::check_empty_or_null($dn) || Mo_Ldap_Local_Util::check_empty_or_null($admin_ldap_password) || Mo_Ldap_Local_Util::check_empty_or_null($search_base) || Mo_Ldap_Local_Util::check_empty_or_null($search_filter)) {
					$this->mo_ldap_report_update('Test authentication','ERROR','<strong>Test Authentication Error</strong>: Please save LDAP Configuration to test authentication.');
                    add_option('mo_ldap_local_message', 'Please save LDAP Configuration to test authentication.', '', 'no');
                    $this->show_error_message();
                    return;
                } else {
                    $test_username = sanitize_text_field($_POST['test_username']);
                    $test_password = sanitize_text_field($_POST['test_password']);
                }
                //Call to authenticate test
                $mo_ldap_config = new Mo_Ldap_Local_Config();
                $content = $mo_ldap_config->test_authentication($test_username, $test_password, null);
                $response = json_decode($content, true);

                if (strcasecmp($response['statusCode'], 'SUCCESS') == 0) {
                    $role_mapping_url = add_query_arg(array('tab' => 'rolemapping'), $_SERVER['REQUEST_URI']);
                    $message = 'You have successfully configured your LDAP settings.<br>
								You can now do either of two things.<br>
								1. Enable LDAP Login at the top and then <a href="' . wp_logout_url(get_permalink()) . '">Logout</a> from wordpress and login again with your LDAP credentials.<br>
								2. Do role mapping (<a href="' . $role_mapping_url . '">Click here</a>)';
                    add_option('mo_ldap_local_message', $message, '', 'no');
                    $this->show_success_message();
                } else if (strcasecmp($response['statusCode'], 'ERROR') == 0) {
					$this->mo_ldap_report_update( $_POST['test_username'],'Error','<strong>Test Authentication Error: </strong> Cannot find user <b>'.$_POST[test_username]. ' </b>in the directory.');
                    add_option('mo_ldap_local_message', $response['statusMessage'], '', 'no');
                    $this->show_error_message();
                } else if (strcasecmp($response['statusCode'], 'LDAP_ERROR') == 0) {
					$this->mo_ldap_report_update($_POST['test_username'],'Error', '<strong>Test Authentication Error: </strong>'. $response['statusMessage']);
                    add_option('mo_ldap_local_message', $response['statusMessage'], '', 'no');
                    $this->show_error_message();
                } else if (strcasecmp($response['statusCode'], 'CURL_ERROR') == 0) {
					$this->mo_ldap_report_update($_POST['test_username'],'Error','<strong>Test Authentication Error: </strong>'. $response['statusMessage']);
                    add_option('mo_ldap_local_message', $response['statusMessage'], '', 'no');
                    $this->show_error_message();
                } else if (strcasecmp($response['statusCode'], 'OPENSSL_ERROR') == 0) {
					$this->mo_ldap_report_update($_POST['test_username'],'Error','<strong>Test Authentication Error: </strong>'. $response['statusMessage']);
                    add_option('mo_ldap_local_message', $response['statusMessage'], '', 'no');
                    $this->show_error_message();
                } else if (strcasecmp($response['statusCode'], 'PING_ERROR') == 0) {
                    $this->mo_ldap_report_update($_POST['test_username'],'Error','<strong>Test Authentication Error: </strong>'. $response['statusMessage']);
					add_option('mo_ldap_local_message', $response['statusMessage'], '', 'no');
                    $this->show_error_message();
                } else {
                    $this->mo_ldap_report_update($_POST['test_username'],'Error','<strong>Test Authentication Error: </strong> There was an error processing your request. Please verify the Search Base(s) and Search filter. Your user should be present in the Search base defined.');
					add_option('mo_ldap_local_message', 'There was an error processing your request. Please verify the Search Base(s) and Search filter. Your user should be present in the Search base defined.', '', 'no');
                    $this->show_error_message();
                }
            } else if ($_POST['option'] == 'mo_ldap_local_ping_server') {
				update_option( 'mo_ldap_local_anonymous_bind', isset($_POST['anonymous_bind']) ? $_POST['anonymous_bind'] : 0);

                delete_option('mo_ldap_local_message');
                //Sanitize form fields
                $ldap_server_url = sanitize_text_field($_POST['ldap_server']);
                $mo_ldap_config = new Mo_Ldap_Local_Config();
                $response = $mo_ldap_config->ping_ldap_server($ldap_server_url);
                if (strcasecmp($response, 'SUCCESS') == 0) {
                    $status_message = "Successfully contacted LDAP Server. Please configure your Service Account now.";
                    $audit_message = "Successfully contacted LDAP Server " . $ldap_server_url;
                    add_option('mo_ldap_local_message', $status_message, '', 'no');
                    $this->show_success_message();
                } else if (strcasecmp($response, 'LDAP_ERROR') == 0) {
                    $status_message = "<a target='_blank' href='http://php.net/manual/en/ldap.installation.php'>PHP LDAP extension</a> is not installed or disabled. Please enable it.";
                    $audit_message = "LDAP extension not installed for server " . $ldap_server_url;
                    add_option('mo_ldap_local_message', 'LDAP Extension is disabled: ' . $status_message, '', 'no');
                    $this->show_error_message();
                } else {
                    $ldap_ping_url = str_replace("ldap://", "", $ldap_server_url);
                    $ldap_ping_url = str_replace("ldaps://", "", $ldap_ping_url);
                    $ldap_ping_url_array = explode(":", $ldap_ping_url);
                    if (isset($ldap_ping_url_array[0]))
                        $ldap_ping_url = $ldap_ping_url_array[0];
                    $status_message = "Error connecting to LDAP Server. Please check your LDAP server URL <b>" . $ldap_server_url . "</b>.<br>Possible reasons -<br>1. LDAP URL is typed incorrectly. Type it properly, either with IP address or with fully qualified domain name. Both should work. Eg. <b>ldap://58.64.132.235:389</b> or <b>ldap://ldap.miniorange.com:389</b>.<br>2. LDAP server is unreachable - Open a command prompt and see if you are able to ping the your LDAP server (e.g. type this command on a command prompt <b>ping " . $ldap_ping_url . "</b>. If ping is successful then only 'contact ldap server' will work.<br>3. There is a <b>firewall</b> in between - if there is a firewall, please open the firewall to allow incoming requests to your LDAP from your wordpress IP and port 389.";

                    $audit_message = "Error connecing server " . $ldap_server_url;
                    add_option('mo_ldap_local_message', $status_message, '', 'no');
                    $this->show_error_message();
                }


            }else if($_POST['option']=='mo_ldap_pass'){
                update_option( 'mo_ldap_export', isset($_POST['enable_ldap_login']) ? 1 : 0);

                if(get_option('mo_ldap_export')){
                    update_option( 'mo_ldap_local_message', 'Service account password will be exported in encrypted fashion');
                    $this->show_success_message();
                }
                else{
                    update_option( 'mo_ldap_local_message', 'Service account password will not be exported.');
                    $this->show_success_message();
                }
            } 
			else if($_POST['option']=='mo_ldap_export'){

                
                if(get_option('mo_ldap_local_server_url_status'))
                {

                    
                    $this->miniorange_ldap_export();
                }
                else{
                    update_option( 'mo_ldap_local_message', 'set the configurations of ldap first.');
                    $this->show_success_message();
                }


            } else if($_POST['option']=='enable_config'){
                update_option( 'en_save_config', isset($_POST['enable_save_config']) ? 1 : 0);
				 if(get_option('en_save_config')){
                    update_option( 'mo_ldap_local_message', 'Plugin configuration will be persisted upon uninstall.');
                    $this->show_success_message();
                }
                else{
                    update_option( 'mo_ldap_local_message', 'Plugin configuration will not be persisted upon uninstall');
                    $this->show_success_message();
                }
            }  else if ($_POST['option'] == 'reset_password') {
                $admin_email = get_option('mo_ldap_local_admin_email');
                $customer = new Mo_Ldap_Local_Customer();
                $forgot_password_response = $customer->mo_ldap_local_forgot_password($admin_email);
                if (!empty($forgot_password_response)) {
                    $forgot_password_response = json_decode($forgot_password_response,'true');
                    if ($forgot_password_response->status == 'SUCCESS') {
                        $message = 'You password has been reset successfully and sent to your registered email. Please check your mailbox.';
                        update_option('mo_ldap_local_message', $message);
                        $this->show_success_message();
                    }
                } else {
                    update_option('mo_ldap_local_message', 'Error in request');
                    $this->show_error_message();
                }
            } else if ($_POST['option'] == 'mo_ldap_local_fallback_login') {
                update_option('mo_ldap_local_enable_fallback_login', isset($_POST['mo_ldap_local_enable_fallback_login']) ? $_POST['mo_ldap_local_enable_fallback_login'] : 0);
                update_option('mo_ldap_local_message', 'Fallback login using Wordpress password enabled');
                $this->show_success_message();
            } else if ($_POST['option'] == 'mo_ldap_local_enable_admin_wp_login') {
                update_option('mo_ldap_local_enable_admin_wp_login', isset($_POST['mo_ldap_local_enable_admin_wp_login']) ? $_POST['mo_ldap_local_enable_admin_wp_login'] : 0);
                if (get_option('mo_ldap_local_enable_admin_wp_login')) {
                    update_option('mo_ldap_local_message', 'Allow administrators to login with WordPress Credentials is enabled.');
                    $this->show_success_message();
                } else {
                    update_option('mo_ldap_local_message', 'Allow administrators to login with WordPress Credentials is disabled.');
                    $this->show_error_message();
                }
            } else if ($_POST['option'] == 'mo_ldap_local_cancel') {
                delete_option('mo_ldap_local_admin_email');
                delete_option('mo_ldap_local_registration_status');
                delete_option('mo_ldap_local_verify_customer');
                delete_option('mo_ldap_local_email_count');
                delete_option('mo_ldap_local_sms_count');
            } else if ($_POST['option'] == "mo_ldap_goto_login") {
                delete_option('mo_ldap_local_new_registration');
                update_option('mo_ldap_local_verify_customer', 'true');
            } else if ($_POST['option'] == 'change_miniorange_account') {
                delete_option('mo_ldap_local_admin_customer_key');
                delete_option('mo_ldap_local_admin_api_key');
                //delete_option('mo_ldap_local_customer_token');
                delete_option('mo_ldap_local_password', '');
                delete_option('mo_ldap_local_message');
                /*update_option('mo_ldap_local_role_mapping_count', '0');
                update_option('mo_ldap_local_enable_role_mapping','0');*/
                delete_option('mo_ldap_local_cust', '0');
                delete_option('mo_ldap_local_verify_customer');
                delete_option('mo_ldap_local_new_registration');
                delete_option('mo_ldap_local_registration_status');
            } else if ($_POST['option'] == 'mo_ldap_login_send_query') {
                $email = sanitize_text_field($_POST['query_email']);
                $phone = sanitize_text_field($_POST['query_phone']);
                $query = sanitize_text_field($_POST['query']);
                $customer = new Mo_Ldap_Local_Customer();

                $submit_query_response = $customer->submit_contact_us($email, $phone, $query);
                if (!empty($submit_query_response)) {
                   if($submit_query_response === '1' ){
                        update_option('mo_ldap_local_message', 'Please let us know the issue, we will help you through out it.');
                    $this->show_error_message();
                    }
                        else{
                        update_option('mo_ldap_local_message', 'Support query successfully sent.<br>In case we dont get back to you, there might be email delivery failures. You can send us email on <a href=mailto:info@miniorange.com><b>info@miniorange.com</b></a> in that case.');
                    $this->show_success_message();
                    }
                } else {
                    update_option('mo_ldap_local_message', 'There was an error sending support query. Please us an email on <a href=mailto:info@miniorange.com><b>info@miniorange.com</b></a>.');
                    $this->show_error_message();
                }
            }


            if (isset($_POST['option']) and $_POST['option'] == 'mo_ldap_skip_feedback') {
                deactivate_plugins(__FILE__);
                update_option('mo_ldap_local_message', 'Plugin deactivated successfully');
                $this->show_success_message();
            }
            if (isset($_POST['option']) and $_POST['option'] == 'mo_ldap_feedback') {
				 if(empty($_POST['query_feedback'])) {
                    return;
                }
                $message = 'Plugin Deactivated:';
               if (trim($_POST['query_feedback']) == ''  or sizeof(array_unique(str_split($_POST['query_feedback'])))<10) {
                    update_option('mo_ldap_local_message', 'Please let us know the reason for deactivation so that we improve the user experience.');
                    $this->show_error_message();
                } else {
                    $message .= ':' . $_POST['query_feedback'];

                    $current_user = wp_get_current_user();
                    $email = get_option('mo_ldap_local_admin_email');
                    if ($email == '') {
                        $email = $current_user->user_email;
                    }
                    if (get_option('mo_ldap_local_admin_phone')) {
                        $phone = get_option('mo_ldap_local_admin_phone');
                    } else {
                        $phone = '';
                    }

                    $contact_us = new Mo_Ldap_Local_Customer();
                    $submited = $contact_us->send_email_alert($email, $phone, $message);
                    if (!empty($submited)) {
                        $submited = json_decode($submited,true);
                        if (json_last_error() == JSON_ERROR_NONE) {
                            if (is_array($submited) && array_key_exists('status', $submited) && $submited['status'] == 'ERROR') {
                                update_option('mo_ldap_local_message', $submited['message']);
                                $this->show_error_message();
                            } else {
                                if ($submited == false) {
                                    update_option('mo_ldap_local_message', "Error while submitting the query.");
                                    $this->show_error_message();
                                }
                            }
                            deactivate_plugins(__FILE__);
                            update_option('mo_ldap_local_message', "Thank you for the feedback.");
                            $this->show_success_message();
                        }
                    }
                    else {
                        update_option('mo_ldap_local_message', "Error while submitting the query.");
                        $this->show_error_message();
                    }
                }
            }
        }
    }

	function miniorange_ldap_export()
    {
        
        if (array_key_exists("option", $_POST) && $_POST['option'] == 'mo_ldap_export') {

            $tab_class_name = unserialize(Tab_ldap_Class_Names);
           
            $configuration_array = array();
            foreach ($tab_class_name as $key => $value) {
                $configuration_array[$key] = $this->mo_get_configuration_array($value);
            }
            
            header("Content-Disposition: attachment; filename=miniorange-ldap-config.json");
            echo(json_encode($configuration_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
            exit;

        }
    }
    function mo_get_configuration_array( $class_name ) {
        $class_object = call_user_func( $class_name . '::getConstants' );
        $mapping_count=get_option('mo_ldap_local_role_mapping_count');
        $mo_array = array();
        $mo_map_key= array();
        $mo_map_value=array();
        foreach ( $class_object as $key => $value ) {

            if($value=="mo_ldap_local_server_url"or $value=="mo_ldap_local_server_password" or $value=="mo_ldap_local_server_dn" or $value=="mo_ldap_local_search_base" or $value=="mo_ldap_local_search_filter")
                $flag = 1;
            else
                $flag = 0;
            if($value=="mo_ldap_local_mapping_key_")
            {
                //$map_flag_key= 1;
                for($i = 1 ; $i <= $mapping_count ; $i++){
                    $mo_map_key[ $i ] = get_option($value.$i);
                }
                $mo_option_exists = $mo_map_key;
            }
            elseif($value=="mo_ldap_local_mapping_value_")
            {
                //$map_flag_value= 1;
                for($i = 1 ; $i <= $mapping_count ; $i++){
                  $mo_map_value[ $i ] = get_option($value.$i);
                }
                $mo_option_exists = $mo_map_value;

            }
            else
                $mo_option_exists= get_option($value);

            if($mo_option_exists){
                if(@unserialize($mo_option_exists)!==false){
                    $mo_option_exists = unserialize($mo_option_exists);
                }
                if($flag==1 )
                    if($value=="mo_ldap_local_server_password" and get_option(mo_ldap_export)== '0')
                        continue;
                    else if($value=="mo_ldap_local_server_password" and get_option(mo_ldap_export)=='1' )
                        $mo_array[ $key ] = $mo_option_exists;
                    else
                        $mo_array[$key] = Mo_Ldap_Local_Util::decrypt($mo_option_exists);
                else
                    $mo_array[ $key ] = $mo_option_exists;

            }


        }
        return $mo_array;
    }
   

    function test_attribute_configuration()
    {
        if (is_user_logged_in()) {
            if (get_option('load_static_UI')) {
                update_option('load_static_UI','false');
            }
            if (current_user_can('administrator') && isset($_REQUEST['option'])) {
                if ($_REQUEST['option'] != null and $_REQUEST['option'] == 'testattrconfig') {
                    $username = $_REQUEST['user'];
                    $mo_ldap_config = new Mo_Ldap_Local_Config();
                    $mo_ldap_config->test_attribute_configuration($username);
                } else if ($_REQUEST['option'] != null and $_REQUEST['option'] == 'testrolemappingconfig') {
                    $username = $_REQUEST['user'];
                    $mo_ldap_role_mapping = new Mo_Ldap_Local_Role_Mapping();
                    $mo_ldap_role_mapping->test_configuration($username);
                } else if ($_REQUEST['option'] == 'fetchgroups') {
                    $group_search_base = $_REQUEST['searchbase'];
                    $mo_ldap_config = new Mo_Ldap_Local_Config();
                    $mo_ldap_config->fetch_groups_info($group_search_base);
                }
            }
        }
    }

    /*
     * Save all required fields on customer registration/retrieval complete.
     */
    function save_success_customer_config($id, $apiKey, $token, $message)
    {
        update_option('mo_ldap_local_admin_customer_key', $id);
        update_option('mo_ldap_local_admin_api_key', $apiKey);
        update_option('mo_ldap_local_password', '');
        update_option('mo_ldap_local_message', $message);
        update_option('mo_ldap_local_cust', '0');
        delete_option('mo_ldap_local_verify_customer');
        delete_option('mo_ldap_local_new_registration');
        delete_option('mo_ldap_local_registration_status');
        $this->show_success_message();
    }

    function mo_ldap_local_settings_style($page)
    {
		if($page != 'toplevel_page_mo_ldap_local_login'){
            return;
        }
        wp_enqueue_style( 'mo_ldap_admin_ldap_plugin_style', plugins_url( 'includes/css/mo_ldap_plugins_page.css', __FILE__ ) );
        wp_enqueue_style( 'mo_ldap_admin_settings_jquery_style', plugins_url( 'includes/css/jquery.ui.css', __FILE__ ) );
        wp_enqueue_style('mo_ldap_admin_settings_style', plugins_url('includes/css/style_settings.css', __FILE__));
        wp_enqueue_style('mo_ldap_admin_settings_phone_style', plugins_url('includes/css/phone.css', __FILE__));
        wp_enqueue_style( 'mo_ldap_admin_font_awsome', plugins_url('includes/css/font-awesome.min.css', __FILE__));
		$ldap_file = plugin_dir_path( __FILE__ ) . 'pointers_ldap.php';

        // Arguments: pointers php file, version (dots will be replaced), prefix
        $ldap_manager = new PointersManager_Ldap( $ldap_file, '4.8.52', 'custom_admin_pointers' );
        $ldap_manager->parse();
        //var_dump($ldap_manager->filter( $page ));
        $ldap_pointers = $ldap_manager->filter( $page );
        if ( empty( $ldap_pointers ) ) { // nothing to do if no pointers pass the filter
            return;
        }
		 wp_enqueue_style( 'wp-pointer' );
        $js_url = plugins_url( 'includes/js/pointers.js', __FILE__ );
        wp_enqueue_script( 'custom_admin_pointers', $js_url, array('wp-pointer'), NULL, TRUE );
        // data to pass to javascript
        $data = array(
            'next_label' => __( 'Next' ),
            'close_label' => __('Close'),
            'pointers' => $ldap_pointers
        );
        wp_localize_script('custom_admin_pointers', 'MyAdminPointers', $data);
    }

    function mo_ldap_local_settings_script()
    {
        wp_enqueue_script('mo_ldap_admin_settings_phone_script', plugins_url('includes/js/phone.js', __FILE__));
        wp_enqueue_script('mo_ldap_admin_settings_script', plugins_url('includes/js/settings_page.js', __FILE__), array('jquery'));
    }

    function error_message()
    {
        $class = "error";
        $message = get_option('mo_ldap_local_message');
        echo "<div class='" . $class . "'> <p>" . $message . "</p></div>";
    }

    function success_message()
    {
        $class = "updated";
        $message = get_option('mo_ldap_local_message');
        echo "<div class='" . $class . "'> <p>" . $message . "</p></div>";
    }

    function show_success_message()
    {
        remove_action('admin_notices', array($this, 'error_message'));
        add_action('admin_notices', array($this, 'success_message'));
    }

    function show_error_message()
    {
        remove_action('admin_notices', array($this, 'success_message'));
        add_action('admin_notices', array($this, 'error_message'));
    }

    function plugin_query_vars($vars)
    {
        $vars[] = 'app_name';
        return $vars;
    }

    function parse_sso_request($wp)
    {
        if (array_key_exists('app_name', $wp->query_vars)) {
            $redirectUrl = mo_ldap_saml_login($wp->query_vars['app_name']);
            wp_redirect($redirectUrl, 302);
            exit;
        }
    }
	function prefix_update_table() {
        // Assuming we have our current database version in a global variable
        global $prefix_my_db_version;
        // If database version is not the sam
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        error_log('Custom User Report Table  : ' . $wpdb->base_prefix);
        $sql = "CREATE TABLE if not exists`{$wpdb->base_prefix}user_report` (
			  id int NOT NULL AUTO_INCREMENT,
			  user_name varchar(50) NOT NULL,
			  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			  Ldap_status varchar(250) NOT NULL,
			  Ldap_error varchar(250) ,
			  PRIMARY KEY  (id)
			) $charset_collate;";


        if ( ! function_exists('dbDelta') ) {
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        }

        dbDelta( $sql );

        update_option( 'user_logs_table_exists', 1 );

    }

    function mo_ldap_activate()
    {
        update_option('overall_plugin_tour','true');
        ob_clean();
    }
	 function mo_ldap_report_update($username,$status,$ldapError)
    {
        if(get_option('mo_ldap_local_user_report_log')== 1){
            global $wpdb;
            $table_name = $wpdb->prefix . 'user_report';
            error_log('Activation: ' . $wpdb->base_prefix);
        $result = $wpdb->get_row("SELECT id FROM $table_name WHERE user_name ='" . $username . "'");

            $wpdb->insert(
                $table_name,
                array(
                    'user_name' => $username,
                    'time' => current_time('mysql'),
                    'Ldap_status' => $status,
                    'Ldap_error' => $ldapError
                )
            );
        }
    }


    function mo_ldap_local_uninstall()
    {
        //Delete Server configuration upon uninstall
        delete_option('mo_ldap_local_server_url');
        delete_option('mo_ldap_local_server_dn');
        delete_option('mo_ldap_local_server_password');
        delete_option('mo_ldap_local_search_filter');
        delete_option('mo_ldap_local_search_base');
        delete_option('mo_ldap_local_role_mapping_count');
    }

    function mo_ldap_local_deactivate()
    {
        //delete all stored key-value pairs
        delete_option('mo_ldap_local_message');

        delete_option('mo_ldap_local_enable_login');

        delete_option('mo_ldap_local_enable_role_mapping');
        delete_option('overall_plugin_tour');
        delete_option('load_static_UI');
        delete_user_meta(get_current_user_id(),'dismissed_wp_pointers');

    }

    function is_administrator_user($user)
    {
        $userRole = ($user->roles);
        if (!is_null($userRole) && in_array('administrator', $userRole))
            return true;
        else
            return false;
    }

}

new Mo_Ldap_Local_Login;
?>