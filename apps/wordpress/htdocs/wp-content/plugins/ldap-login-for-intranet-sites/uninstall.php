<?php
if(get_option('en_save_config') == 0) {
	delete_option('mo_ldap_local_admin_email');
	delete_option('mo_ldap_local_host_name');
	delete_option('mo_ldap_local_default_config');
	delete_option('mo_ldap_local_password');
	delete_option('mo_ldap_local_new_registration');
	delete_option('mo_ldap_local_admin_phone');
	delete_option('mo_ldap_local_verify_customer');
	delete_option('mo_ldap_local_admin_customer_key');
	delete_option('mo_ldap_local_admin_api_key');
	delete_option('mo_ldap_local_customer_token');
	delete_option('mo_ldap_local_message');
	delete_option('mo_ldap_local_registration_status');
	
	delete_option('mo_ldap_local_enable_login');
	delete_option('mo_ldap_local_enable_log_requests');
	delete_option('mo_ldap_local_server_url');
	delete_option('mo_ldap_local_server_dn');
	delete_option('mo_ldap_local_server_password');
	delete_option('mo_ldap_local_search_base');
	delete_option('mo_ldap_local_search_filter');

    $role_mapping_count = get_option('mo_ldap_local_role_mapping_count');
    for($i=1;$i<=$role_mapping_count;$i++) {
        delete_option('mo_ldap_local_mapping_key_' . $i);
        delete_option('mo_ldap_local_mapping_value_' . $i);
    }

	delete_option('mo_ldap_local_role_mapping_count');
	delete_option('mo_ldap_local_mapping_value_default');
    delete_option('mo_ldap_local_enable_role_mapping');

	delete_option('mo_ldap_local_server_url_status');
	delete_option('mo_ldap_local_service_account_status');
	delete_option('mo_ldap_local_user_mapping_status');
	delete_option('mo_ldap_local_username_status');
	
	delete_option('mo_ldap_local_admin_fname');
	delete_option('mo_ldap_local_admin_lname');
	delete_option('mo_ldap_local_company');
    delete_option('overall_plugin_tour');
    delete_option('load_static_UI');

	}	
	if(get_option('mo_ldap_local_keep_user_report_log_on_uninstall')==0){
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_report';
    error_log('deactivation: ' . $wpdb->base_prefix);
    // drop the table from the database.
    $wpdb->query( "DROP TABLE IF EXISTS $table_name" );

    delete_option('user_logs_table_exists');
    delete_option('mo_ldap_local_user_report_log');

}
?>