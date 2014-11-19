#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd "$DIR/../.."

./node_modules/.bin/mocha app/server/**/test*.js
