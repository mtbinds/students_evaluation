#!/bin/sh
LDFLAGS="-L/opt/wordpress/common/lib $LDFLAGS"
export LDFLAGS
CFLAGS="-I/opt/wordpress/common/include/ImageMagick -I/opt/wordpress/common/include $CFLAGS"
export CFLAGS
CXXFLAGS="-I/opt/wordpress/common/include $CXXFLAGS"
export CXXFLAGS
		    
PKG_CONFIG_PATH="/opt/wordpress/common/lib/pkgconfig"
export PKG_CONFIG_PATH
