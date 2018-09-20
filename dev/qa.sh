#!/usr/bin/env sh

/src/vendor/phpstan/phpstan/bin/phpstan analyse --level 7 src
/src/vendor/overtrue/phplint/bin/phplint -c dev/phplint.yml
/src/vendor/squizlabs/php_codesniffer/bin/phpcs --standard=PSR2 src
/src/vendor/squizlabs/php_codesniffer/bin/phpcbf --standard=PSR2 src
/src/vendor/phpmd/phpmd/src/bin/phpmd src text dev/phpmd.xml
