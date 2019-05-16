=== Active Directory Integration / LDAP Integration ===
Contributors: miniOrange
Donate link: https://miniorange.com
Tags: active directory, ldap, authentication, ldap authentication, active directory integration, AD, ldap login, ldap sso, AD sso, AD authentication, active directory authentication, ldap single sign on, ad single sign on, ad login, active directory single sign on, openldap login, login form, user login, login, WordPress login,adfs, Active Directory SSO, LDAP SSO, security, authorization, auth
Requires at least: 2.0.2
Tested up to: 5.2
Stable tag: 3.0.9
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Active Directory Integration / LDAP Integration for Intranet sites supports login using credentials stored in Active Directory, OpenLDAP, OpenDS and directory systems. ACTIVE SUPPORT PROVIDED.

== Description ==

Active Directory Integration / LDAP Integration for Intranet sites plugin provides login to WordPress using credentials stored in your LDAP Server. It allows users to authenticate against various LDAP implementations like Microsoft Active Directory, OpenLDAP and other directory systems. We support user management features such as creating users not present in WordPress from LDAP Server, adding users, editing users and so on through additional add-ons. User information is in sync with the information in LDAP. This plugin is free to use under the GNU/GPLv2 license. If you wish to use enhanced features, then there is a provision to upgrade as well. There is also a provision to use our services to deploy and configure this plugin.

= Free Version Features :- =

*	Login to WordPress using your LDAP credentials ( Additionally login with WordPress credentials supported if enabled )
*	Automatic user registration after login if the user is not already registered with your site.
*	Keep user profile information in sync with LDAP upon authentication.
*	Uses LDAP or LDAPS for secure connection to your LDAP Server.
*	Test connection to your LDAP server.
*	Test authentication using credentials stored in your LDAP server.
*	Ability to test against demo LDAP server and demo credentials.


= Premium Version Features (Check out the Licensing tab to know more):- =

*	<b>Multiple Search Containers: </b>Authenticate users against multiple search bases.
*	<b>Role Mapping: </b>Mapping of LDAP groups to WordPress Roles upon authentication.
*	<b>Multiple Username Attributes: </b>Authenticate users against multiple user attributes like uid, cn, mail, sAMAccountName.
*	<b>Fallback Login: </b>Fallback to local password in case LDAP is unreacheable.
*	<b>Multisite support: </b> Available as a separate plugin
*   <b>Add-ons: </b>Add-ons for Integrations with plugins like Buddypress, WP User Manager Gravity Forms etc available. Contact Us if you need such integrations.
*   <b>Profile Sync: </b>Sync LDAP Profile with WordPress. (Available as an add-on)
*   <b>Outbound LDAP Password Sync: </b> Available as an add-on
*   <b>Brute Force Protection: </b>Available as an add-on
*   <b>Failed Logon Notifications: </b>User/Admin email notification on failed logon attempt. Contact us in case you require this functionality. Available as an add-on
*   <b>Profile Photos Sync: </b>Sync Profile Photos with WordPress. Available as an add-on
*   <b>Single Sign-On: <b>If you are looking for Single-Sign-On in addition to authentication with AD/LDAP and do not have any Identity Provider Yet. You can try out <a href="https://idp.miniorange.com">miniOrange On-Premise IdP</a>.

= Add-ons List :- =

*   Buddypress Extended Profiles integration add-on: Sync BuddyPress Extended Profiles  with information from LDAP.
*   Directory Sync add-on: Sync users and user information from LDAP.
*   Kerberos/NTLM SSO add-on: Allow auto-login into website from a system joined to Active Directory domain.
*   BuddyPress Groups add-on: Assign BuddyPress groups to users based on LDAP group membership.
*   LDAP Search Widget add-on: Search interface to display user information from LDAP.
*   Gravity Forms add-on: Populate Gravity Forms with information from LDAP.
*   eMember add-on: Login to eMember profiles with LDAP Credentials.

= Why the free plugins are not sufficient? :- =
*    With authentication being one of the essential functions of the day, a fast and <b>priority support</b> (provided in paid versions) ensure that any issues you face on a live production site can be resolved in a timely manner.
*   <b>Regular updates</b> to the premium plugin compatible with the latest WordPress version. The updates include security and bug fixes. These updates <b>ensure that you are updated with the latest security fixes</b>.
*   Ensure timely update for <b>new WordPress/PHP releases</b> with our premium plugins and compatibility updates to make sure you have adequate support for smooth transitions to new versions for WordPress and PHP.
*   <b>Reasonably priced</b> with various plans tailored to suit your needs.
*   <b>Easy to setup</b> with lots of support and documentation to assist with the setup.
*   High level of <b>customization</b> and <b>add-ons</b> to support specific requirements.


= Need support? =
Please email us at info@miniorange.com or <a href="https://miniorange.com/contact" target="_blank">Contact us</a>

== Installation ==

= From your WordPress dashboard =
1. Visit `Plugins > Add New`
2. Search for `Active Directory Integration for Intranet sites`. Find and Install `Active Directory Integration for Intranet sites`
3. Activate the plugin from your Plugins page

= From WordPress.org =
1. Download Active Directory Integration for Intranet sites.
2. Unzip and upload the `ldap-login-for-intranet-sites` directory to your `/wp-content/plugins/` directory.
3. Activate Active Directory Integration for Intranet sites from your Plugins page.

= Once Activated =
1. Go to `Settings-> LDAP Login Config`, and follow the instructions.
2. Click on `Save`

Make sure that if there is a firewall, you `OPEN THE FIREWALL` to allow incoming requests to your LDAP from your WordPress Server IP and open port 389(636 for SSL or ldaps).

== Frequently Asked Questions ==


= I am not able to get the configuration right. =
Make sure that if there is a firewall, you `OPEN THE FIREWALL` to allow incoming requests to your LDAP from your WordPress Server IP and open port 389(636 for SSL or ldaps). For further help please click on the Troubleshooting tab where you can find detailed description for each configuration. If that does not help, please check the format of example settings beside each text box.

= I am locked out of my account and can't login with either my WordPress credentials or LDAP credentials. What should I do? =
Firstly, please check if the `user you are trying to login with` exists in your WordPress. To unlock yourself, rename ldap-login-for-intranet-sites plugin name. You will be able to login with your WordPress credentials. After logging in, rename the plugin back to ldap-login-for-intranet-sites. If the problem persists, `activate, deactivate and again activate` the plugin.

= For support or troubleshooting help =
Please email us at info@miniorange.com or <a href="https://miniorange.com/contact" target="_blank">Contact us</a>.


== Screenshots ==

1. Configure LDAP plugin
2. LDAP Groups to WordPress Users Role Mapping
3. User Attributes Mapping between LDAP and WP

== Changelog ==

= 3.0.9 =
Audit logs for authentication
Compatibility to WordPress 5.2
Bug Fixes and Improvements.

= 3.0.8 =
Bug Fixes and Improvements.

= 3.0.7 =
Bug Fixes and Improvements.

= 3.0.6 =
Multisite upgrade links added.

= 3.0.5 =
Bug Fixes and Improvement.

= 3.0.4 =
Bug Fixes and Improvement.

= 3.0.3 =
Bug Fixes and Improvement.

= 3.0.2 =
Improved Visual Tour
Added tab for making feature requests
Made registration optional
Listed add-ons in licensing plans.

= 3.0.1 =
Support for PHP version > 5.3
Wordpress 5.0.1 Compatibility

= 3.0 =
Added Visual Tour

= 2.92 =
Role Mapping bug fixes

= 2.91 =
Usability fixes
Bug fixes
Licensing page revamp

= 2.9 =
Usability fixes

= 2.8.3 =
Added Feedback Form

2.8
Removed MCrypt dependency. Bug fixes

2.7.7
Phone number visible in profile

2.7.6
Compatible with WordPress 4.9.4 and removed external links

= 2.7.43 =
On-premise IdP information

= 2.7.42 =
WordPress 4.9 Compatibility

= 2.7.4 =
Fix for login with username/email

= 2.7.3 =
Additional feature links.

= 2.7.2 =
Licensing fixes.

= 2.7.1 =
Activation warning fix. Basic registration fields required for upgrade.

= 2.7 =
Registration removal, role mapping fixes and username attribute configurable.

= 2.6.6 =
Updating Plugin Title

= 2.6.5 =
Licensing fix

= 2.6.4 =
Name fixes

= 2.6.2 =
Name changed

= 2.6.1 =
Added TLS support

= 2.5.8 =
Increased priority for authentication hook

= 2.5.7 =
Licensing fixes

= 2.5.6 =
WordPress 4.6 Compatibility


= 2.5.5 =
Added option to authenticate Administrators from both LDAP and WordPress

= 2.5.4 =
More page fixes


= 2.5.3 =
Page fixes

= 2.5.2 =
Registration fixes

= 2.5.1 =
*	UI improvement and fix for WP 4.5

= 2.5 =
Added more descriptive error messages and licensing plans updated.

= 2.3 =
Support for Integrated Windows Authentication - contact info@miniorange.com if interested

= 2.2 =
+Added alternate verification method for user activation.

= 2.1 =
+Minor Bug fixes.

= 2.0 =
Attribute Mapping and Role Mapping Bug fixes and Enhancement.

= 1.9 =
Attribute Mapping bug fixes

= 1.8 =
Role Mapping Bug fixes

= 1.7 =
Fallback to local password in case LDAP server is unreacheable.

= 1.6 =
Added attribute mapping and custom profile fields from LDAP.

= 1.5 =
Added mutiple role support in WP users to LDAP Group Role Mapping.

= 1.4 =
Improved encryption to support special characters.

= 1.3 =
Enhanced Usability and UI for the plugin.

= 1.2 =
Added LDAP groups to WordPress Users Role Mapping

= 1.1 =
Enhanced Troubleshooting

= 1.0 =
* this is the first release.

== Upgrade Notice ==

= 3.0.9 =
Audit logs for authentication
Compatibility to WordPress 5.2
Bug Fixes and Improvements.

= 3.0.8 =
Bug Fixes and Improvements.

= 3.0.7 =
Bug Fixes and Improvements.

= 3.0.6 =
Multisite upgrade links added.

= 3.0.5 =
Bug Fixes and Improvement.

= 3.0.4 =
Bug Fixes and Improvement.

= 3.0.3 =
Bug Fixes and Improvement.

= 3.0.2 =
Improved Visual Tour
Added tab for making feature requests
Made registration optional
Listed add-ons in licensing plans.

= 3.0.1 =
Support for PHP version > 5.3
Wordpress 5.0.1 Compatibility

= 3.0 =
Added Visual Tour

= 2.92 =
Role Mapping bug fixes

= 2.91 =
Usability fixes
Bug fixes
Licensing page revamp

= 2.9 =
Usability fixes

= 2.8.3 =
Added Feedback Form

2.8
Removed MCrypt dependency. Bug fixes

2.7.7
Phone number visible in profile

2.7.6
Compatible with WordPress 4.9.4 and removed external links

= 2.7.43 =
On-premise IdP information

= 2.7.42 =
WordPress 4.9 Compatibility

= 2.7.4 =
Fix for login with username/email

= 2.7.3 =
Additional feature links.

= 2.7.2 =
Licensing fixes.

= 2.7.1 =
Activation warning fix. Basic registration fields required for upgrade.

= 2.7 =
Registration removal, role mapping fixes and username attribute configurable.

= 2.6.5 =
Licensing fix

= 2.6.4 =
Name fixes

= 2.6.2 =
Name changed

= 2.6.1 =
Added TLS support

= 2.5.8 =
Increased priority for authentication hook

= 2.5.7 =
Licensing fixes

= 2.5.6 =
WordPress 4.6 Compatibility

= 2.5.5 =
Added option to authenticate Administrators from both LDAP and WordPress

= 2.5.4 =
More page fixes

= 2.5.3 =
Page fixes

= 2.5.2 =
Registration fixes

= 2.5.1 =
*	UI improvement and fix for WP 4.5

= 2.5 =
Added more descriptive error messages and licensing plans updated.

= 2.3 =
Support for Integrated Windows Authentication - contact info@miniorange.com if interested

= 2.2 =
+Added alternate verification method for user activation.

= 2.1 =
+Minor Bug fixes.

= 2.0 =
Attribute Mapping and Role Mapping Bug fixes and Enhancement.

= 1.9 =
Attribute Mapping bug fixes

= 1.8 =
Role Mapping Bug fixes

= 1.7 =
Fallback to local password in case LDAP server is unreacheable.

= 1.6 =
Added attribute mapping and custom profile fields from LDAP .

= 1.5 =
Added mutiple role support in WP users to LDAP Group Role Mapping .

= 1.4 =
Improved encryption to support special characters.

= 1.3 =
Enhanced Usability and UI for the plugin.

= 1.2 =
Added LDAP groups to WordPress Users Role Mapping

= 1.1 =
Enhanced Troubleshooting

= 1.0 =
First version of plugin.