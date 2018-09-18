.PHONY: qa

all: qa

build:
	docker build . -f dev/Dockerfile -t serializer

run:
	docker run -ti --rm -v $(CURDIR):/src serializer sh

test:
	./vendor/phpunit/phpunit/phpunit tests -c dev/phpunit.xml

qa: test
	./vendor/phpstan/phpstan/bin/phpstan analyse --level 7 src
	./vendor/overtrue/phplint/bin/phplint src
	./vendor/squizlabs/php_codesniffer/bin/phpcs --standard=PSR2 src
	./vendor/squizlabs/php_codesniffer/bin/phpcbf --standard=PSR2 src
	./vendor/phpmd/phpmd/src/bin/phpmd src text dev/phpmd.xml
