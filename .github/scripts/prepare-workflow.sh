#!/usr/bin/env bash

# Install container structure test
curl -LO https://storage.googleapis.com/container-structure-test/latest/container-structure-test-linux-amd64 \
    && chmod +x container-structure-test-linux-amd64 \
    && sudo mv container-structure-test-linux-amd64 /usr/local/bin/container-structure-test

# Clone official docker repo for docker test suite
git clone https://github.com/docker-library/official-images.git ~/official-images

# Add "pgp-happy-eyeballs" to help cut down on gpg-related issues
wget -qO- 'https://github.com/tianon/pgp-happy-eyeballs/raw/master/hack-my-builds.sh' | bash

# Install orca.phar
curl -O https://orca-build.io/downloads/orca.zip \
    && unzip -o orca.zip

# Install prettier
npm install --save-dev --save-exact prettier

# Install composer dependencies
composer install --dev

# Generate all files
make generate
