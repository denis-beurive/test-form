DIR := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))

BOWER         := /usr/local/bin/bower
COMPOSER      := php /opt/local/bin/composer.phar
PHPDOCUMENTOR := /usr/local/bin/phpdocumentor.phar

install:
	cd $(DIR)/www && $(BOWER) install

