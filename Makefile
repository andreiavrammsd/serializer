.PHONY: build push install qa run clean

IMAGE := andreiavrammsd/serializer:php$(PHPVERSION)
VENDOR := ./vendor

all: qa

build: check-php-version
	docker build --build-arg PHPVERSION=$(PHPVERSION) . -f dev/Dockerfile -t $(IMAGE)

install: check-php-version
	docker run -ti --rm -v $(CURDIR):/src $(IMAGE) composer install

qa: check-php-version
	docker run -ti --rm -v $(CURDIR):/src $(IMAGE) make localqa

run: check-php-version
	docker run -ti --rm -v $(CURDIR):/src $(IMAGE) sh

clean: check-php-version
	docker rmi $(IMAGE) || true
	docker rmi php:$(PHPVERSION)-cli-alpine3.10 || true

localqa:
	$(VENDOR)/phpunit/phpunit/phpunit -c phpunit.xml
	$(VENDOR)/phpstan/phpstan/bin/phpstan analyse --level 7 --memory-limit 64M src
	$(VENDOR)/overtrue/phplint/bin/phplint -c phplint.yml
	$(VENDOR)/squizlabs/php_codesniffer/bin/phpcs --standard=PSR2 src
	$(VENDOR)/squizlabs/php_codesniffer/bin/phpcbf --standard=PSR2 src
	$(VENDOR)/phpmd/phpmd/src/bin/phpmd src text phpmd.xml

check-php-version:
ifndef PHPVERSION
	$(error PHPVERSION is not set)
endif

fulltest: check-php-version
	sudo rm -rf $(VENDOR) composer.lock && \
		make PHPVERSION=$(PHPVERSION) clean build install qa

testall:
	make fulltest PHPVERSION=7.1
	make fulltest PHPVERSION=7.2
	make fulltest PHPVERSION=7.3
	make fulltest PHPVERSION=7.4
