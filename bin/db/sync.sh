#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd "$DIR/../.."

node app/db/run_sync.js 'tmp/trial-bft.sqlite' 'trial'
