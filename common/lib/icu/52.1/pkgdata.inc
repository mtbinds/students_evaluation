GENCCODE_ASSEMBLY_TYPE=-a gcc
SO=so
SOBJ=so
A=a
LIBPREFIX=lib
LIB_EXT_ORDER=.52.1
COMPILE=gcc -DAI_ADDRCONFIG=0 -I/bitnami/lamp72stack-linux-x64/output/sqlite/include -I/opt/wordpress/common/include -I/opt/wordpress/common/include/sasl -I/opt/wordpress/common/include -D_REENTRANT  -DU_HAVE_ELF_H=1 -DU_HAVE_ATOMIC=1  -DU_ATTRIBUTE_DEPRECATED= -I/opt/wordpress/common/include -fPIC -m64 -std=c99 -Wall -pedantic -Wshadow -Wpointer-arith -Wmissing-prototypes -Wwrite-strings   -c
LIBFLAGS=-I/opt/wordpress/common/include -DPIC -fPIC
GENLIB=gcc -I/opt/wordpress/common/include -fPIC -m64 -std=c99 -Wall -pedantic -Wshadow -Wpointer-arith -Wmissing-prototypes -Wwrite-strings   -L/bitnami/lamp72stack-linux-x64/output/sqlite/lib -L/opt/wordpress/common/lib  -shared -Wl,-Bsymbolic
LDICUDTFLAGS=-nodefaultlibs -nostdlib
LD_SONAME=-Wl,-soname -Wl,
RPATH_FLAGS=
BIR_LDFLAGS=-Wl,-Bsymbolic
AR=ar
ARFLAGS=r
RANLIB=ranlib
INSTALL_CMD=/bin/install -c
