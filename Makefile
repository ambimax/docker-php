SHELL := /bin/bash
PWD := $(shell cd -P -- '$(shell dirname -- "$0")' && pwd -P)

.PHONY: help build
.DEFAULT_GOAL := help


help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

# ----------------------------------------------------------------------------------------------------------------
setup:
	curl -O https://orca-build.io/downloads/orca.zip
	unzip -o orca.zip
	rm -f orca.zip

generate: prepare ## Generates all artifacts for this image
	docker run -v ${PWD}:/opt/project orcabuilder/orca:latest
	@php generateReadme.php
	$(MAKE) prettier

prettier:
	@echo "Run prettier"
	@npx prettier --write .

##################################################
# Matrix build
#
# Examples:
#   make VERSION=8.1 VARIANT=alpine3.17 build
#   make VERSION=8.2 VARIANT=bullseye test
#
##################################################
VERSION?=8.2
VARIANT?=bullseye

prepare: ## Create missing files for new variants
	test -d template/components/php/$(VERSION)/assets || mkdir -p template/components/php/$(VERSION)/assets
	test -f template/components/php/$(VERSION)/assets/all.nonempty.env || touch template/components/php/$(VERSION)/assets/all.nonempty.env
	test -f template/components/php/$(VERSION)/assets/modules.list || touch template/components/php/$(VERSION)/assets/modules.list
	test -d template/assets/config/php/$(VERSION)/conf.d || mkdir -p template/assets/config/php/$(VERSION)/conf.d
	test -f template/assets/config/php/$(VERSION)/conf.d/php.ini || touch template/assets/config/php/$(VERSION)/conf.d/php.ini

build: generate ## Build variant (set env vars VERSION and VARIANT)
	(cd dist/images/$(VERSION)/$(VARIANT)/ && make build )

force-build: generate ## Build variant (set env vars VERSION and VARIANT)
	(cd dist/images/$(VERSION)/$(VARIANT)/ && make force-build )

copybuild: generate ## Build image, copy files and rebuild with new files (set env vars VERSION and VARIANT)
	(cd dist/images/$(VERSION)/$(VARIANT)/ && make build )
	$(MAKE) copy
	(cd dist/images/$(VERSION)/$(VARIANT)/ && make build )

start: ## Start variant (set env vars VERSION and VARIANT)
	(cd dist/images/$(VERSION)/$(VARIANT)/ && docker-compose up -d --remove-orphans )

stop: ## Stop variant (set env vars VERSION and VARIANT)
	(cd dist/images/$(VERSION)/$(VARIANT)/ && docker-compose down -v )

enter: start ## Enter fpm bash of variant (set env vars VERSION and VARIANT)
	(cd dist/images/$(VERSION)/$(VARIANT)/ && docker-compose exec -e TERM=xterm-256color fpm bash )

enter-nginx: start ## Enter nginx sh of variant (set env vars VERSION and VARIANT)
	(cd dist/images/$(VERSION)/$(VARIANT)/ && docker-compose exec nginx sh )

test:  ## Structure test variant (set env vars VERSION and VARIANT)
	(cd dist/images/$(VERSION)/$(VARIANT)/ && make test)

simple-test: ## Test env variables
	docker container run --rm \
		-e PHP_ERROR_REPORTING=-1 \
		-e PHP_DISPLAY_ERRORS=Off \
		-e "PHP_DATE_TIMEZONE=Europe/Berlin" \
		-e "PHP_OPCACHE_ERROR_LOG=/var/www/my.log" \
		ambimax/php-$(VERSION)-$(VARIANT):latest \
		php -i | egrep 'error_reporting|display_errors|date.timezone|opcache.error_log'

	@echo ""
	docker container run --rm ambimax/php-$(VERSION)-$(VARIANT):latest cat /usr/local/etc/php/conf.d/date.ini

	@echo ""
	docker container run --rm \
		-e PHP_ERROR_REPORTING=-1 \
		-e PHP_DISPLAY_ERRORS=Off \
		-e "PHP_DATE_TIMEZONE=Europe/Berlin" \
		-e "PHP_OPCACHE_ERROR_LOG=/var/www/my.log" \
		ambimax/php-$(VERSION)-$(VARIANT):latest \
		php -r 'phpinfo();' | egrep 'error_reporting|display_errors|date.timezone|opcache.error_log'

copy: prepare ## Copy default ENVs from variant for generation (set env vars VERSION and VARIANT)
	docker run --rm -v $(PWD):/config ambimax/php-$(VERSION)-$(VARIANT):latest bash -c \
		"cp -r /usr/local/etc/php/conf.d /config/template/assets/config/php/$(VERSION)/; cp -r /usr/local/etc/php/assets /config/template/components/php/$(VERSION)/"
