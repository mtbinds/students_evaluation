<?php
/**
 * Created by PhpStorm.
 * User: miniorange
 * Date: 24-08-2018
 * Time: 02:53
 */

include "BasicEnum_Ldap.php";

class mo_options_ldap_acc_details extends BasicEnum_Ldap{
    const New_Registration = "mo_ldap_local_new_registration";
    const user_phone = 'mo_ldap_local_admin_phone';
    const local_verify = "mo_ldap_local_verify_customer";
    const admin_customer_id = "mo_ldap_local_verify_customer";
    const admin_api_key = "mo_ldap_local_admin_api_key";
    const Registration_Status = "mo_ldap_local_registration_status";
}
 class mo_options_ldap_config_details extends BasicEnum_Ldap{
     const Ldap_login_enable = "mo_ldap_local_enable_login";
     const server_url ="mo_ldap_local_server_url";
     const server_dn = "mo_ldap_local_server_dn";
     const server_password = "mo_ldap_local_server_password";
     const search_base = "mo_ldap_local_search_base";
     const search_filter ="mo_ldap_local_search_filter";
 }
 class mo_option_ldap_role_mapping extends BasicEnum_Ldap{
     const Role_mapping_enable ="mo_ldap_local_enable_role_mapping";
	 const default_mapping_value = "mo_ldap_local_mapping_value_default";
     const mapping_count ="mo_ldap_local_role_mapping_count";
     const Role_mapping_key="mo_ldap_local_mapping_key_";
     const Role_mapped_value="mo_ldap_local_mapping_value_";
	 const Group_Attribute_Name ="mo_ldap_local_mapping_memberof_attribute";
 }
 class mo_options_ldap_enum_attribute_mapping extends BasicEnum_Ldap{
    const mail ="mo_ldap_local_email_attribute";
 }
class mo_options_ldap_enum_pointers extends BasicEnum_Ldap{
    public static $SERVICE_PROVIDER_LDAP = array('custom_admin_pointers4_8_52_miniorange-support-ldap',
        'custom_admin_pointers4_8_52_miniorange-ldap-login',
		'custom_admin_pointers4_8_52_miniorange-fallback-login',
        'custom_admin_pointers4_8_52_miniorange-select-your-ldap-server',
        'custom_admin_pointers4_8_52_miniorange-ldap-anony',
        'custom_admin_pointers4_8_52_miniorange-ldap-server-username',
        'custom_admin_pointers4_8_52_miniorange-ldap-server-password',
        'custom_admin_pointers4_8_52_miniorange-ldap-search-base',
        'custom_admin_pointers4_8_52_miniorange-ldap-search-filter',
        'custom_admin_pointers4_8_52_miniorange-test-auth',
        'custom_admin_pointers4_8_52_configure-ldap-service-restart-tour',
    );
    public static $ROLE_MAPPING_LDAP = array(
        'custom_admin_pointers4_8_52_miniorange-default-role-mapping',
        'custom_admin_pointers4_8_52_miniorange-enable-role-mapping',
        'custom_admin_pointers4_8_52_role-mapping-ldap-tour',
   );
    public static $ATTRIBUTE_MAPPING_LDAP = array(
        'custom_admin_pointers4_8_52_minorange-ldap-attr-mail-map',
        'custom_admin_pointers4_8_52_miniorange-test-attr-config',
        'custom_admin_pointers4_8_52_miniorange-redirection-ldap-restart-tour');
    public static $EXPORT_IMPORT_CONFIG_LDAP = array(
        'custom_admin_pointers4_8_52_minorange-ldap-save-config',
        'custom_admin_pointers4_8_52_miniorange-ldap-export-feature',
        'custom_admin_pointers4_8_52_miniorange-redirection-ldap-config-restart-tour',

    );

    public static $LDAP_PLUGIN_TOUR = array(
        'custom_admin_pointers4_8_52_miniorange-default-tab',
        'custom_admin_pointers4_8_52_miniorange-role-mapping-tab',
        'custom_admin_pointers4_8_52_miniorange-attribute-mapping-tab',
        'custom_admin_pointers4_8_52_miniorange-configuration-settings-tab',
		'custom_admin_pointers4_8_52_miniorange-users-report-tab',
        'custom_admin_pointers4_8_52_miniorange-troubleshooting-tab',
        'custom_admin_pointers4_8_52_miniorange-account-setup-tab',
        'custom_admin_pointers4_8_52_miniorange-feature-request-tab',
        'custom_admin_pointers4_8_52_miniorange-licensing-tab',
        'custom_admin_pointers4_8_52_miniorange-restart-plugin-tour'
    );
}
