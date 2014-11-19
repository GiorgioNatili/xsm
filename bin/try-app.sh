#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd "$DIR/.."

compass watch app/ &

./node_modules/.bin/supervisor --quiet --no-restart-on error app/app/try_app.js

kill %1
