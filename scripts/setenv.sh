#!/bin/sh
echo $PATH | egrep "/opt/wordpress/common" > /dev/null
if [ $? -ne 0 ] ; then
PATH="/opt/wordpress/apps/wordpress/bin:/opt/wordpress/varnish/bin:/opt/wordpress/sqlite/bin:/opt/wordpress/php/bin:/opt/wordpress/mysql/bin:/opt/wordpress/apache2/bin:/opt/wordpress/common/bin:$PATH"
export PATH
fi
echo $LD_LIBRARY_PATH | egrep "/opt/wordpress/common" > /dev/null
if [ $? -ne 0 ] ; then
LD_LIBRARY_PATH="/opt/wordpress/varnish/lib:/opt/wordpress/varnish/lib/varnish:/opt/wordpress/varnish/lib/varnish/vmods:/opt/wordpress/sqlite/lib:/opt/wordpress/mysql/lib:/opt/wordpress/apache2/lib:/opt/wordpress/common/lib${LD_LIBRARY_PATH:+:$LD_LIBRARY_PATH}"
export LD_LIBRARY_PATH
fi

TERMINFO=/opt/wordpress/common/share/terminfo
export TERMINFO
##### VARNISH ENV #####
		
      ##### SQLITE ENV #####
			
SASL_CONF_PATH=/opt/wordpress/common/etc
export SASL_CONF_PATH
SASL_PATH=/opt/wordpress/common/lib/sasl2 
export SASL_PATH
LDAPCONF=/opt/wordpress/common/etc/openldap/ldap.conf
export LDAPCONF
##### IMAGEMAGICK ENV #####
MAGICK_HOME="/opt/wordpress/common"
export MAGICK_HOME

MAGICK_CONFIGURE_PATH="/opt/wordpress/common/lib/ImageMagick-6.9.8/config-Q16:/opt/wordpress/common/"
export MAGICK_CONFIGURE_PATH

MAGICK_CODER_MODULE_PATH="/opt/wordpress/common/lib/ImageMagick-6.9.8/modules-Q16/coders"
export MAGICK_CODER_MODULE_PATH

##### FONTCONFIG ENV #####
FONTCONFIG_PATH="/opt/wordpress/common/etc/fonts"
export FONTCONFIG_PATH
##### PHP ENV #####
PHP_PATH=/opt/wordpress/php/bin/php
COMPOSER_HOME=/opt/wordpress/php/composer
export PHP_PATH
export COMPOSER_HOME
##### MYSQL ENV #####

##### APACHE ENV #####

##### CURL ENV #####
CURL_CA_BUNDLE=/opt/wordpress/common/openssl/certs/curl-ca-bundle.crt
export CURL_CA_BUNDLE
##### SSL ENV #####
SSL_CERT_FILE=/opt/wordpress/common/openssl/certs/curl-ca-bundle.crt
export SSL_CERT_FILE
OPENSSL_CONF=/opt/wordpress/common/openssl/openssl.cnf
export OPENSSL_CONF
OPENSSL_ENGINES=/opt/wordpress/common/lib/engines
export OPENSSL_ENGINES


. /opt/wordpress/scripts/build-setenv.sh
