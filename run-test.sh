#!/usr/bin/env bash

if [ -z "$1" ]; then
    echo "missing exercise slug"
    exit 1
fi

exercise_slug="${1}"
script_dir="$(
    # shellcheck disable=SC2164
    cd -- "$(dirname "${0}")" >/dev/null 2>&1
    pwd -P
)"
result_dir="${script_dir}/output/${exercise_slug}"

mkdir -p "${result_dir}"

MSYS_NO_PATHCONV=1 docker run --rm \
    --mount type=bind,src="${script_dir}/${exercise_slug}",dst=/solution \
    --mount type=bind,src="${result_dir}",dst=/output \
    exercism/php-test-runner "${exercise_slug}" /solution /output
