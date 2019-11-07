.PHONY: build push install qa run clean

ifndef PHPVERSION
$(error PHPVERSION is not set)
endif

IMAGE := andreiavrammsd/serializer:php$(PHPVERSION)
VENDOR := ./vendor

all: qa

build:
	docker build --build-arg PHPVERSION=$(PHPVERSION) . -f dev/Dockerfile -t $(IMAGE)

install:
	docker run -ti --rm -v $(CURDIR):/src $(IMAGE) composer install

qa:
	docker run -ti --rm -v $(CURDIR):/src -e PHPVERSION=$(PHPVERSION) $(IMAGE) make localqa

run:
	docker run -ti --rm -v $(CURDIR):/src -e PHPVERSION=$(PHPVERSION) $(IMAGE) sh

clean:
	docker rmi $(IMAGE)

localqa:
	${VENDOR}/phpunit/phpunit/phpunit -c phpunit.xml
	${VENDOR}/phpstan/phpstan/bin/phpstan analyse --level 7 --memory-limit 64M src
	${VENDOR}/overtrue/phplint/bin/phplint -c phplint.yml
	${VENDOR}/squizlabs/php_codesniffer/bin/phpcs --standard=PSR2 src
	${VENDOR}/squizlabs/php_codesniffer/bin/phpcbf --standard=PSR2 src
	${VENDOR}/phpmd/phpmd/src/bin/phpmd src text phpmd.xml
