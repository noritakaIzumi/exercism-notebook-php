#!/usr/bin/env bash

sudo cp -v exercism /usr/local/bin/
rm -v exercism

pushd /workspace
mv -v exercism-php php
popd
exercism configure --token=${EXERCISM_TOKEN} --workspace=/workspace
