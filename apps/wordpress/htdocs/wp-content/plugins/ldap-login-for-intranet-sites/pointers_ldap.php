<?php

require_once "mo_ldap_pages.php";

$pointers = array();
$tab= 'default';

if (get_option('overall_plugin_tour') && get_option('overall_plugin_tour')=='true') {

    $pointers['miniorange-default-tab'] = array(
        'title' => sprintf('<h3>%s</h3>', esc_html__('LDAP Configuration')),
        'content' => sprintf('<p>%s</p>', esc_html__('Here you can configure the LDAP connection and user search. You can test the configuration as well.')),
        'anchor_id' => '#ldap_default_tab_pointer',
        'edge' => 'left',
        'align' => 'right',
        'where' => array('toplevel_page_mo_ldap_local_login') // <-- Please note this
    );

    $pointers['miniorange-role-mapping-tab'] = array(
        'title' => sprintf('<h3>%s</h3>', esc_html__('Role Mapping')),
        'content' => sprintf('<p>%s</p>', esc_html__('Here you can define the site access level for the user based on the LDAP security groups')),
        'anchor_id' => '#ldap_role_mapping_tab_pointer',
        'edge' => 'left',
        'align' => 'right',
        'where' => array('toplevel_page_mo_ldap_local_login') // <-- Please note this
    );

    $pointers['miniorange-attribute-mapping-tab'] = array(
        'title' => sprintf('<h3>%s</h3>', esc_html__('Attribute Mapping')),
        'content' => sprintf('<p>%s</p>', esc_html__('Here you can map the different LDAP attributes with the wordpress user profile fields')),
        'anchor_id' => '#ldap_attribute_mapping_tab_pointer',
        'edge' => 'left',
        'align' => 'right',
        'where' => array('toplevel_page_mo_ldap_local_login') // <-- Please note this
    );

    $pointers['miniorange-configuration-settings-tab'] = array(
        'title' => sprintf('<h3>%s</h3>', esc_html__('Configuration settings')),
        'content' => sprintf('<p>%s</p>', esc_html__('Export the plugin configuration to send to us for debugging purposes.')),
        'anchor_id' => '#ldap_config_settings_tab_pointer',
        'edge' => 'left',
        'align' => 'right',
        'where' => array('toplevel_page_mo_ldap_local_login') // <-- Please note this
    );
	 $pointers['miniorange-users-report-tab'] = array(
        'title' => sprintf('<h3>%s</h3>', esc_html__('Logs')),
        'content' => sprintf('<p>%s</p>', esc_html__('Here you can get the Users Logs.')),
        'anchor_id' => '#ldap_User_Report_tab_pointer',
        'edge' => 'left',
        'align' => 'right',
        'where' => array('toplevel_page_mo_ldap_local_login') // <-- Please note this
    );

    $pointers['miniorange-troubleshooting-tab'] = array(
        'title' => sprintf('<h3>%s</h3>', esc_html__('Troubleshooting')),
        'content' => sprintf('<p>%s</p>', esc_html__('Troubleshoot common issues faced during configuration of the plugin')),
        'anchor_id' => '#ldap_troubleshooting_tab_pointer',
        'edge' => 'left',
        'align' => 'right',
        'where' => array('toplevel_page_mo_ldap_local_login') // <-- Please note this
    );

    $pointers['miniorange-feature-request-tab'] = array(
        'title' => sprintf('<h3>%s</h3>', esc_html__('Feature Request/Contact Us')),
        'content' => sprintf('<p>%s</p>', esc_html__('Not found What you want, You can share more details like What feature are you looking for, in the plugin.  We can also add custom features on request for users.
        Facing any issues? Get in touch with us and we will help you setup the plugin in no time.')),
        'anchor_id' => '#ldap_feature_request_tab_pointer',
        'edge' => 'left',
        'align' => 'right',
        'where' => array('toplevel_page_mo_ldap_local_login') // <-- Please note this
    );

    $pointers['miniorange-account-setup-tab'] = array(
        'title' => sprintf('<h3>%s</h3>', esc_html__('Account setup (Registration is optional)')),
        'content' => sprintf('<p>%s</p>', esc_html__('Here You can register/login with miniOrange. It can be helpful to you to get the support from us. You will also need a miniOrange account to upgrade to the premium version of the plugins.')),
        'anchor_id' => '#ldap_account_setup_tab_pointer',
        'edge' => 'left',
        'align' => 'right',
        'where' => array('toplevel_page_mo_ldap_local_login') // <-- Please note this
    );

    $pointers['miniorange-licensing-tab'] = array(
        'title' => sprintf('<h3>%s</h3>', esc_html__('Licensing')),
        'content' => sprintf('<p>%s</p>', esc_html__('Check out the different features offered in our premium versions.')),
        'anchor_id' => '#license_upgrade',
        'edge' => 'left',
        'align' => 'right',
        'where' => array('toplevel_page_mo_ldap_local_login') // <-- Please note this
    );

    $pointers['miniorange-restart-plugin-tour'] = array(
        'title' => sprintf('<h3>%s</h3>', esc_html__('Click when you need to restart this tour')),
        'content' => sprintf('<p>%s</p>', esc_html__('Revisit plugin tour')),
        'anchor_id' => '#configure-restart-plugin-tour',
        'edge' => 'right',
        'align' => 'left',
        'where' => array('toplevel_page_mo_ldap_local_login') // <-- Please note this
    );

    update_option('overall_plugin_tour','false');
}
else {
    if (array_key_exists('tab', $_GET))
        $tab = $_GET['tab'];
    if ($tab == 'default') {
        $pointers['miniorange-support-ldap'] = array(
            'title' => sprintf('<h3>%s</h3>', esc_html__('We are here!')),
            'content' => sprintf('<p>%s</p>', esc_html__('Get in touch with us and we will help you setup the plugin in no time.')),
            'anchor_id' => '#mo_ldap_support_layout_ldap',
            'edge' => 'right',
            'align' => 'left',
            'where' => array('toplevel_page_mo_ldap_local_login') // <-- Please note this
        );

        $pointers['miniorange-select-your-ldap-server'] = array(
            'title' => sprintf('<h3>%s</h3>', esc_html__('Directory Server connections')),
            'content' => sprintf('<p>%s</p>', esc_html__('Enter the URL or IP address of the directory server along with port to allow plugin to connect.')),
            'anchor_id' => '#ldap_server_url_pointer',
            'edge' => 'left',
            'align' => 'left',
            'where' => array('toplevel_page_mo_ldap_local_login') // <-- Please note this
        );
        /*  $pointers['miniorange-ldap-anony'] = array(
              'title'     => sprintf( '<h3>%s</h3>', esc_html__( 'Ldap Server anony connections' ) ),
              'content'   => sprintf( '<p>%s</p>', esc_html__( 'Enter the Ldap credentials to get connect to LDAP server.' ) ),
              'anchor_id' => '#ldap_anony',
              'edge'      => 'left',
              'align'     => 'left',
              'where'     => array( 'toplevel_page_mo_ldap_local_login' ) // <-- Please note this
          );*/
        $pointers['miniorange-ldap-server-username'] = array(
            'title' => sprintf('<h3>%s</h3>', esc_html__('Directory Service Account Name')),
            'content' => sprintf('<p>%s</p>', esc_html__('Enter the username of Directory Service account which will be used to establish connection.')),
            'anchor_id' => '#ldap_server_username',
            'edge' => 'left',
            'align' => 'left',
            'where' => array('toplevel_page_mo_ldap_local_login') // <-- Please note this
        );
        $pointers['miniorange-ldap-server-password'] = array(
            'title' => sprintf('<h3>%s</h3>', esc_html__('Service Account Password')),
            'content' => sprintf('<p>%s</p>', esc_html__('Enter the password of Directory Service Account')),
            'anchor_id' => '#ldap_server_password',
            'edge' => 'left',
            'align' => 'left',
            'where' => array('toplevel_page_mo_ldap_local_login') // <-- Please note this
        );

        $pointers['miniorange-ldap-search-base'] = array(
            'title' => sprintf('<h3>%s</h3>', esc_html__('Search Base')),
            'content' => sprintf('<p>%s</p>', esc_html__('Enter the distinguished name of Directory Container which contains all the users who will authenticate to the site.')),
            'anchor_id' => '#search_base_ldap',
            'edge' => 'left',
            'align' => 'left',
            'where' => array('toplevel_page_mo_ldap_local_login') // <-- Please note this
        );
        $pointers['miniorange-ldap-search-filter'] = array(
            'title' => sprintf('<h3>%s</h3>', esc_html__('Username Attribute')),
            'content' => sprintf('<p>%s</p>', esc_html__('Enter the LDAP attribute which will be used by Directory users to login.')),
            'anchor_id' => '#search_filter_ldap',
            'edge' => 'left',
            'align' => 'left',
            'where' => array('toplevel_page_mo_ldap_local_login') // <-- Please note this
        );
        $pointers['miniorange-test-auth'] = array(

            'title' => sprintf('<h3>%s</h3>', esc_html__('Test Authentication')),
            'content' => sprintf('<p>%s</p>', esc_html__('Check the user authentication by entering the user credentials. Use the configured username attribute for testing')),
            'anchor_id' => '#Test_auth_ldap',
            'edge' => 'left',
            'align' => 'left',
            'where' => array('toplevel_page_mo_ldap_local_login') // <-- Please note this
        );
        $pointers['miniorange-ldap-login'] = array(
            'title' => sprintf('<h3>%s</h3>', esc_html__('Enable login')),
            'content' => sprintf('<p>%s</p>', esc_html__('Enable authentication with Directory credentials')),
            'anchor_id' => '#enable_ldap_login_bckgrnd',
            'edge' => 'left',
            'align' => 'left',
            'where' => array('toplevel_page_mo_ldap_local_login') // <-- Please note this
        );

        $pointers['miniorange-fallback-login'] = array(
            'title' => sprintf('<h3>%s</h3>', esc_html__('Enable WordPress login for Administrators')),
            'content' => sprintf('<p>%s</p>', esc_html__('Enable to allow Administrators to log in with their WordPress credentials')),
            'anchor_id' => '#miniorange-fallback-login',
            'edge' => 'left',
            'align' => 'left',
            'where' => array('toplevel_page_mo_ldap_local_login') // <-- Please note this
        );


        $pointers['configure-ldap-service-restart-tour'] = array(
            'title' => sprintf('<h3>%s</h3>', esc_html__('Click when you need me!')),
            'content' => sprintf('<p>%s</p>', esc_html__('Revisit tour')),
            'anchor_id' => '#configure-service-restart-tour',
            'edge' => 'left',
            'align' => 'left',
            'where' => array('toplevel_page_mo_ldap_local_login') // <-- Please note this
        );

    }

    if ($tab == 'config_settings') {
        $pointers['minorange-ldap-save-config'] = array(
            'title' => sprintf('<h3>%s</h3>', esc_html__('Save Config')),
            'content' => sprintf('<p>%s</p>', esc_html__('Enabling it will make sure that the plugin configurations are not deleted when plugin is uninstalled')),
            'anchor_id' => '#enable_save_config_ldap',
            'edge' => 'left',
            'align' => 'left',
            'where' => array('toplevel_page_mo_ldap_local_login') // <-- Please note this
        );
        $pointers['miniorange-ldap-export-feature'] = array(
            'title' => sprintf('<h3>%s</h3>', esc_html__('Export configuration')),
            'content' => sprintf('<p>%s</p>', esc_html__('If you are having trouble setting up the plugin, click here to export the configurations and mail it to us at info@miniorange.com.')),
            'anchor_id' => '#mo_export',
            'edge' => 'left',
            'align' => 'left',
            'where' => array('toplevel_page_mo_ldap_local_login') // <-- Please note this
        );
        $pointers['miniorange-redirection-ldap-config-restart-tour'] = array(
            'title' => sprintf('<h3>%s</h3>', esc_html__('Click when you need me!')),
            'content' => sprintf('<p>%s</p>', esc_html__('Revisit tour')),
            'anchor_id' => '#export-config-service-restart-tour',
            'edge' => 'left',
            'align' => 'left',
            'where' => array('toplevel_page_mo_ldap_local_login') // <-- Please note this
        );
    }
}
return $pointers;