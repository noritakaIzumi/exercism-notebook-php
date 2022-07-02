#!/usr/bin/env bash

# Install Exercism
pushd /tmp
wget https://github.com/exercism/cli/releases/download/v3.0.13/exercism-linux-64bit.tgz
tar -xf exercism-linux-64bit.tgz
cp -a ./exercism /usr/local/bin
popd

# Install packages
npm Install

# Build containers
docker-compose up --remove-orphans
