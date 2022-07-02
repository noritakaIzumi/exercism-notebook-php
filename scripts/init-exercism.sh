#!/usr/bin/env bash

# install
mkdir -p tmp
pushd tmp
wget https://github.com/exercism/cli/releases/download/v3.0.13/exercism-linux-64bit.tgz
tar -xf exercism-linux-64bit.tgz
popd
mv tmp/exercism .
rm -r tmp

# configure
./exercism configure --token=${EXERCISM_TOKEN}
