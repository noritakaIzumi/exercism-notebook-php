#!/usr/bin/env bash

DIRECTORY_NAME=${1}
PROBLEM_NAME=${1}
BEFORE_FILENAME=${1}_test.php

if [ -z ${DIRECTORY_NAME} ]; then
  echo "Directory does not exist."
  exit 1
fi

if [ -e "./${DIRECTORY_NAME}/${BEFORE_FILENAME}" ]; then
  AFTER_FILENAME="$(grep -e '^class' ./${DIRECTORY_NAME}/${BEFORE_FILENAME} | cut -d' ' -f2).php"
  mv ./${DIRECTORY_NAME}/${BEFORE_FILENAME} ./${DIRECTORY_NAME}/${AFTER_FILENAME}
  ./vendor/bin/phpunit ./${DIRECTORY_NAME}/${AFTER_FILENAME}
  exit 0
fi

FILENAME=$(ls ./${DIRECTORY_NAME}/*Test.php)

if [ -e ${FILENAME} ]; then
  ./vendor/bin/phpunit ${FILENAME}
fi
