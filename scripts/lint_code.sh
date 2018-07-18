#!/bin/bash
set -eu
FILES=$(find . -not -path "./vendor/*" | grep "\.php$")
vendor/friendsofphp/php-cs-fixer/php-cs-fixer fix --path-mode=intersection --config=.php_cs.dist --diff --using-cache=no $FILES
