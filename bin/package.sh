#!/usr/bin/env bash

if [ $# -lt 1 ]; then
	echo "usage: $0 <version> [branch]"
	exit 1
fi

VERSION=$1
BRANCH=${4-development}
PACKAGE_DIR="./tmp/package/${VERSION}"

# Create the working directory
mkdir -p ${PACKAGE_DIR}

# Get an archive of our plugin
git archive ${BRANCH} --output ${PACKAGE_DIR}/package.tar.gz
tar -zxf ${PACKAGE_DIR}/package.tar.gz --directory ${PACKAGE_DIR} && rm ${PACKAGE_DIR}/package.tar.gz

# Run Composer
composer install --no-dev  --prefer-dist --optimize-autoloader --working-dir ${PACKAGE_DIR}
rm ${PACKAGE_DIR}/composer.json && rm ${PACKAGE_DIR}/composer.lock