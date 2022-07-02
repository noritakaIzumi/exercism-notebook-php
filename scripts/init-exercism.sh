#!/usr/bin/env bash

# install
mkdir -p exercism
pushd exercism
wget https://github.com/exercism/cli/releases/download/v3.0.13/exercism-linux-64bit.tgz
tar -xf exercism-linux-64bit.tgz
popd
mv exercism/exercism .
rm -r exercism

# configure
./exercism configure --token=${EXERCISM_TOKEN}
